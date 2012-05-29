<?php

namespace And6a\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use And6a\UserBundle\Entity\User as User;

class DefaultController extends Controller
{
  public function viewAction(User $user)
  { 
    $timeline = array();
    $i = 0;
    foreach( $user->getGroupsUser() as $groups )
    {
      $timeline[$groups->getYear()][$groups->getGroups()->getIsClass() . $i++] = $groups;
    }
    
    return $this->render('And6aUserBundle:Default:view.html.twig', array(
      'user' => $user,
      'timeline' => $timeline,
    ));
  }

  public function avatarAction()
  {
    $utilisateur= $this->container->get('security.context')->getToken()->getUser();
    
    //create a simple form with one filed called "dataFile" of type "file"
    $form = $this->get('form.factory')
   ->createBuilder('form')
   ->add('avatar', 'file', array('required' => true))
   ->getForm();

    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
        //bind the request, (note the enctype in the template)
        $form->bindRequest($request); 

      if ($form->isValid()) {
            //if the form is valid, try to get the uploaded file object
            //Symfony\Component\HttpFoundation\File\UploadedFile
          $files=$request->files->get($form->getName());
          
          //die(EntityDump(array($files['avatar']), 1));

          $uploadedFile=$files['avatar']; //"dataFile" is the name on the field
          

          //once you have the uploadedFile object there is some sweet functions you can run
          $uploadedFile->getPath();//returns current (temporary) path
          $name = $uploadedFile->getClientOriginalName();
          $ext = pathinfo($name, PATHINFO_EXTENSION);
          
          
          $user = $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneById($utilisateur->getId());
          //and most important is move(),
          $uploadedFile->move(
            $dir = __DIR__.'/../../../../web/uploads/avatar',
            $file = $utilisateur->getId() . '.' . $ext
          );

          $user->setAvatar($file);
          $em = $this->getDoctrine()->getEntityManager();
          $em->persist($user);
          $em->flush();

          $this->get('session')->setFlash('notice', 'The file is uploaded !');
      }
      else{
        //form is not valid
      }
    }//end if request method == POST  

    return $this->render('And6aUserBundle:Default:avatar.html.twig', array(
      'form'=>$form->createView(),
      'img_avatar' => 'uploads/avatar/' . $utilisateur->getAvatar(),
    ));
  }

  public function getBadgeAction($user = null, $style = 'badge', $withLink = true)
  {
    //if( (!is_object($user) || !$user->getId()) )
    //  $user = $this->getDoctrine()->getRepository('And6aUserBundle:User')->findOneById(is_array($user) ? $user['id'] : $user);

    //$user['avatar'] = 'bundles/and6auser/images/empty-avatar.png';
    //EntityDump($user);
    return $this->render('And6aUserBundle:Default:badge.html.twig', array(
  		'user'  => $user,
  		'style' => $style,
  		'withLink' => $withLink,
	  ));
  }
}
