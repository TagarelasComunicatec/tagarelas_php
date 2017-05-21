<?php
namespace GroupBundle\Service;


use AppBundle\AppBundle;
use AppBundle\Entity\Group;
use AppBundle\Entity\GroupUser;
use AppBundle\Entity\Rule;
use AppBundle\Entity\User;
use AppBundle\Openfire\Ofgroupprop;
use AppBundle\Utility\AppRest;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;



//@@TODO refazer as queries utilizando Openfire.
//@@TODO corrigir o banco de dados retirando ID (colocado indevidamente).
//@@TODO Falta salvar os usuários no grupo.


class GroupService {
	const NAME_FOUND     = 1;
	const NAME_NOT_FOUND = 2;

	
	const FIND_BY_NAME = 3;
	const FIND_BY_CREATOR = 4;

	const AVATAR = 'AVATAR';
	
	protected $em;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	
	public function loadAllGroups($limit = 0){
		$qb = $this->em->createQueryBuilder();
		$qb->select('g.groupname,g.description')
		   ->from('AppBundle:Group', 'g')
		   ->join('AppBundle:GroupUser', 'gu', Join::WITH,'gu.idGroup = g.id')
		   ->groupBy('g.id,g.groupName')
		   ->orderBy('g.groupName');
		
		 if (0 != $limit)
		   	$qb->setMaxResults($limit);
		
		 $myReturn =  $qb->getQuery()->getResult();
		 return $myReturn;
	}
	/**
	 * Load user groups by status and user
	 * select gp.groupname, gu.username, gp.name, gp.propvalue
from ofgroupuser gu 
inner join ofgroupprop gp on gu.groupname = gp.groupname
where gu.username = 'ricardo2' and  (gp.name= 'ricardo2' or gp.name = 'AVATAR')
	 */
	public function loadGroupByStatus(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$limit   = intval($request->get("limit"));
		$userId =  $this->container->get('session')->get('userId');
		$status =  $request->get("status");
		/*
		 * ----------------------------------------------------------
		 * Carrega os usuarios com o sustaus definidos em ofgroupprop
		 * ----------------------------------------------------------
		 */
		$qb = $this->em->createQueryBuilder()
		               ->select('gp.groupname,gu.name')
		               ->from('AppBundle:Ofgroupprop', 'gp')
		               ->where('gu.name = :name')
		               ->andWhere('gu.propvalue = :propValue')
		               ->setParameter("name", $userId)
		               ->setParameter('propValue', $status);
		
		if (0 != $limit)
			$qb->setMaxResults($limit);
		
		$groups =  $qb->getQuery()->getResult();
		$myReturn = array();
		$count = 0;
		foreach ($groups as $group){
			$avatar = $this->loadAvatar($group->groupname);
			$totalMembers =  $this->loadTotalMembers($group->groupname);
			$myReturn[$count]= array('groupname'=>$group->groupname, 
						             'avatar'=>$avatar, 
					                 'totalMembers'=>$totalMembers);
			++$count;
		}
		return $myReturn;
	}
	
	
	private function loadAvatar($groupname){
		
	}
	private function loadTotalMembes($groupname){
		
	}
	
	/**
	 * @param QueryBuilder $qb
	 * @param Group        $group
	 * @param int		   $userId
	 * @param int		   $status
	 * @param array		   $myReturn
	 */
	private function loadGroupUserInformation($group,$userId,$status, &$myReturn){
		$groupsuser = $this->generateQueryGroupUser($group, $userId, $status);
		foreach($groupsuser as $gu){
			$group["userStatus"] = $gu["userStatus"];
			$myReturn[ ] = $group;
		}
		return $myReturn;
	}
	/**
	 * @param Group        $group
	 * @param int		   $user
	 * @param int		   $status
	 */
	private function generateQueryGroupUser($group,$userId,$status){
		$qb = $this->em->createQueryBuilder();
		$qb->select('gu.groupname,gu.idUser, gu.idGroup ,gu.userStatus')
			->from('AppBundle:ofGroup', 'gu')
			->where('gu.idGroup = :idGroup')
			->andwhere('gu.idUser = :idUser')
			->andWhere('gu.userStatus = :status')
			->setParameter("idGroup", $group["id"])
			->setParameter('idUser', $userId)
			->setParameter('status', $status);
		return  $qb->getQuery()->getResult();
	}
	
	public function findGroupByKey($key,$value){
		$qb = $this->em->createQueryBuilder();
		$qb->select('g.groupname,g.description')
			->from('AppBundle:Ofgroup', 'g');
		
		if (GroupService::FIND_BY_CREATOR==$key){
			$qb->where('g.createdBy = :value')
	   	       ->setParameter('value', $value );
		} else {
			$qb->where('g.groupname = :value')
			->setParameter('value', $value );
		}

		$myReturn =  $qb->getQuery()->getResult();
		return $myReturn;
	}
	
	
	public function save(){
		try{
			$request = $this->container->get('request_stack')->getCurrentRequest();
			$groupName   = $request->get("groupName");
			if (count($this->findGroupByKey(GroupService::FIND_BY_NAME,$groupName)) >0){
				throw new \Exception('Nome Grupo já está cadastrado. ' .
						'Não foi possível cadastrar o grupo. ');
			}
		   
			AppRest::doConnectRest()->createGroup($groupName);
			$this->em->flush ();
			$avatar = $this->persistImage();
			$groupAttribute = new Ofgroupprop();;
			$groupAttribute->doLoadAll($groupName, GroupService::AVATAR, $avatar);
			$this->em->merge($groupAttribute);
			$this->em->flush ();
		    return Rule::SUCCESS_SAVE;
		} catch(Exception $e){
			$this->logger->error("Conteudo de error by reference " . $e->__toString());
			return Rule::FAIL_SAVE;
		}

	}

	private function persistImage(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$file = $request->files->get("file");
		$path = $this->container->getParameter('group_images_directory') .'/';
		if (is_null($file)) {
			return 'default.png';
		}
		$filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();
		$this->logger->info("arquivo de imagem salvo:" . $filename);
		
		$file->move( $path, $filename);
		return $filename;
	}

	/**
	 * Altera o status dos usuarios em um grupo grupo
	 * @param unknown $username - nome do usuario
	 * @param unknown $groupname - nome do usuario. 
	 * @param unknown $rule - Veja as regas em Rules.php 
	 */
	public function saveGroupUserRule($username, $groupname, $rule){
		$this->em->flush ();
		$groupAttribute = new Ofgroupprop();;
		$groupAttribute->doLoadAll($groupname, $username, $rule);
		$this->em->merge($groupAttribute);
		$this->em->flush ();
	}
	
}