<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/activate/{token}",name="activate")
     */
    public function userActivateAction($token)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        $user = $entityManager
            ->getRepository("AppBundle:User")
            ->findUserByConfirmationToken($token);

        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('Access denied to this section.');
        }

        $user->setStatusActive();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Congratulations! Your account is activated now.'
        );
        return $this->redirectToRoute('login');
    }
}