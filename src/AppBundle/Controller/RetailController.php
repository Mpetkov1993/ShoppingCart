<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RetailProduct;
use AppBundle\Entity\UserProduct;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RetailController extends Controller
{
    /**
     * @Route("/retail", name="retail")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository(RetailProduct::class)->findAll();
        return $this->render("retail/view.html.twig", ['products' => $products]);
    }

    /**
     * @Route("/retail/sell/{id}", name="retail_sell")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_USER')")
     */
    public function retailSellAction(int $id)
    {
        $product = $this->getDoctrine()->getRepository(UserProduct::class)->find($id);
        $newProduct = new RetailProduct();
        $newProduct->setPicture($product->getPicture());
        $newProduct->setName($product->getName());
        $newProduct->setPrice($product->getPrice());
        $user = $this->getUser();
        $newProduct->setSeller($user);

            $user->getProducts()->removeElement($product);
            $user->setCash($user->getCash() + $product->getPrice());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newProduct);
            $em->persist($product);
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Successfully sold!');

            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository(UserProduct::class);
            $product = $repo->find($id);
            if (null === $product) {
                throw $this->createNotFoundException();
            }
            $em->remove($product);
            $em->flush();

        return $this->redirectToRoute('my_products');
    }

    /**
     * @Route("/retail/delete/{id}", name="retail_remove")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function retailRemoveAction(int $id)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(RetailProduct::class);
        $product = $repo->find($id);
        if (null === $product) {
            throw $this->createNotFoundException();
        }
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('retail');
    }
}
