<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    const USER_CASH = 11999;
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    private $oldPassword;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="cash", type="decimal", precision=10, scale=2)
     */
    private $cash;

    /**
     * @var Collection|Role[]
     * @Assert\Count(min="1")
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinTable(name="users_roles", joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")}, inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;

    private $roleList;

    /**
     * @var ArrayCollection|Product
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Product", inversedBy="userCart")
     * @ORM\JoinTable(name="users_carts")
     */
    private $cart;

    /**
     * @var ArrayCollection|UserProduct[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserProduct", mappedBy="user", cascade={"persist"})
     */
    private $products;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->cash = self::USER_CASH;
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->getId(),
            $this->getUsername(),
            $this->getPassword()
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getName();
        }
        return $roles;
    }

    public function setRole(Role $role)
    {
        $this->roles[] = $role;
    }

    /**
     * @return mixed
     */
    public function getRoleList()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getCash(): string
    {
        return $this->cash;
    }

    /**
     * @param string $cash
     * @return User
     */
    public function setCash(string $cash)
    {
        $this->cash = $cash;
        return $this;
    }

    /**
     * @return Product|ArrayCollection
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Product|ArrayCollection $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    public function __toString()
    {
        return join('', $this->getRoles());
    }

    /**
     * @return Product|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product|ArrayCollection $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }
}

