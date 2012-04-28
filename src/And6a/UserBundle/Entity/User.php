<?php
// src/And6a/UserBundle/Entity/User.php

namespace And6a\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="\And6a\TrombiBundle\Entity\GroupsUser", mappedBy="users")
     */
    protected $groups;

    public function __construct()
    {
        parent::__construct();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();

        // your own logic
    }

    /**
     * Add gruops
     *
     * @param And6a\TrombiBundle\Entity\GroupsUser $groups
     */
    public function addGroupsUser(\And6a\TrombiBundle\Entity\GroupsUser $groups)
    {
        $this->groups[] = $groups;
    }


    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

}