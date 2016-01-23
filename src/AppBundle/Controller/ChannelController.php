<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Channel;

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

        $channels = $em->getRepository('AppBundle:Channel')->findAll();

        return $this->render('channel/index.html.twig', array(
            'channels' => $channels,
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

        return $this->render('channel/show.html.twig', array(
            'channel' => $channel,
        ));
    }
}
