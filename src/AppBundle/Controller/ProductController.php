<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\Promotion;
use AppBundle\Entity\Review;
use AppBundle\Form\AddPromotionType;
use AppBundle\Form\ProductType;
use AppBundle\Form\ReviewType;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product/view/{id}", name="product_view")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Product $product)
    {
        if ($product === null) {
            throw $this->createNotFoundException('No product found');
        }
        return $this->render('product/view.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product/create", name="product_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('notice', 'Successfully created!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('product/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function editAction(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Product::class);
        $product = $repo->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('notice', 'Successfully edited!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('product/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function deleteAction(int $id = null)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Product::class);
        $product = $repo->find($id);
        if (null === $product) {
            throw $this->createNotFoundException();
        }
        $em->remove($product);
        $em->flush();

        $this->addFlash('notice', 'Successfully deleted!');
        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/product/review/{id}", name="add_review")
     * @param Request $request
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function addReview(Request $request, Product $product)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $review = $form->getData();
            $review->setUser($this->getUser());
            $review->setProduct($product);
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            $this->addFlash('notice', 'Successfully rated!');
            return $this->redirectToRoute('product_view', ['id' => $product->getId()]);
        }
        return $this->render('product/review_create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/product/review/delete/{id}", name="delete_review")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function deleteReview(int $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Review::class);
        $review = $repo->find($id);
        $product = $review->getProduct();
        if(null === $review){
            throw $this->createNotFoundException();
        }
        $em->remove($review);
        $em->flush();

        $this->addFlash('notice', 'Successfully deleted!');
        return $this->redirectToRoute('product_view', ['id' => $product->getId()]);
    }

    /**
     * @Route("/search", name="search_products")
     * @param Request $request
     * @return Response
     */
    public function searchProducts(Request $request)
    {
        $name = $request->get('name');
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $query = $repo->createQueryBuilder('n')
            ->where("n.name LIKE :name OR n.description LIKE :name")
            ->setParameter('name', '%'.$name.'%')
            ->getQuery();
        $result = $query->getResult();
        return $this->render('default/search.html.twig', ['result' => $result]);
    }
}
