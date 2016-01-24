<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Channel;
use AppBundle\Entity\ScheduleItem;


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

    
     
    
    
    private $demo =array(
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
    public function showAction(Channel $channel)
    {
      
        $data = $this->buildPlaylist($channel);
        $hash = md5(json_encode($data));
        $output = array('hash' => $hash, 'data' => $data);
        
        $response = new Response(
            json_encode($output));
        
        if($this->get('kernel')->isDebug())
        {
            dump($output);
        }
        else
        {
            $response->headers->set('Content-Type', 'application/json');
        }
        
        
        return $response;
    }
    
    
        
    /**
     * Playlist hash.
     *
     * @Route("/{id}/hash", name="playlist_hash")
     * @Method("GET")
     */
    public function hashAction(Channel $channel)
    {
        $response = new Response(md5(json_encode($this->buildPlaylist($channel))));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    
    
    
    
    
    private function buildPlaylist(Channel $channel)
    {
        $em = $this->getDoctrine()->getManager();

        $channelName = $channel->getName();
        $items = $em->getRepository('AppBundle:ScheduleItem')->findByChannel($channel);
        $playlist = array();
        
        $i = 0;
        foreach ($items as $item)
        {
            $playlist[$i]['name'] = $item->getAsset()->getName();
            $playlist[$i]['type'] = $item->getAsset()->getType()->getName();
            $i++;
        }
            

        $data = array(
            'meta' => array(
                'id' => $channel->getId(),
                'name' => $channel->getName(),
            ),
            'playlist' => $playlist
                
        );
        
        return $data;
    }
    
   
}

