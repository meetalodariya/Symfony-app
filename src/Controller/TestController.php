<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 2:24 PM
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TestController
 * @package App\Controller
 *
 * @Route("/info")
 */
class TestController extends AbstractController
{


    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * TestController constructor.
     * @param SessionInterface $session
     * @param RouterInterface $router
     */
    public function __construct(SessionInterface $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router = $router;
    }



    /**
     * @Route("/home",name="index_home")
     */
    public  function home(){
        $html= $this->render('posts.html.twig' ,['posts' => $this->session->get('posts')]);
        return new Response($html);

    }


    /**
     * @Route("/add" , name="add_post")
     */
    public function add(){
        $post = $this->session->get('posts');

      //  $post = array();
        $post[uniqid()] = ['name' => 'john' , 'lastname'=> 'doe'];
        $this->session->set('posts' , $post);

        return new RedirectResponse($this->router->generate('index_home'));
    }

    /**
     * @Route("/{id}" , name="profile_user" )
     */
    public function show($id){
        $post = $this->session->get('posts');
        $html =   $this->render('profile.html.twig' , ['id' => $id , 'postByID' => $post[$id]]);

        return new Response($html);

    }

}