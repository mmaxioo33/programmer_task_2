<?php

namespace UserBundle\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Entity\User;
use UserBundle\Service\UserService;

/**
 * Class UserController
 * @package UserBundle\Controller
 */
class UserController extends Controller
{
    /** @var EntityManagerInterface $em */
    private $em;
    /** @var PaginatorInterface $paginator */
    private $paginator;
    /** @var UserService $userService */
    private $userService;

    public function __construct(EntityManagerInterface $em, PaginatorInterface $paginator, UserService $userService)
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->userService = $userService;
    }

    /**
     * @Route("/", name="user_list")
     *
     * @param Request $request
     * @return Response
     */
    public function getUsers(Request $request): Response
    {
        $query = $this->em->getRepository(User::class)->getUsers();

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/user_list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/users/{userId}/disable", name="disable_user", requirements={"userId" = "\d+"})
     *
     * @ParamConverter("user", options={"id" = "userId"})
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function disableUser(User $user, Request $request): Response
    {
        $this->userService->disableUser($user);
        $query = $this->em->getRepository(User::class)->getUsers();

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/user_list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
    }
}