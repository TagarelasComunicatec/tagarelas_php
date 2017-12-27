<?php
namespace SessionBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Rule;
use AppBundle\Utility\AppRest;
use AppBundle\Openfire\Ofmucroom;
use AppBundle\Openfire\Ofmucaffiliation;
use AppBundle\Openfire\Ofmucmember;
use AppBundle\Openfire\Ofmucroomprop;
use AppBundle\Utility\Utils;
use Doctrine\ORM\Mapping\OrderBy;
use AppBundle\AppBundle;

// @@TODO Session = ChatRoom no Openfire.
// @@TODO Alterar método save utilizando REST API.
// @@TODO Refazer as queries utilizando Openfire.
// @@TODO Corrigir o banco de dados incluindo ID.
// @@TODO Rotina de agenda
// @@TODO Ver qual a melhor técnica de chat para resolver chatroom.
// @@TODO Muitos dos chats funcionam com BOSH
class SessionService
{

    const SESSION_FOUND = 1;

    const SESSION_NOT_FOUND = 2;

    const LIFETIME = "LIFETIMEINMINUTES";

    protected $em;

    private $container;

    private $logger;

    private $roomid;

    private $jidsProcessados = [];

    /**
     * Construtor do Serviço
     * ---------------------
     * 
     * @param EntityManager $entityManager
     * @param Container $cont
     * @param Logger $log
     */
    public function __construct(EntityManager $entityManager, Container $cont, Logger $log)
    {
        $this->em = $entityManager;
        $this->container = $cont;
        $this->logger = $log;
    }

    /**
     * Carrega todas as sessões
     * ------------------------
     * 
     * @param number $limit
     * @param number $status
     * @param string $email
     *
     */
    public function loadAllSession($limit = 0, $status = 0,$email = '')
    {
        $qb = $this->em->createQueryBuilder();
        $now = strval(Utils::dateAsLong('now'));
        
        $qb->select('s.roomid as roomid, s.name as name, s.description as description, '.
                    's.creationdate as creationdate, s.publicroom as public, ' . 
                    'ma.jid as majid, me.jid as mejid')
            ->from('AppBundle:Ofmucroom', 's')
            ->leftJoin('AppBundle:Ofmucmember', 'me',
                       \Doctrine\ORM\Query\Expr\Join::WITH, 's.roomid = me.roomid')
            ->leftJoin('AppBundle:Ofmucaffiliation', 'ma',
                       \Doctrine\ORM\Query\Expr\Join::WITH, 's.roomid = ma.roomid')
            ->where('s.creationdate >= :now')
            ->setParameter('now', $now)
            ->orderby("s.creationdate");
        
        if (0 != $limit)
            $qb->setMaxResults($limit);
        
        $sessions = $qb->getQuery()->getResult();
        $myReturn = array();
        foreach ($sessions as $session){
            if ($email == $session['majid'] || $email == $session['mejid'] ){
                $this->logger->info("SessionService.loadAllSessions creationdate-> " .
                        $session['creationdate']);
                $mySession = new \AppBundle\Entity\Session();
                $mySession->loadFromQuery($session);
                $myReturn[] = $mySession;
            }
            
        }
        $this->logger->info("SessionService.loadAllSessions now-> $now");
        $this->logger->info("SessionService.loadAllSessions myResults-> " . json_encode($myReturn));
        
        
        return $myReturn;
    }

    /**
     * Carrega as sessões por status
     * -----------------------------
     */
    public function loadSessionByStatus()
    {
        $userEmail = "";
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $limit = intval($request->get("limit"));
        $status = $request->get("status");
        
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->container->get('security.token_storage')
            ->getToken()
            ->getUser();
            $userEmail = $user->getEmail();
        }
        
        $Sessions = $this->loadAllSession($limit, $status, $userEmail);
      
