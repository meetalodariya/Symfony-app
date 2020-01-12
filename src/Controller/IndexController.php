<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 1:15 PM
 */

namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class IndexController extends BaseController
{

    //STEP-1
    /**
     * @Route("/", name="home_page")
     * @Route("/signup", name="signup_page")
     */
    public function index(AuthenticationUtils $authenticationUtils){


        $html=  $this->render('Index/home.html.twig' , ['last_username' => $authenticationUtils->getLastUsername() , 'error' => $authenticationUtils->getLastAuthenticationError()]);
       return new Response($html);

    }

}