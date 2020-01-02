<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 02/01/20
 * Time: 11:00 AM
 */

namespace App\Controller;

/**
 * @Route("/micro-post")
 */
class MicroPosts extends BaseController
{


    /**
     * @Route("/",name="micro-post-index")
     */
    public function index()
    {
        echo "here"; exit;
    }
}