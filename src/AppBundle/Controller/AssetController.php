<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Asset;
use AppBundle\Form\AssetType;

/**
 * Asset controller.
 *
 * @Route("/asset")
 */
class AssetController extends Controller
{
    /**
     * Lists all Asset entities.
     *
     * @Route("/", name="asset_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $assets = $em->getRepository('AppBundle:Asset')->findAll();

        return $this->render('asset/index.html.twig', array(
            'assets' => $assets,
        ));
    }

    /**
     * Creates a new Asset entity.
     *
     * @Route("/new", name="asset_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $asset = new Asset();
        $form = $this->createForm('AppBundle\Form\AssetType', $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asset);
            $em->flush();

            return $this->redirectToRoute('asset_show', array('id' => $asset->getId()));
        }

        return $this->render('asset/new.html.twig', array(
            'asset' => $asset,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Asset entity.
     *
     * @Route("/{id}", name="asset_show")
     * @Method("GET")
     */
    public function showAction(Asset $asset)
    {
        $deleteForm = $this->createDeleteForm($asset);

        return $this->render('asset/show.html.twig', array(
            'asset' => $asset,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Asset entity.
     *
     * @Route("/{id}/edit", name="asset_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asset $asset)
    {
        $deleteForm = $this->createDeleteForm($asset);
        $editForm = $this->createForm('AppBundle\Form\AssetType', $asset);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asset);
            $em->flush();

            return $this->redirectToRoute('asset_edit', array('id' => $asset->getId()));
        }

        return $this->render('asset/edit.html.twig', array(
            'asset' => $asset,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Asset entity.
     *
     * @Route("/{id}", name="asset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asset $asset)
    {
        $form = $this->createDeleteForm($asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asset);
            $em->flush();
        }

        return $this->redirectToRoute('asset_index');
    }

    /**
     * Creates a form to delete a Asset entity.
     *
     * @param Asset $asset The Asset entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asset $asset)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('asset_delete', array('id' => $asset->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
