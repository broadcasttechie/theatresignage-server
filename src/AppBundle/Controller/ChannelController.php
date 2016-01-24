<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Channel;
use AppBundle\Form\ChannelType;

/**
 * Channel controller.
 *
 * @Route("/channel")
 */
class ChannelController extends Controller
{
    /**
     * Lists all Channel entities.
     *
     * @Route("/", name="channel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.context')->getToken()->getUser();

        //dump($user->getGroups());
        $groups = array();
        foreach ($user->getGroups() as $group)
        {
           $groups[] = $group->getId();
        }
        //dump($groups);
        
        if ($user->hasRole('ROLE_SUPER_ADMIN'))
        {
            $channels = $em->getRepository('AppBundle:Channel')->findAll();
        }
        else
        {
            $channels = $em->getRepository('AppBundle:Channel')->findByGroup($groups);
        }

        return $this->render('channel/index.html.twig', array(
            'channels' => $channels,
        ));
    }

    /**
     * Creates a new Channel entity.
     *
     * @Route("/new", name="channel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $channel = new Channel();
        $form = $this->createForm('AppBundle\Form\ChannelType', $channel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($channel);
            $em->flush();

            return $this->redirectToRoute('channel_show', array('id' => $channel->getId()));
        }

        return $this->render('channel/new.html.twig', array(
            'channel' => $channel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Channel entity.
     *
     * @Route("/{id}", name="channel_show")
     * @Method("GET")
     */
    public function showAction(Channel $channel)
    {
        $deleteForm = $this->createDeleteForm($channel);

        return $this->render('channel/show.html.twig', array(
            'channel' => $channel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Channel entity.
     *
     * @Route("/{id}/edit", name="channel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Channel $channel)
    {
        $deleteForm = $this->createDeleteForm($channel);
        $editForm = $this->createForm('AppBundle\Form\ChannelType', $channel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($channel);
            $em->flush();

            return $this->redirectToRoute('channel_edit', array('id' => $channel->getId()));
        }

        return $this->render('channel/edit.html.twig', array(
            'channel' => $channel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit Channel Schedule.
     *
     * @Route("/{id}/schedule", name="channel_schedule")
     * @Method({"GET", "POST"})
     */
    public function scheduleAction(Request $request, Channel $channel)
    {
        $deleteForm = $this->createDeleteForm($channel);
        $editForm = $this->createForm('AppBundle\Form\ChannelType', $channel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($channel);
            $em->flush();

            return $this->redirectToRoute('channel_edit', array('id' => $channel->getId()));
        }

        return $this->render('channel/edit.html.twig', array(
            'channel' => $channel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Channel entity.
     *
     * @Route("/{id}", name="channel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Channel $channel)
    {
        $form = $this->createDeleteForm($channel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($channel);
            $em->flush();
        }

        return $this->redirectToRoute('channel_index');
    }

    /**
     * Creates a form to delete a Channel entity.
     *
     * @param Channel $channel The Channel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Channel $channel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('channel_delete', array('id' => $channel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
