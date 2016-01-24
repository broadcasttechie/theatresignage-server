<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\AssetImage;

/**
 * Playlist controller.
 *
 * @Route("/image")
 * @Method("GET")
 */
class ImageController extends Controller
{
    
     /**
     * Returns nothing
     *
     * @Route("/", name="image_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
       return new Response(
            'No image selected'
        );
    }
    
    
        /**
     * Finds and displays a Asset entity.
     *
     * @Route("/{id}", name="image_show")
     * @Method("GET")
     */
    public function showAction(AssetImage $assetImage)
    {
        

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
$path = $helper->asset($assetImage, 'imageFile');
        
        $opts = array();
        return new Response( $this->get('liip_imagine.cache.manager')->getBrowserPath($path, '1080') );
    }
    
    
    
}