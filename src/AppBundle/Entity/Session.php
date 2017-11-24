<?php
namespace AppBundle\Entity;
class Session {
    private     $sessionName,
                $datetimeSession,
                $users,
                $groups,
                $visibility,
                $description,
                $durationSession,
                $public,
                $moderated,
                $membersonly,
                $allowinvites,
                $changesubject,
                $reservednick,
                $canchangenick,
                $registration,
                $totalusers,
                $enablelogging;

     public function __construct(){
         
     }
     
     public function loadFromRequest($request){
         $this->sessionName     = $request->get('sessionName') ;
         $this->datetimeSession = $request->get('datetimeSession');
         $this->users           = $request->get('users');
         $this->groups          = $request->get('groups') ;
         $this->visibility      = $request->get('visibility');
         $this->description     = $request->get('description');
         $this->durationSession = $request->get('durationSession');
         $this->public          = $request->get('public');
         $this->moderated       = $request->get('moderated');
         $this->membersonly     = $request->get('membersonly');
         $this->allowinvites    = $request->get('allowinvites');
         $this->changesubject   = $request->get('changesubject');
         $this->reservednick    = $request->get('reservednick');
         $this->canchangenick   = $request->get('canchangenick');
         $this->registration    = $request->get('registration');
         $this->enablelogging   = $request->get('enablelogging');
         $this->totalusers      = $request->get('totalusers');
     }
     
     public function moveToPayload( $payload, $username=''){
         $payload->setRoomName($this->sessionName );
         $payload->setNaturalName($this->sessionName );
         $payload->setDescription($this->description );
         $payload->setAdmins(array($username));
         $payload->setOutcastGroups(array($this->groups ,$this->users ));
         $payload->setCanAnyoneDiscoverJID(false);
         $payload->setCanOccupantsChangeSubject(false);
         $payload->setMaxUsers($this->totalusers);
         $payload->setPersistent(true);
         $payload->setpublicRoom($this->visibility);
         $payload->setRegistrationEnabled($this->registration);
         $payload->setCanAnyoneDiscoverJID($this->reservednick);
         $payload->setCanOccupantsChangeSubject($this->changesubject);
         $payload->setCanOccupantsInvite($this->allowinvites);
         $payload->setCanChangeNickname($this->canchangenick);
         $payload->setLogEnabled($this->enablelogging);
         $payload->setLoginRestrictedToNickname(false);
         $payload->setMembersOnly($this->membersonly);
         $payload->setModerated($this->moderated);
         $payload->setOwners(array($username));

         return $payload;
     }
     
    /**
     * @return mixed
     */
    public function getSessionName()
    {
        return $this->sessionName;
    }

    /**
     * @return mixed
     */
    public function getDatetimeSession()
    {
        return $this->datetimeSession;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getDurationSession()
    {
        return $this->durationSession;
    }

    /**
     * @return mixed
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @return mixed
     */
    public function getModerated()
    {
        return $this->moderated;
    }

    /**
     * @return mixed
     */
    public function getMembersonly()
    {
        return $this->membersonly;
    }

    /**
     * @return mixed
     */
    public function getAllowinvites()
    {
        return $this->allowinvites;
    }

    /**
     * @return mixed
     */
    public function getChangesubject()
    {
        return $this->changesubject;
    }

    /**
     * @return mixed
     */
    public function getReservednick()
    {
        return $this->reservednick;
    }

    /**
     * @return mixed
     */
    public function getCanchangenick()
    {
        return $this->canchangenick;
    }

    /**
     * @return mixed
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @return mixed
     */
    public function getEnablelogging()
    {
        return $this->enablelogging;
    }

    /**
     * @param mixed $sessionName
     */
    public function setSessionName($sessionName)
    {
        $this->sessionName = $sessionName;
        return $this;
    }

    /**
     * @param mixed $datetimeSession
     */
    public function setDatetimeSession($datetimeSession)
    {
        $this->datetimeSession = $datetimeSession;
        return $this;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $durationSession
     */
    public function setDurationSession($durationSession)
    {
        $this->durationSession = $durationSession;
        return $this;
    }

    /**
     * @param mixed $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @param mixed $moderated
     */
    public function setModerated($moderated)
    {
        $this->moderated = $moderated;
        return $this;
    }

    /**
     * @param mixed $membersonly
     */
    public function setMembersonly($membersonly)
    {
        $this->membersonly = $membersonly;
        return $this;
    }

    /**
     * @param mixed $allowinvites
     */
    public function setAllowinvites($allowinvites)
    {
        $this->allowinvites = $allowinvites;
        return $this;
    }

    /**
     * @param mixed $changesubject
     */
    public function setChangesubject($changesubject)
    {
        $this->changesubject = $changesubject;
        return $this;
    }

    /**
     * @param mixed $reservednick
     */
    public function setReservednick($reservednick)
    {
        $this->reservednick = $reservednick;
        return $this;
    }

    /**
     * @param mixed $canchangenick
     */
    public function setCanchangenick($canchangenick)
    {
        $this->canchangenick = $canchangenick;
        return $this;
    }

    /**
     * @param mixed $registration
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;
        return $this;
    }

    /**
     * @param mixed $enablelogging
     */
    public function setEnablelogging($enablelogging)
    {
        $this->enablelogging = $enablelogging;
        return $this;
    }
     
}