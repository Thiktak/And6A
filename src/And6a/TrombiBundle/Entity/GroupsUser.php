<?php

namespace And6a\TrombiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class GroupsUser
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $group_id
     */
    private $group_id;

    /**
     * @var integer $user_id
     */
    private $user_id;

    /**
     * @var smallint $year
     */
    private $year;

    /**
     * @var string $role
     */
    private $role;

    /**
     * @var And6a\TrombiBundle\Entity\Groups
     */
    private $groups;

    /**
     * @var And6a\UserBundle\Entity\User
     */
    private $users;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group_id
     *
     * @param integer $groupId
     */
    public function setGroupId($groupId)
    {
        $this->group_id = $groupId;
    }

    /**
     * Get group_id
     *
     * @return integer 
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set year
     *
     * @param smallint $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Get year
     *
     * @return smallint 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set groups
     *
     * @param And6a\TrombiBundle\Entity\Groups $groups
     */
    public function setGroups(\And6a\TrombiBundle\Entity\Groups $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Get groups
     *
     * @return And6a\TrombiBundle\Entity\Groups 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set users
     *
     * @param And6a\UserBundle\Entity\User $users
     */
    public function setUsers(\And6a\UserBundle\Entity\User $users)
    {
        $this->users = $users;
    }

    /**
     * Get users
     *
     * @return And6a\UserBundle\Entity\User 
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var string $level
     */
    private $level;


    /**
     * Set level
     *
     * @param string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }
}