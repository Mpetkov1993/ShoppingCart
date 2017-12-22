<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProduct;
use AppBundle\Form\BuyType;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="show_cart")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function showAction()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $cart = $user->getCart();
        return $this->render('cart/show_cart.html.twig', ['cart' => $cart]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function addAction(int $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $user = $this->getUser();
        if ($user->getCart()->contains($product)) {
            $this->addFlash('notice', 'Already in cart!');
            return $this->redirectToRoute('homepage');
        }
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $this->getUser()->getCart()->add($product);
        $em = $this->getDoctrine()->getManager();
        $em->persist($this->getUser());
        $em->flush();

        $this->addFlash('notice', 'Successfully added!');
        return $this->redirectToRoute('show_cart');
    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_USER')")
     */
    public function removeAction(int $id = null)
    {
        $userId = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Product::class);
        $product = $repo->find($id);
        $repo = $em->getRepository(User::class);
        $user = $repo->find($userId);
        $user->getCart()->removeElement($product);
        $em->persist($user);
        $em->flush();

        $this->addFlash('notice', 'Successfully removed!');
        return $this->redirectToRoute('show_cart');
    }

    /**
     * @Route("/cart/checkout/{id}", name="buy_product")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_USER')")
     */
    public function buyProduct(int $id)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $newProduct = new UserProduct();
        $newProduct->setPicture($product->getPicture());
        $newProduct->setName($product->getName());
        $newProduct->setQuantity(1);
        $newProduct->setPrice($product->getPrice() * 0.90);
        $product->setQuantity($product->getQuantity() - 1);
        $user = $this->getUser();
        $newProduct->setUser($user);

        if (!$user->getProducts()->contains($newProduct) && ($user->getCash() >= $product->getPrice())) {
            $user->getProducts()->add($newProduct);
            $user->setCash($user->getCash() - $product->getPrice());

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Successfully bought!');

            $this->removeAction($id);
        }

        return $this->redirectToRoute('show_cart');
    }
}
