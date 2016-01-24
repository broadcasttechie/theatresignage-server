<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * Profile controller.
 *
 * @Route("/profileq")
 */
class ProfileController extends Controller
{

/**
     * Edits profile.
     *
     * @Route("/", name="profile_edit")
     * @Method("GET")
     */
public function profileAction()
{
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->get('security.context')->getToken()->getUser();
    $entity = $em->getRepository('AppBundle:User')->find($user->getId());

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find User entity.');
    }
    
    $deleteForm = $this->createDeleteForm($user);

    $form = $this->createForm(new UserType(), $entity);

    $request = $this->getRequest();

    if ($request->getMethod() === 'POST')
    {
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('profile'));
        }

        $em->refresh($user); // Add this line
    }

    return $this->render('user/edit.html.twig', array(
        'entity'      => $entity,
        'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
    ));
}
}