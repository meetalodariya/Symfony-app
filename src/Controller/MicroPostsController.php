<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 02/01/20
 * Time: 11:00 AM
 */

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/micro-post")
 */
class MicroPostsController extends  BaseController
{
    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactory
     */
    private $formFactory;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(LoggerInterface $logger , MicroPostRepository $microPostRepository,
                                FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,
                  FlashBagInterface $flashBag,RouterInterface $router)
    {
        parent::__construct($logger);
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/",name="micro-post-index")
     */
    public function index()
    {
        $html = $this->render('micro-posts/index.html.twig' ,
            ['posts' => $this->microPostRepository->findAll()]);

        return new Response($html);
    }

    /**
     * @Route("/show/{id}",name="micro_post_show")
     */
    public function postShow($id){
        $html = $this->render('micro-posts/show.html.twig', ['post'=> $this->microPostRepository->find($id)]);
        return new Response($html);
    }

    /**
     * @Route("/edit/{id}",name="micro-post-edit")
     */
    public function edit(Request $request, MicroPost $microPost){
        $form = $this->formFactory->create(MicroPostType::class,$microPost);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            return new RedirectResponse($this->router->generate('micro-post-index'));
        }
        return new Response($this->render('micro-posts/add.html.twig' , ['form' => $form->createView()]) );
    }

    /**
     * @Route("/add",name="micro-post-add")
     */
    public function add(Request $request)
    {
        $micropost = new MicroPost();
        $micropost->setDate(new \DateTime());
        $form = $this->formFactory->create(MicroPostType::class,$micropost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($micropost);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro-post-index'));
        }
        return new Response($this->render('micro-posts/add.html.twig' , ['form' => $form->createView()]) );
    }

    /**
     * @Route("/delete/{id}",name="micro-post-delete")
     */
    public function delete(MicroPost $microPost){

        $this->entityManager->remove($microPost);
        $this->entityManager->flush();
        $this->get('session')->getFlashBag()->set('notice', 'Post is deleted.');

        return new RedirectResponse($this->router->generate('micro-post-index' ));

        /*
        return new Response($this->render('micro-posts/index.html.twig' ,
            ['posts' => $this->microPostRepository->findAll()]));*/


    }
}