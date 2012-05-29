<?php

namespace And6a\TrombiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * And6a\TrombiBundle\Entity\Groups
 */
class Groups
{
  
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $slug
     */
    private $slug;

    /**
     * @var text $descr
     */
    private $descr;

    /**
     * @var boolean $isclass
     */
    private $isclass;

    /**
     * @var And6a\TrombiBundle\Entity\GroupsUser
     */
    private $users;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set descr
     *
     * @param text $descr
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
    }

    /**
     * Get descr
     *
     * @return text 
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set isclass
     *
     * @param boolean $isclass
     */
    public function setIsclass($isclass)
    {
        $this->isclass = $isclass;
    }

    /**
     * Get isclass
     *
     * @return boolean 
     */
    public function getIsclass()
    {
        return $this->isclass;
    }

    /**
     * Add users
     *
     * @param And6a\TrombiBundle\Entity\GroupsUser $users
     */
    public function addGroupsUser(\And6a\TrombiBundle\Entity\GroupsUser $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }


    public function __toString() {
        return $this->name;
    }
}