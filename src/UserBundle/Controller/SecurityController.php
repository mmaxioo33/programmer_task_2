<?php

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

class SecurityController extends Controller
{
    private $passwordEncoder;
    private $authenticationUtils;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, AuthenticationUtils $authenticationUtils)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/register", name="user_registration")
     *
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_login');
        }

        return $this->render(
            'security/register_form.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->render('security/login_form.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}