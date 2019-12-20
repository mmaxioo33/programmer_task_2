<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\{User\AdvancedUserInterface, Role\Role, Role\RoleInterface};
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements AdvancedUserInterface
{
    const ACTIVE = 0;
    const DISABLED = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled = self::ACTIVE;

    public function __construct()
    {
        $this->addRole(new Role("ROLE_USER"));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param RoleInterface $role
     * @return $this
     */
    public function addRole(RoleInterface $role): User
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function removeRole(RoleInterface $role): bool
    {
        $key = array_search($role, $this->roles);

        if ($key !== false) {
            unset($this->roles[$key]);

            return true;
        }
        return false;
    }

    /**
     * @return User
     */
    public function disable(): User
    {
        $this->disabled = self::DISABLED;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function getSalt(): void
    {
        // TODO implement to improve password hashing
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return !$this->disabled;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired(): bool
    {
        return !$this->disabled;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked(): bool
    {
        return !$this->disabled;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired(): bool
    {
        return !$this->disabled;
    }
}
