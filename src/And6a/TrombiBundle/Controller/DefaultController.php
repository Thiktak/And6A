<?php

namespace And6a\TrombiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use And6a\TrombiBundle\Entity\Groups as Groups;
use And6a\TrombiBundle\Entity\GroupsUser as GroupsUser;
use And6a\UserBundle\Entity\User     as User;
use And6a\UserBundle\Entity\Contact  as Contact;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
      $em = $this->getDoctrine()->getEntityManager();
      $oUsers = $em->createQueryBuilder()
           ->select('u')
           ->from('And6aUserBundle:User', 'u')
           ->where('u.birthday IS NOT NULL')
           ->orderBy('u.birthday', 'DESC')
           ->setMaxResults(5)
           ->getQuery()
           ->getResult();

      $edito  = '<p>Bienvenue à tous sur la nouvelle version du trombi</p>';
      $edito .= '<p>Au programme : une refonte totale (Symfony2), un nouveau graphisme et de nouvelles fonctions (map, anniversaires, annonces, informations privées, ...)</p>';

      //$this->IMPORT();

      return $this->render('And6aTrombiBundle:Default:index.html.twig', array(
        'edito' => $edito,
        'birthdays' => $oUsers,
      ));
    }

    protected function IMPORT() {
      set_time_limit(0);
      $em = $this->getDoctrine()->getEntityManager();
      $pdo = new \PDO('mysql:host=localhost;dbname=ensisa_1a_trombi', 'root');

      $sql = 'SELECT * FROM trombi_old';

        /*$entity = new Contact();
        $entity->setType('addr_mulh');
        $entity->setValue('ahahah');
        $entity->setUser(1);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();*/

      foreach( $pdo -> query($sql) as $row )
      {
        try {
          $row['prenom'] = trim($row['prenom']);
          $row['nom']    = trim($row['nom']);

          $username = minusculesSansAccents($row['prenom'] . '.' . $row['nom']);
          $password = minusculesSansAccents($row['prenom']);
          $email    = $row['email'] ?: $username . '@uha.fr';

          if( $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneByUsername($username) )
          {
            echo '<div class="alert">', $username, ' already exists</div>';
            continue;
          }

          $user = $this->get('fos_user.util.user_manipulator')->create($username, $password, $email, 1, 0);

          //$user = $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneByUsername($username);

          echo '(' . $username . ', ' . $password . ', ' . $email . ', 1, 0)<br />';

          //$user = new User();
          $user->setName($row['nom']);
          $user->setFname($row['prenom']);
          
          if( $row['date_naissance'] )
            $user->setBirthday(new \DateTime($row['date_naissance']));
          $user->setAvatar($row['photo']);


          $addr = trim($row['adresse_mulhouse'] . ' ' . $row['cp_mulhouse'] . ' ' . $row['ville_mulhouse']);
          if( $addr ) {
            $entity = new Contact();
            $entity->setType('addr');
            $entity->setValue($addr);
            $entity->setUser($user);
            if( trim($entity->getValue()) )
              $user->addContact($entity);
          }

          $addr = trim($row['adresse_parents'] . ' ' . $row['cp_parents'] . ' ' . $row['ville_parents']);
          if( $addr ) {
            $entity = new Contact();
            $entity->setType('addr_p');
            $entity->setValue($addr);
            $entity->setUser($user);
            if( trim($entity->getValue()) )
              $user->addContact($entity);
          }
          if( trim($row['tel_mobile']) ) {
            $entity = new Contact();
            $entity->setType('tel');
            $entity->setValue($row['tel_mobile']);
            $entity->setUser($user);
            if( trim($entity->getValue()) )
              $user->addContact($entity);
          }
          
          if( trim($row['tel_fixe']) ) {
            echo $row['tel_fixe'];
            $entity = new Contact();
            $entity->setType('tel_f');
            $entity->setValue($row['tel_fixe']);
            $entity->setUser($user);
            if( trim($entity->getValue()) )
              $user->addContact($entity);
          }

          $corresp = array(1, 4, 3, 5, 2);

          if( $row['filiere_id'] < 6 )
          {

            $group = $this->getDoctrine()->getRepository('And6aTrombiBundle:Groups')->findOneById($corresp[$row['filiere_id']-1]);

            $entity = new GroupsUser();
            $entity->setYear($row['promotion_id']+2008);
            $entity->setLevel(1);
            $entity->setGroups($group);
            $entity->setUsers($user);
            $user->addGroupsUser($entity);

            if( $row['promotion_id']*2008+1 <= 2012 )
            {
              $entity = new GroupsUser();
              $entity->setYear($row['promotion_id']+2008+1);
              $entity->setLevel(2);
              $entity->setGroups($group);
              $entity->setUsers($user);
              $user->addGroupsUser($entity);

              if( $row['promotion_id']+2008+2 <= 2012 )
              {
                $entity = new GroupsUser();
                $entity->setYear($row['promotion_id']+2008+2);
                $entity->setLevel(3);
                $entity->setGroups($group);
                $entity->setUsers($user);
                $user->addGroupsUser($entity);
              }
              //*/
            }
          }

          $em->persist($user);
        }
        catch(Exception $e) {
          EntityDump($e->getMessage());
        }
      }
      $em->flush();
    }
}

function minusculesSansAccents($texte)
{
    $texte = mb_strtolower(utf8_encode($texte), 'UTF-8');
    $texte = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í', 
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
            'ù', 'û', 'ü', 'ú', 
            'é', 'è', 'ê', 'ë', 
            'ç', 'ÿ', 'ñ', 
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a', 
            'i', 'i', 'i', 'i', 
            'o', 'o', 'o', 'o', 'o', 'o', 
            'u', 'u', 'u', 'u', 
            'e', 'e', 'e', 'e', 
            'c', 'y', 'n', 
        ),
        $texte
    );
 
    return $texte;        
}