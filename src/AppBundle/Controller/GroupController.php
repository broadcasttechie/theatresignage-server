<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class GroupController
{
    /**
     * @Route("/group")
     */
    public function indexAction()
    {
        $number = rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
    
    /**
     * @Route("/group/new")
     */
    public function newAction()
    {
        $number = rand(0, 100);

        return new Response(
            '<html><body>new</body></html>'
        );
    }
}
