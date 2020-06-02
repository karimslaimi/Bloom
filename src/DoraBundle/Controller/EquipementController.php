<?php

namespace DoraBundle\Controller;

use DateTime;
use DoraBundle\Entity\Equipement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Equipement controller.
 *
 * @Route("equipement")
 */
class EquipementController extends Controller
{
    /**
     * Lists all equipement entities.
     *
     * @Route("/", name="equipement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipements = $em->getRepository('DoraBundle:Equipement')->findAll();

        return $this->render('@Dora/equipement/index.html.twig', array(
            'equipements' => $equipements,
        ));
    }

    /**
     * Creates a new equipement entity.
     *
     * @Route("/new", name="equipement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipement = new Equipement();
        $form = $this->createForm('DoraBundle\Form\EquipementType', $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTime("now");
            $equipement->setDate($date);
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush();

            return $this->redirectToRoute('equipement_show', array('id' => $equipement->getId()));
        }else if ($form->isSubmitted() && !$form->isValid()){
            return $this->render('@Dora/equipement/new.html.twig', array(
                'equipement' => $equipement,
                'form' => $form->createView(),
                "msg"=>"Verifier les champs",
            ));
        }

            return $this->render('@Dora/equipement/new.html.twig', array(
            'equipement' => $equipement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a equipement entity.
     *
     * @Route("/{id}", name="equipement_show")
     * @Method("GET")
     */
    public function showAction(Equipement $equipement)
    {
        $deleteForm = $this->createDeleteForm($equipement);

        return $this->render('@Dora/equipement/show.html.twig', array(
            'equipement' => $equipement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipement entity.
     *
     * @Route("/{id}/edit", name="equipement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipement $equipement)
    {
        $deleteForm = $this->createDeleteForm($equipement);
        $editForm = $this->createForm('DoraBundle\Form\EquipementType', $equipement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->render('@Dora/equipement/edit.html.twig', array("msg"=>"Modfié avec succés",'equipement' => $equipement,'edit_form' => $editForm->createView()));
        }else if($editForm->isSubmitted() &&!$editForm->isValid()){
            return $this->render('@Dora/equipement/edit.html.twig', array("error"=>"Les champs sont invalides",'equipement' => $equipement,'edit_form' => $editForm->createView()));
        }

        return $this->render('@Dora/equipement/edit.html.twig', array(
            'equipement' => $equipement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipement entity.
     *
     * @Route("/delete/{id}", name="equipement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Equipement $equipement)
    {
        $form = $this->createDeleteForm($equipement);



            $em = $this->getDoctrine()->getManager();
            $em->remove($equipement);
            $em->flush();


        return $this->redirectToRoute('equipement_index');
    }

    /**
     * Creates a form to delete a equipement entity.
     *
     * @param Equipement $equipement The equipement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipement $equipement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipement_delete', array('id' => $equipement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
