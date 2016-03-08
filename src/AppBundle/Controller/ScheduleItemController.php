<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ScheduleItem;
use AppBundle\Form\ScheduleItemType;
use Doctrine\ORM\Query;

/**
 * ScheduleItem controller.
 *
 * @Route("/scheduleitem")
 */
class ScheduleItemController extends Controller
{
    /**
     * Lists all ScheduleItem entities.
     *
     * @Route("/", name="scheduleitem_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scheduleItems = $em->getRepository('AppBundle:ScheduleItem')->findAll();

        return $this->render('scheduleitem/index.html.twig', array(
            'scheduleItems' => $scheduleItems,
        ));
    }
    
    
    
   
    /**
     * moves a ScheduleItem entity.
     *
     * @Route("/move/{id}/{direction}", name="scheduleitem_move")
     */
    public function moveAction(Request $request, ScheduleItem $scheduleItem, $direction)
    {
        $em = $this->getDoctrine()->getManager();

        $current =  $em->getRepository('AppBundle:ScheduleItem')->findOneBy(array('id' => $scheduleItem));

        
        
        $offset = ( $direction == 'up' ? -1 : +1 );
        $dir = ( $direction == 'up' ? '<' : '>' );
        $sort = ( $direction == 'up' ? 'DESC' : 'ASC' );
        //$swap = $em->getRepository('AppBundle:ScheduleItem')->findBySequence($scheduleItem->getSequence() + $offset)->findByChannel($scheduleItem->getChannel());
       
        $repository = $this->getDoctrine()->getRepository('AppBundle:ScheduleItem');
        $query = $repository->createQueryBuilder('si')
                            ->where('si.channel = :cha')
                            ->andWhere("si.sequence $dir :seq")
                            ->setParameter('cha',  $scheduleItem->getChannel())
                            ->setParameter('seq',  $scheduleItem->getSequence())
                            ->orderBy('si.sequence', $sort)
                            ->setMaxResults(1)
                            ->getQuery();

        $swap = $query->getResult();
        
//        $swap = $em->getRepository('AppBundle:ScheduleItem')
//            ->findOneBy(
//            array(
//                'sequence' => $scheduleItem->getSequence() + $offset ,
//                'channel' => $scheduleItem->getChannel()
//                 ),
//            array(
//                'sequence' => 'DESC'
//            )
//        );
        
        
        //->where('channel == :ch')->setParameter('ch', $scheduleItem->getChannel());
        //$em->persist($scheduleItem);
        //  $em->flush();
        
        if ($swap)
        {

            //dump($current);
            //dump($swap[0]);
            $cuS = $current->getSequence();
            $swS = $swap[0]->getSequence();



            $current->setSequence($swS);
            $swap[0]->setSequence($cuS);

            $em->persist($current);
            $em->persist($swap[0]);
            $em->flush();
            
        }
        
        
        //dump($current);
        //dump($swap);
        //  return new Response();

        return $this->redirectToRoute('channel_schedule', array( 'id' => $scheduleItem->getChannel()->getId() ));
    }
    
    
    
    
    
    
    
    
    
    
    

    /**
     * Creates a new ScheduleItem entity.
     *
     * @Route("/new", name="scheduleitem_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $scheduleItem = new ScheduleItem();
        $form = $this->createForm('AppBundle\Form\ScheduleItemType', $scheduleItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $highest = $em->createQueryBuilder()
                ->select('MAX(e.sequence)')
                ->from('AppBundle:ScheduleItem', 'e')
                ->where('e.channel = :ch')
                ->setParameter('ch', $scheduleItem->getChannel())
                ->getQuery()
                ->getSingleScalarResult();
            
            
            $scheduleItem->setSequence($highest + 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduleItem);
            $em->flush();

            return $this->redirectToRoute('channel_schedule', array('id' => $scheduleItem->getChannel()->getId()));
        }

        return $this->render('scheduleitem/new.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ScheduleItem entity.
     *
     * @Route("/{id}", name="scheduleitem_show")
     * @Method("GET")
     */
    public function showAction(ScheduleItem $scheduleItem)
    {
        $deleteForm = $this->createDeleteForm($scheduleItem);

        return $this->render('scheduleitem/show.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ScheduleItem entity.
     *
     * @Route("/{id}/edit", name="scheduleitem_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ScheduleItem $scheduleItem)
    {
        //$deleteForm = $this->createDeleteForm($scheduleItem);
        $editForm = $this->createForm('AppBundle\Form\ScheduleItemType', $scheduleItem);
        $editForm->remove('channel');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduleItem);
            $em->flush();

            return $this->redirectToRoute('channel_schedule', array('id' => $scheduleItem->getChannel()->getId()));
        }

        return $this->render('scheduleitem/edit.html.twig', array(
            'scheduleItem' => $scheduleItem,
            'edit_form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ScheduleItem entity.
     *
     * @Route("/{id}", name="scheduleitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ScheduleItem $scheduleItem)
    {
        $form = $this->createDeleteForm($scheduleItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduleItem);
            $em->flush();
        }

        return $this->redirectToRoute('scheduleitem_index');
    }
    
    
        /**
     * Deletes a ScheduleItem entity.
     *
     * @Route("/{id}/delete", name="scheduleitem_delete_direct")
     */
    public function deleteDirectAction(Request $request, ScheduleItem $scheduleItem)
    {
      
            $em = $this->getDoctrine()->getManager();
            $em->remove($scheduleItem);
            $em->flush();
        
        return $this->redirectToRoute('channel_schedule', array('id' => $scheduleItem->getChannel()->getId()));
    }
    
    

    /**
     * Creates a form to delete a ScheduleItem entity.
     *
     * @param ScheduleItem $scheduleItem The ScheduleItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ScheduleItem $scheduleItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scheduleitem_delete', array('id' => $scheduleItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
