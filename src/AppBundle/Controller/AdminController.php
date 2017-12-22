<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProduct;
use AppBundle\Form\PromotionType;
use AppBundle\Form\RoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin/users", name="all_users")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUsers(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        return $this->render('admin/users.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/admin/user/{id}/role", name="change_role")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changeUserRole(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $user = $repo->find($id);
        $form = $this->createForm(RoleType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice', "Successfully changed!");
            return $this->redirectToRoute('all_users');
        }
        return $this->render('admin/edit_role.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/out_of_stock", name="out_of_stock")
     * @return Response
     */
    public function outOfStockProducts()
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $query = $repo->createQueryBuilder('p')
            ->where("p.quantity LIKE :count")
            ->setParameter('count', 0)
            ->getQuery();
        $products = $query->getResult();
        return $this->render('admin/out_of_stock.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/user_products/{id}", name="user_products")
     * @param int $id
     * @return Response
     */
    public function userProducts(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);
        return $this->render('admin/users_products.html.twig', ['user' => $user]);
    }
}
