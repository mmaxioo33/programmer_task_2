<?php


namespace UserBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function disableUser(User $user): void
    {
        if(!$user->isDisabled()) {
            $user->disable();

            $this->em->persist($user);
            $this->em->flush();
        }
    }
}