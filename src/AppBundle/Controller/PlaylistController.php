<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

//use AppBundle\Entity\Playlist;

/**
 * Playlist controller.
 *
 * @Route("/playlist")
 */
class PlaylistController extends Controller
{
    /**
     * Returns nothing
     *
     * @Route("/", name="playlist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        
       return new Response(
            'No playlist selected'
        );
    }

    
     
    
    
    public $demo =array(
            'name' => 'demo', 
            'meta' => array(
                'verion' => 1,
                //'published' => date("Y-m-d H:i:s")
            ),
            'schedule' => array(
                array(
                    'asset_id' => 1,
                    'asset_type' => 'image',
                    'time_start' => '',
                    'time_end' => '',
                    'duration' => 10
                ),
                array(
                    'asset_id' => 2,
                    'asset_type' => 'image',
                    'time_start' => '',
                    'time_end' => '',
                    'duration' => 12
                ),
            )
        );
    
    /**
     * Demo playlist.
     *
     * @Route("/demo", name="playlist_demo")
     * @Method("GET")
     */
    public function demoAction()
    {    
        $response = new Response(json_encode($this->demo));
$response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    
    
    
     
    /**
     * Demo playlist hash.
     *
     * @Route("/demo/hash", name="playlist_demo_hash")
     * @Method("GET")
     */
    public function demoHashAction()
    {
        
        $response = new Response(md5(json_encode($this->demo)));
$response->headers->set('Content-Type', 'application/json');
                                 return $response;
    }
    
    
    
    
    
    
    
    
    
    
    
    /**
     * Finds and displays a Channel entity.
     *
     * @Route("/{id}", name="playlist_show")
     * @Method("GET")
     */
    public function showAction($id)
    {

        
        $response = new Response(json_encode(array('name' => $id)));
$response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
   
}

