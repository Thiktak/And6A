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
   * @ORM\Column(type="string", length="255", nullable="true")
   */
  protected $name;

  /**
   * @ORM\Column(type="string", length="255", nullable="true")
   */
  protected $fname;

  /**
   * @ORM\Column(type="date", nullable="true")
   */
  protected $birthday;

  /**
   * @ORM\Column(type="string", length="255", nullable="true")
   */
  protected $avatar;

  /**
   * @ORM\OneToMany(targetEntity="\And6a\TrombiBundle\Entity\GroupsUser", mappedBy="users", cascade={"persist"})
   */
  protected $class_groups;

   /**
   * @ORM\ManyToMany(targetEntity="\And6a\UserBundle\Entity\User", inversedBy="filleuls")
   * @ORM\JoinTable(name="user_parrains")
   */
  protected $parrains;

  /**
   * @ORM\ManyToMany(targetEntity="\And6a\UserBundle\Entity\User", mappedBy="parrains")
   */
  protected $filleuls;

  /**
   * @ORM\OneToMany(targetEntity="\And6a\UserBundle\Entity\Contact", mappedBy="user", cascade={"persist"})
   */
  protected $contacts = null;
  

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
    $this->class_groups[] = $groups;
  }


  /**
   * Get groups
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getGroupsUser()
  {
    return $this->class_groups;
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
     * Set fname
     *
     * @param string $fname
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Add infos
     *
     * @param And6a\UserBundle\Entity\Contact $infos
     */
    public function addContact(\And6a\UserBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;
    }

    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set birthday
     *
     * @param date $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Get birthday
     *
     * @return date 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set contacts
     *
     * @param string $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }
    
    public function __toString()
    {
      if( empty($this->name) && empty($this->fname) )
        return implode('.', array_reverse(explode('.', $this->username)));
      else
        return strtoupper($this->name) . ' ' . $this->fname;
    }

    /**
     * Get class_groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getClassGroups()
    {
        return $this->class_groups;
    }

    /**
     * Get current
     *
     * @return And6a\TrombiBundle\Entity\GroupsUser 
     */
    public function getCurrent()
    {
      $current = null;
      
      foreach( $this -> class_groups as $groups )
        if( $groups->getGroups()->getIsClass() )
          if( empty($current) || $groups->getYear() > $current->getYear() )
            $current = $groups;
      return $current;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getUrlAvatar()
    {
      if( $this->avatar )
        return 'uploads/avatar/' . $this->avatar;
      return null;
    }

    /**
     * Add parrain
     *
     * @param And6a\UserBundle\Entity\User $parrain
     */
    public function addUser(\And6a\UserBundle\Entity\User $parrain)
    {
        $this->parrain[] = $parrain;
    }

    /**
     * Get parrains
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParrains()
    {
        return $this->parrains;
    }

    /**
     * Set parrains
     *
     * @param And6a\UserBundle\Entity\User $parrains
     */
    public function setParrains(\And6a\UserBundle\Entity\User $parrains)
    {
        $this->parrains = $parrains;
    }

    /**
     * Get filleuls
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFilleuls()
    {
        return $this->filleuls;
    }
}