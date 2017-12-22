<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category/view/{name}", name="category_view")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Category $category)
    {
        if ($category === null) {
            throw $this->createNotFoundException('No category found');
        }
        return $this->render('category/view.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/category/create", name="category_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Successfully created!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('category/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/category/delete/{id}", name="category_delete")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('ROLE_EDITOR')")
     */
    public function deleteAction(int $id=null){

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Category::class);
        $category = $repo->find($id);
        if(null === $category){
            throw $this->createNotFoundException();
        }
        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'notice',
            'Successfully deleted!');
        return $this->redirectToRoute('homepage');

    }
}
