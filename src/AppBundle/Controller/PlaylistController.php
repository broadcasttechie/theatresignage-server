<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Channel;
use AppBundle\Entity\ScheduleItem;
use AppBundle\MimeType;

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
     * Demo playlist hash.
     *
     * @Route("/demo/type", name="playlist_demo_type")
     * @Method("GET")
     */
    public function demoTypeAction()
    {
        $type = new MimeType();
        
        $response = new Response(dump($type));
        //$response->headers->set('Content-Type', 'application/json');
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
        
        $response = new Response(json_encode($output));
        
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * Finds and displays a Channel entity in debug mode.
     *
     * @Route("/{id}/debug", name="playlist_debug")
     * @Method("GET")
     */
    public function debugAction(Channel $channel)
    {
      
        $data = $this->buildPlaylist($channel);
        $hash = md5(json_encode($data));
        $output = array('hash' => $hash, 'data' => $data);
        
        $response = new Response(
            json_encode($output));
        
        dump($output);
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
    
    
            
    /**
     * Playlist player.
     *
     * @Route("/{id}/player", name="playlist_player")
     * @Method("GET")
     */
    public function playerAction(Channel $channel)
    {
        return $this->render('channel/player.html.twig');
    }
    
    
    
    
    
    private function buildPlaylist(Channel $channel)
    {
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:ScheduleItem');
        $query = $repository->createQueryBuilder('si')
            ->where('si.channel = :channel')
            //->andWhere('si.stop > :today')
            ->andWhere('si.start < :today')
            ->setParameter('channel', $channel)
            ->setParameter('today', new \DateTime())
            ->orderBy('si.sequence', 'ASC')
            ->getQuery();
        
        $items = $query->getResult();

        
        $em = $this->getDoctrine()->getManager();

        $channelName = $channel->getName();

        $playlist = array();
        
        
        if ($channel->getInherits())
        {
            $query = $repository->createQueryBuilder('si')
                ->where('si.channel = :ch')
                //->andWhere('si.stop > :dt')
                ->andWhere('si.start < :dt')
                ->setParameter('ch', $channel->getInherits())
                ->setParameter('dt', new \DateTime())
                ->orderBy('si.sequence', 'ASC')
                ->getQuery();
        
            $masterItems = $query->getResult();
            
            $items = $this->array_mix($masterItems, $items);
        }
        
        $i = 0;
        foreach ($items as $item)
        {
            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
$path = $helper->asset($item->getAsset(), 'uriFile');
        
        $url = $this->get('liip_imagine.cache.manager')->getBrowserPath($path, '1080') ;
            $webPath = $this->get('kernel')->getRootDir() . '/../web' . $this->getRequest()->getBasePath();
            
            $playlist[$i]['uri'] = $item->getAsset()->getUri();
            $playlist[$i]['type'] = $item->getAsset()->getMimeType();
            $playlist[$i]['url'] = $url;
            $playlist[$i]['start'] = $item->getStart()->format('c');
            $playlist[$i]['stop'] = $item->getStop()->format('c');
            $playlist[$i]['duration'] = ($item->getDuration() ? $item->getDuration() : ($channel->getDuration() ? $channel->getDuration() : $channel->getInherits()->getDuration() ));
            //$playlist[$i]['hash'] = md5_file("$webPath$path");
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
   function array_mix($arr1, $arr2)
{
       if (count($arr1) == 0 || count($arr2) == 0)
       {
        return array_merge($arr1, $arr2);
       }
	if (count($arr2)>count($arr1))
		{
			$temp = $arr1;
			$arr1 = $arr2;
			$arr2 = $temp;
			unset($temp);
		}
	$output = array();
	$l1 = count($arr1);
	$l2 = count($arr2);
	$lt = $l1 + $l2;
	$n = floor($l1 / $l2) ;
	for ($i = 0; $i < $l1; $i++)
	{
		$output[] = $arr1[$i];
		if ($i % $n == floor($n/2) && count($arr2) > 0 )
		{
			$output[] = array_shift($arr2);
		}
	}
	return $output;
}
   
}

