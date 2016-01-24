<?php
// src/AppBundle/Menu/Builder.php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
    	$menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'homepage'));
        
         $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
        
            $user = $this->container->get('security.context')->getToken()->getUser();
            
        $menu->addChild('Manage Channel', array('route' => 'channel_index'));
        $menu->addChild('Manage Assets', array('uri' => '#'));
            if ($user->hasRole('ROLE_ADMIN'))
            {
                $menu->addChild('Manage Group', array('uri' => '#'));
            }
            
        }
        else
        {
            
        $menu->addChild('About', array('uri' => '#'));
        }
        
        // access servies from the container!
        //$em = $this->container->get('doctrine')->getManager();
        
      
        
        
        return $menu;
    }
    
    
    
    
    
    
    
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
    	$menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        
//        $menu->addChild('User', array('label' => 'Hi visitor'))
//			->setAttribute('dropdown', true)
//			->setAttribute('icon', 'gl gl-user');
//		$menu['User']->addChild('Edit profile', array('uri' => '#'))
//			->setAttribute('icon', 'fa fa-edit');

//        $menu['User']->addChild('Menu Item', array('uri' => '#'));
//        $menu['User']->addChild('Menu Item', array('uri' => '#'));
//        $menu['User']->addChild('Menu Item', array('uri' => '#'));
            
            
        // access servies from the container!
        //$em = $this->container->get('doctrine')->getManager();
        
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername(); // Get username of the current logged in user

            
            $menu->addChild('User')->setAttribute('dropdown', true)
             ->setAttribute('divider_prepend', true);
            
		$menu['User']->addChild("Hello $username");
		$menu['User']->addChild('Edit profile', array('route' => 'fos_user_profile_edit'))
			->setAttribute('icon', 'glyphicon glyphicon-user');
            $menu['User']->addChild('Logout', array('route' => 'fos_user_security_logout'));
            
            
            
            
            
            
        }
        else
        {
            $menu->addChild('Login', array('route' => 'fos_user_security_login'));
        }
        
        
        
        
        
        
        
        return $menu;
        
    }
    
        
        
}