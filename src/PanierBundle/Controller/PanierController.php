<?php


namespace PanierBundle\Controller;


use PanierBundle\Entity\Panier;
use PanierBundle\Entity\Panier_element;
use PanierBundle\PanierBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{

    public  function  commandeAction(){

        $panier = explode(",", $_COOKIE["card"]);
        $paneirObjext = [];
        $i = 0;
        foreach ($panier as $card) {
            $i++;

            $cardObject = str_replace('&#44', ',', $card);
            if ($i <> 0)

                $cardObj = json_decode($cardObject);

            array_push($paneirObjext, $cardObj);
        }
        $total = 0;
        for ($j = 1; $j < sizeof($paneirObjext); $j++) {
            $total += $paneirObjext[$j]->prix;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $panier = new Panier();
        $panier->setTotal($total);
        $panier->setDate(new \DateTime());
        $entityManager->persist($panier);
        for ($k = 1; $k < sizeof($paneirObjext); $k++) {
            $panier_element = new Panier_element();
            $panier_element->setNom($paneirObjext[$k]->nom);
            $panier_element->setPrix($paneirObjext[$k]->prix);
            $panier_element->setPanier($panier);
            $entityManager->persist($panier_element);

        }
        //unset($_COOKIE['card']);
        // setcookie("card", "", time() - 3600);


        $entityManager->flush();

        return $this->redirectToRoute('Page_Client');

    }


    public function AffichBackAction()
    {
        $panier = $this->getDoctrine()->getRepository('PanierBundle:Panier')->findBy(array(),array('date'=>"DESC"));
        return $this->render('@Panier/Front/AfficheCommande.html.twig',array('panier'=>$panier));
    }


    public function detailAction($id){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $panier = $this->getDoctrine()->getRepository('PanierBundle:Panier')->find($id);

        $elements = $this->getDoctrine()->getRepository('PanierBundle:Panier_element')->findByPanier($panier);


        return $this->render('@Panier/Front/detailPanier.html.twig', array('elements' => $elements, 'panier' => $panier, 'user'=>$user));

    }

    public function deleteCommandeAction($id){

        $em= $this->getDoctrine()->getManager();
        $commande= $em->getRepository('PanierBundle:Panier')->find($id);
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute("panier_Afficher");
    }
}