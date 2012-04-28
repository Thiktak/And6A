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
   * @var smallint $year
   */
  private $year;

  /**
   * @var string $role
   */
  private $role;

  

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
   * @var string $name
   */
  private $name;

  /**
   * @var string $salt
   */
  private $salt;

  /**
   * @var text $descr
   */
  private $descr;

  /**
   * @var boolean $isclass
   */
  private $isclass;


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
   * Set salt
   *
   * @param string $salt
   */
  public function setSalt($salt)
  {
    $this->salt = $salt;
  }

  /**
   * Get salt
   *
   * @return string 
   */
  public function getSalt()
  {
    return $this->salt;
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
   * @var string $slug
   */
  private $slug;


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
   * @var And6a\TrombiBundle\Entity\GroupsUser
   */
  private $users;

  public function __construct()
  {
    $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
}