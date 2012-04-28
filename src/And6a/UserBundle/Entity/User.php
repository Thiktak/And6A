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
   * @ORM\Column(type="string", length="255")
   */
  protected $name;

  /**
   * @ORM\Column(type="string", length="255")
   */
  protected $fname;

  /**
   * @ORM\Column(type="date", nullable="true")
   */
  protected $birthday;

  /**
   * @ORM\OneToMany(targetEntity="\And6a\TrombiBundle\Entity\GroupsUser", mappedBy="users")
   */
  protected $groups;

  /**
   * @ORM\OneToMany(targetEntity="\And6a\UserBundle\Entity\Contact", mappedBy="user")
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
}