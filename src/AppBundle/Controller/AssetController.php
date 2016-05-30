<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("s", name="asset_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Asset a ORDER BY a.updatedAt DESC";
        $query = $em->createQuery($dql);

         $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        
        $asset = new Asset();
        $form = $this->createForm('AppBundle\Form\AssetType', $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asset);
            $em->flush();
            return $this->redirectToRoute('asset_index');
        }

        return $this->render('asset/index.html.twig', array('pagination' => $pagination, 'form' => $form->createView(),));

        
       // $em = $this->getDoctrine()->getManager();

       // $assets = $em->getRepository('AppBundle:Asset')->findAll();

       // return $this->render('asset/index.html.twig', array(
       //     'assets' => $assets,
        //));
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
     * Finds and displays a Asset entity thumb.
     *
     * @Route("/{id}/thumb", name="asset_get_thumb")
     * @Method("GET")
     */
    public function getThubmbAction(Asset $asset)
    {
           $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($asset, 'uriFile');
        $url = $this->get('liip_imagine.cache.manager')->getBrowserPath($path, '1080_thumb') ;
        return new Response($url);
    }
    
    /**
     * Finds and displays a Asset entity thumb image.
     *
     * @Route("/{id}/thumbimage", name="asset_get_thumb_image")
     * @Method("GET")
     */
    public function getThubmbImageAction(Asset $asset)
    {
        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($asset, 'uriFile');
        $url = $this->get('liip_imagine.cache.manager')->getBrowserPath($path, '1080_thumb') ;
        $image = file_get_contents( realpath($this->get('kernel')->getRootDir()  . '/../web') . parse_url($url)['path']);
        
        return new Response($image, 200, array('Content-Type' => 'image/jpg'));
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
        $editForm->remove('uriFile');
        $editForm->add('name');
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
