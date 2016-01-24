<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\AssetImage;
use AppBundle\Form\AssetImageType;

/**
 * AssetImage controller.
 *
 * @Route("/assetimage")
 */
class AssetImageController extends Controller
{
    /**
     * Lists all AssetImage entities.
     *
     * @Route("/", name="assetimage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $assetImages = $em->getRepository('AppBundle:AssetImage')->findAll();

        return $this->render('assetimage/index.html.twig', array(
            'assetImages' => $assetImages,
        ));
    }

    /**
     * Creates a new AssetImage entity.
     *
     * @Route("/new", name="assetimage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $assetImage = new AssetImage();
        $form = $this->createForm('AppBundle\Form\AssetImageType', $assetImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assetImage);
            $em->flush();

            return $this->redirectToRoute('assetimage_show', array('id' => $assetimage->getId()));
        }

        return $this->render('assetimage/new.html.twig', array(
            'assetImage' => $assetImage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AssetImage entity.
     *
     * @Route("/{id}", name="assetimage_show")
     * @Method("GET")
     */
    public function showAction(AssetImage $assetImage)
    {
        $deleteForm = $this->createDeleteForm($assetImage);

        return $this->render('assetimage/show.html.twig', array(
            'assetImage' => $assetImage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AssetImage entity.
     *
     * @Route("/{id}/edit", name="assetimage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AssetImage $assetImage)
    {
        $deleteForm = $this->createDeleteForm($assetImage);
        $editForm = $this->createForm('AppBundle\Form\AssetImageType', $assetImage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assetImage);
            $em->flush();

            return $this->redirectToRoute('assetimage_edit', array('id' => $assetImage->getId()));
        }

        return $this->render('assetimage/edit.html.twig', array(
            'assetImage' => $assetImage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AssetImage entity.
     *
     * @Route("/{id}", name="assetimage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AssetImage $assetImage)
    {
        $form = $this->createDeleteForm($assetImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($assetImage);
            $em->flush();
        }

        return $this->redirectToRoute('assetimage_index');
    }

    /**
     * Creates a form to delete a AssetImage entity.
     *
     * @param AssetImage $assetImage The AssetImage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AssetImage $assetImage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('assetimage_delete', array('id' => $assetImage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
