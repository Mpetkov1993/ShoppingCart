<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();


        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $userRole = $em->getRepository(Role::class)
            ->findOneBy(["name" => "ROLE_USER"]);

        $user->setRole($userRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                'Successfully registered!');
            return $this->redirectToRoute('login');
        }
        return $this->render('user/register.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/profile", name="profile")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function profileAction()
    {
        $user = $this->getUser();
        if ($user === null) {
            throw $this->createNotFoundException('No product found');
        }
        return $this->render('user/profile.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/profile/edit", name="edit_profile")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('ROLE_USER')")
     */
    public function editAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $id = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $user = $repo->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->remove('username');
        $form->add('oldPassword', PasswordType::class, array('label' => 'Old Password'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$passwordEncoder->isPasswordValid($user, $user->getOldPassword())) {
            $form->get('oldPassword')->addError(new FormError('Old password does not match'));
        }
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash("notice", "Successfully edited!");
            return $this->redirectToRoute('profile');
        }
        return $this->render('user/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/my_products", name="my_products")
     * @Security("is_granted('ROLE_USER')")
     */
    public function myProductsAction()
    {
        $user = $this->getUser();
        if ($user === null) {
            throw $this->createNotFoundException('No products found');
        }
        return $this->render('user/products.html.twig', ['user' => $user]);
    }
}
