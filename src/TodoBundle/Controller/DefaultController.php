<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $list = $this->getDoctrine()->getRepository('TodoBundle:Todo')->findAll();
        // replace this example code with whatever you need
        return $this->render('@Todo/Default/index.html.twig', [
            'result' => $list
        ]);
       
    }
}