        return $Sessions;
    }

    public function findSessionByName($sessionName)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('s.name')
            ->from('AppBundle:Ofmucroom', 's')
            ->where('s.name LIKE :sessionName')
            ->setParameter('sessionName', $sessionName);
        
        $myReturn = $qb->getQuery()->getResult();
        
        return $myReturn;
    }

    /**
     * Retorna o proximo elemento de sessão
     */
    private function getNextSession()
    {
        $newroomid = $this->em->createQueryBuilder()
            ->select('MAX(e.roomid)')
            ->from('AppBundle:Ofmucroom', 'e')
            ->getQuery()
            ->getSingleScalarResult();
        return $newroomid + 1;
    }

    /**
     * Salva o proprietário da sessão
     * 
     * @param User $user
     *            objeto usuário
     */
    private function saveAffiliate($user)
    {
        $ofmucaffiliation = new Ofmucaffiliation();
        $ofmucaffiliation->loadData($this->roomid, $user->getEmail(), Ofmucaffiliation::OWNER);
        $this->em->persist($ofmucaffiliation);
    }

    /**
     * Salva grupos para sessão
     * 
     * @param array $groups
     * @param string $user
     */
    private function saveGroup($groups, $user = '')
    {
        for ($i = 0; $i < sizeof($groups); ++ $i) {
            $group = $groups[$i];
            $qb = $this->em->createQueryBuilder();
            $members = $qb->select('gu.username')
                ->from("AppBundle:Ofgroupuser", "gu")
                ->where("gu.groupname = :groupname")
                ->setParameter("groupname", $group["groupname"])
                ->getQuery()
                ->getResult();
            
            $this->logger->info("SessionService.saveGroup getType members -> " . json_encode($members));
            
            $this->saveUserMembers($members, $user);
        }
    }

    /**
     * Salva convidados para a sessão
     * 
     * @param array $members
     * @param string $user
     */
    private function saveUserMembers($members = [], $user = '')
    {
        for ($i = 0; $i < sizeof($members); ++ $i) {
            $member = $members[$i];
            if ($member["username"] != $user) {
                $ofuser = $this->em->find('AppBundle:Ofuser', $member["username"]);
                
                $this->logger->info("SessionService.saveUserMembers OfUser -> " . $ofuser->__toString());
                
                $this->saveSingleUSer($ofuser);
            }
        }
    }

    /**
     * Salva a duração da sessão em minutos
     * 
     * @param number $minutes
     */
    private function saveSessionDuration($minutes = 0)
    {
        $prop = new Ofmucroomprop();
        $prop->loadData($this->roomid, $this::LIFETIME, $minutes);
        $this->em->persist($prop);
    }

    /**
     * Salva um membro na sala de discussão
     * 
     * @param Ofuser $ofuser
     */
    private function saveSingleUSer($ofuser)
    {
        /*
         * O cliente jã estã cadastrado na sessão
         */
        $jid = $ofuser->getEmail();
        if ($jid == null || $this->existMemberInRoom($this->roomid, $jid)) {
            return;
        }
        try {
            $ofmucmember = new Ofmucmember();
            $ofmucmember->loadData($this->roomid, $ofuser);
            $this->em->persist($ofmucmember);
            $this->jidsProcessados[] = $jid;
        } catch (\Exception $e) {
            return;
        }
        return;
    }

    /**
     * Verifica se existe o membro dentro da sessão.
     * 
     * @param number $roomid
     * @param string $jid
     * @return boolean
     */
    private function existMemberInRoom($roomid = 0, $jid = '')
    {
        
        /*
         * Verifica se o jid jã foi processado.
         */
        for ($i = 0; $i < sizeof($this->jidsProcessados); ++ $i) {
            if ($jid == $this->jidsProcessados[$i]) {
                return true;
            }
        }
        
        $qb = $this->em->createQueryBuilder();
        $result = $qb->select('count(m.roomid)')
            ->from('AppBundle:Ofmucmember', 'm')
            ->where('m.roomid = :roomid')
            ->andwhere('m.jid = :jid')
            ->setParameter('roomid', $roomid)
            ->setParameter('jid', $jid)
            ->getQuery()
            ->getSingleScalarResult();
        $this->logger->info("SessionService.existMemberInRoom ? -> $result ");
        
        return $result > 0;
    }

    /**
     * Salva a sessão (room)
     * 
     * @return number
     */
    public function save()
    {
        try {
            
            $request = $this->container->get('request_stack')->getCurrentRequest();
            
            // Impede de que um jid seja inserido mais de uma vez.
            $this->jidsProcessados = [];
            
            $groups = $request->get("groups");
            $members = $request->get("users");
            $minutes = $request->get("durationSession");
            
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->container->get('security.token_storage')
                    ->getToken()
                    ->getUser();
                $usernameLogged = $user->getUsername();
            }
            
            $this->roomid = $this->getNextSession();
            
            $this->logger->info("SessionService.save newroomid gerado -> " . $this->roomid);
            
            $this->logger->info("SessionService.save usernameLogged -> $usernameLogged");
            $this->logger->info("SessionService.save useremail -> " . $user->getEmail());
            
            $ofmucroom = new Ofmucroom();
            $ofmucroom->loadFromRequest($request, $this->roomid);
            $this->em->persist($ofmucroom);
            
            $this->saveSessionDuration($minutes);
            
            $this->saveAffiliate($user);
            
            $this->logger->info("SessionService.save getType groups -> " . gettype($groups));
            
            $this->logger->info("SessionService.save getType members -> " . gettype($members));
            
            $this->saveGroup($groups, $user);
            $this->saveUserMembers($members, $user);
            
            $this->em->flush();
        } catch (\Exception $e) {
            
            $this->logger->error("Sessao nao foi salva " . $e->__toString());
            return Rule::FAIL_SAVE;
        }
        return Rule::SUCCESS_SAVE;
    }
}