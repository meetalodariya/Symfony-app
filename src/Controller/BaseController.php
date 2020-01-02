<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 11:56 PM
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController
{
    /**
     * @Route("/auth/login", methods={"POST","HEAD"})
     *
     */
    public function login(Request $request){
        $email = $request->get('email');
        $password = $request->get('password');
        $this->logger->info($email);
        $this->logger->info($password);
        return new Response('email:'. $email . '<br>' .'password:' . $password);
    }
}
