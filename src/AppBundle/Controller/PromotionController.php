<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\Promotion;
use AppBundle\Form\AddPromotionType;
use AppBundle\Form\PromotionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PromotionController extends Controller
{
    /**
     * @Route("/promotions", name="all_promotions")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Promotion::class);
        $promotions = $repo->findAll();
        return $this->render("promotions/index.html.twig", ['promotions' => $promotions]);
    }

    /**
     * @Route("/promotion/add", name="add_promotion")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function addPromotionAction(Request $request): Response
    {
        $form = $this->createForm(PromotionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            $this->addFlash("notice", "Promotion added successfully!");
            return $this->redirectToRoute("all_promotions");
        }

        return $this->render("promotions/add.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/promotion/edit/{id}", name="edit_promotion")
     * @param Request $request
     * @param Promotion $promotion
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function editPromotionAction(Request $request, Promotion $promotion): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotion = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("notice", "Successfully edited!");
            return $this->redirectToRoute("all_promotions");
        }

        return $this->render("promotions/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/promotion/delete/{id}", name="delete_promotion")
     * @param Promotion $promotion
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function removePromotionAction(Promotion $promotion): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($promotion);
        $em->flush();

        $this->addFlash("notice", "Successfully deleted ");
        return $this->redirectToRoute("all_promotions");
    }

    /**
     * @Route("/promotion/all_products/", name="all_products_promo")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function allProductsPromotion(Request $request): Response
    {
        $form = $this->createForm(AddPromotionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $data = $form->getData();
            $promotion = $data['promotion'];
            $repo = $this->getDoctrine()->getRepository(Product::class);
            $products = $repo->findAll();

            foreach ($products as $product) {
                if ($product->getPromotions()->contains($promotion)) {
                    continue;
                }
                $product->addPromotion($promotion);
            }
            $this->addFlash('notice', "{$promotion->getName()} has been applied to all products!");

            $this->getDoctrine()->getManager()->flush();
            $this->redirectToRoute('all_promotions');
        }
        return $this->render('promotions/all_products.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/promotion/category/", name="category_promo")
     * @param Request $request
     * @return Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function categoryPromotion(Request $request)
    {
        $form = $this->createForm(AddPromotionType::class)
            ->add('category', EntityType::class, [
            'class' => Category::class,
            'label' => 'Category: ',
            'choice_label' => 'name',
            'placeholder' => 'Choose Category']);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $data = $form->getData();
            $promotion = $data['promotion'];
            $category = $data['category'];

            foreach ($category->getProducts() as $product) {
                if ($product->getPromotions()->contains($promotion)) {
                    continue;
                }

                $product->addPromotion($promotion);
            }
            $this->addFlash(
                'notice',
                "{$promotion->getName()} has been applied to {$category->getName()}!");

            $this->getDoctrine()->getManager()->flush();
            $this->redirectToRoute('all_promotions');
        }
        return $this->render('promotions/category.html.twig', ['form' => $form->createView()]);
    }

}
