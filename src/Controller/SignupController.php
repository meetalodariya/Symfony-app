<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SignupController extends BaseController
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var PasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var RedirectResponse
     */
    private $response;
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function __construct(LoggerInterface $logger, UserPasswordEncoderInterface $encoder,UserRepository $repository
        , EntityManagerInterface $manager , UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($logger);
        $this->logger = $logger;
        $this->encoder = $encoder;
        $this->repository = $repository;
        $this->manager = $manager;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/signup" , name="signup")
     */
    public function signup(){
        return new Response($this->renderView('Index/signup.html.twig' , []));
    }

    /**
     * @Route("/register",name="register",methods={"POST","HEAD"})
     * @throws ORMException
     */
    public function register(Request $request){
        $user = new User();
        $userName = $request->get('username');
        $fullName = $request->get('fullname');
        $email = $request->get('email');
        $password = $request->get('password');
        $encoded = $this->encoder->encodePassword($user , $password);
        $user->setEmail($email);
        $user->setPassword($encoded);
        $user->setFullName($fullName);
        $user->setUsername($userName);
        try {
            $this->manager->persist($user);
            $this->manager->flush();
        } catch (ORMException $e) {
            throw $e;
        }
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

    /**
     * @Route("/getemail",name="getEmail",methods={"GET"})
     */
    public function getEmail(Request $request){
        $email =$request->query->get('email');
        $exist = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        if($exist)
        { return new JsonResponse([
            'exist'=> true
        ]);}

        return new JsonResponse([
            'exist'=> false
        ]);
    }
    /**
     * @Route("/getuser",name="getUsers",methods={"GET"})
     */
    public function getUsers(Request $request){
        $userName =$request->query->get('username');
        $exist = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['username'=>$userName]);
        if($exist)
        { return new JsonResponse([
            'exist'=> true
        ]);}

        return new JsonResponse([
            'exist'=> false
        ]);
    }
}

