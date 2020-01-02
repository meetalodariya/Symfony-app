<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 1:15 PM
 */

namespace App\Controller;


use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class LoginController extends AbstractController
{


    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {


        $this->logger = $logger;
    }


    //STEP-1
    /**
     * @Route("/", name="home_page")
     * @Route("/login", name="login_page")
     * @Route("/signup", name="signup_page")
     */
    public function login(){

       $html=  $this->render('login.html.twig' );
       return new Response($html);

    }

    /**
     * @Route("/submit", name="submit_page")
     * @param Request $request
     */
    public function submit(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');

        $this->logger->info($email);
        $this->logger->info($password);
        return new Response('email:'. $email . '<br>' .'password:' . $password);
    }




}