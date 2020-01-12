<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 11:56 PM
 */

namespace App\Controller;


use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BaseController extends AbstractController
{

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function getLogger(){
        return $this->logger;
    }
}
