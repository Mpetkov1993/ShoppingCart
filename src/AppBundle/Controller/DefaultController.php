<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();
        return $this->render('default/index.html.twig', ['categories' => $categories, 'products' => $products]);

    }
}
