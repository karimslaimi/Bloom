<?php

namespace DoraBundle\Controller;

use DoraBundle\Entity\Jardin;
use DoraBundle\Form\JardinType;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/profile/{id}", name="admin_profile")
     */
    public function PorfileAction(Request $request, User $admin){
        //$admin = $this->container->get('security.token_storage')->getToken()->getUser();



        $editForm=$this->createForm(UserType::class,$admin);
        $editForm->remove("roles");
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()){
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($admin);
           return $this->render("@Dora/Admin/editProfile.html.twig",array("msg"=>"Profile modifié","edit_form"=>$editForm->createView(),"admin"=>$admin));
        }else if($editForm->isSubmitted() &&!$editForm->isValid()){
            return $this->render("@Dora/Admin/editProfile.html.twig",array("error"=>"Les champs sont invalide","edit_form"=>$editForm->createView(),"admin"=>$admin));

        }
        return $this->render("@Dora/Admin/editProfile.html.twig",array("edit_form"=>$editForm->createView(),"admin"=>$admin));





}

    /**
     * @Route("/jardin/{id}", name="jardin_profile")
     */
    public function JardinAction(Request $request, Jardin $admin){
        //$admin = $this->container->get('security.token_storage')->getToken()->getUser();



        $editForm=$this->createForm(JardinType::class,$admin);
        $editForm->remove("roles");
        $editForm->handleRequest($request);

        if($editForm->isSubmitted() && $editForm->isValid()){
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($admin);
            return $this->render("@Dora/Admin/editJardin.html.twig",array("msg"=>"les donnés ont été modifié","edit_form"=>$editForm->createView(),"admin"=>$admin));
        }else if($editForm->isSubmitted() &&!$editForm->isValid()){
            return $this->render("@Dora/Admin/editJardin.html.twig",array("error"=>"Les champs sont invalide","edit_form"=>$editForm->createView(),"admin"=>$admin));

        }
        return $this->render("@Dora/Admin/editJardin.html.twig",array("edit_form"=>$editForm->createView(),"admin"=>$admin));





    }




}
