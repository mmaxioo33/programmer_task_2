<?php

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package UserBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/list", name="user_list")
     *
     * @return Response
     */
    public function getUsers(): Response
    {
        return $this->render('user/user_list.html.twig');
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
    }
}