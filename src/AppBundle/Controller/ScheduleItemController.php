<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ScheduleItem;
use AppBundle\Form\ScheduleItemType;

/**
 * ScheduleItem controller.
 *
 * @Route("/scheduleitem")
 */
class ScheduleItemController extends Controller
{
    /**
     * Lists all ScheduleItem entities.
     *
     * @Route("/", name="scheduleitem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleItems = $em->getRepository('AppBundle:ScheduleItem')->findAll();

        return $this->render('scheduleitem/index.html.twig', array(
            'scheduleItems' => $scheduleItems,
        ));
    }

    /**
     * Creates a new ScheduleItem entity.
     *
     * @Route("/new", name="scheduleitem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scheduleItem = new ScheduleItem();
        $form = $this->createForm('AppBundle\Form\ScheduleItemType', $scheduleItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduleItem);
            $em->flush();

            return $this->redirectToRoute('scheduleitem_show', array('id' => $scheduleitem->getId()));
        }

        return $this->render('scheduleitem/new.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ScheduleItem entity.
     *
     * @Route("/{id}", name="scheduleitem_show")
     * @Method("GET")
     */
    public function showAction(ScheduleItem $scheduleItem)
    {
        $deleteForm = $this->createDeleteForm($scheduleItem);

        return $this->render('scheduleitem/show.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ScheduleItem entity.
     *
     * @Route("/{id}/edit", name="scheduleitem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScheduleItem $scheduleItem)
    {
        $deleteForm = $this->createDeleteForm($scheduleItem);
        $editForm = $this->createForm('AppBundle\Form\ScheduleItemType', $scheduleItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduleItem);
            $em->flush();

            return $this->redirectToRoute('scheduleitem_edit', array('id' => $scheduleItem->getId()));
        }

        return $this->render('scheduleitem/edit.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ScheduleItem entity.
     *
     * @Route("/{id}", name="scheduleitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScheduleItem $scheduleItem)
    {
        $form = $this->createDeleteForm($scheduleItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduleItem);
            $em->flush();
        }

        return $this->redirectToRoute('scheduleitem_index');
    }

    /**
     * Creates a form to delete a ScheduleItem entity.
     *
     * @param ScheduleItem $scheduleItem The ScheduleItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScheduleItem $scheduleItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scheduleitem_delete', array('id' => $scheduleItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
