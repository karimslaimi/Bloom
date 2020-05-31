<?php

namespace DoraBundle\Controller;

use DoraBundle\Entity\Rating;
use DoraBundle\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rating controller.
 *
 * @Route("rating")
 */
class RatingController extends Controller
{
    /**
     * Lists all rating entities.
     *
     * @Route("/", name="rating_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('DoraBundle:Rating')->findAll();
        $average=$em->getRepository(Rating::class)->getratings();




        $rating = new Rating();
        $form = $this->createForm('DoraBundle\Form\RatingType', $rating)->add('rating',\blackknight467\StarRatingBundle\Form\RatingType::class, [
            //...
            'label' => "Rating",
            //...
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date=new \DateTime();
            $rating->setDate($date);


            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('rating_index', array('id' => $rating->getId()));
        }


        return $this->render('@Dora/rating/index.html.twig', array(
            'ratings' => $ratings,
            "count"=>count($ratings),
            "average"=>$average, 'rating' => $rating,
            'form' => $form->createView(),
        ));
    }



    /**
     * Lists all rating entities for the admin.
     *
     * @Route("/list", name="rating_admin")
     * @Method("GET")
     */
    public function ratinglistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('DoraBundle:Rating')->findAll();
        $average=$em->getRepository(Rating::class)->getratings();







        return $this->render('@Dora/rating/indexadmin.html.twig', array(
            'ratings' => $ratings,
            "count"=>count($ratings),
            "average"=>$average,
        ));
    }






    /**
     * Creates a new rating entity.
     *
     * @Route("/new", name="rating_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rating = new Rating();
        $form = $this->createForm('DoraBundle\Form\RatingType', $rating)->add('rating',\blackknight467\StarRatingBundle\Form\RatingType::class, [
            //...
            'label' => "Rating",
            //...
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('rating_show', array('id' => $rating->getId()));
        }

        return $this->render('@Dora/rating/new.html.twig', array(
            'rating' => $rating,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rating entity.
     *
     * @Route("/{id}", name="rating_show")
     * @Method("GET")
     */
    public function showAction(Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);

        return $this->render('@Dora/rating/show.html.twig', array(
            'rating' => $rating,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rating entity.
     *
     * @Route("/{id}/edit", name="rating_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rating $rating)
    {
        $deleteForm = $this->createDeleteForm($rating);
        $editForm = $this->createForm('DoraBundle\Form\RatingType', $rating);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rating_edit', array('id' => $rating->getId()));
        }

        return $this->render('@Dora/rating/edit.html.twig', array(
            'rating' => $rating,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rating entity.
     *
     * @Route("/delete/{id}", name="rating_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rating $rating)
    {
        $form = $this->createDeleteForm($rating);

            $em = $this->getDoctrine()->getManager();
            $em->remove($rating);
            $em->flush();


        return $this->redirectToRoute('rating_admin');
    }

    /**
     * Creates a form to delete a rating entity.
     *
     * @param Rating $rating The rating entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rating $rating)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rating_delete', array('id' => $rating->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
