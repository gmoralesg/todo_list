<?php

namespace TodoBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Todo;

class DefaultController extends Controller
{
    /**
     * @Route("/list", name="todo_list")
     * @Method("GET")
     */
    public function listAction()
    {
        $list = $this->getDoctrine()->getRepository('TodoBundle:Todo')->findAll();
        // replace this example code with whatever you need
        return $this->render('@Todo/Default/index.html.twig', [
            'result' => $list
        ]);
       
    }

    /**
     * @Route("/insert", name="todo_insert")
     * @Method("POST")
     */
    public function insertAction(Request $request)
    {
       

        $new = new Todo();
        $new->setNombre($request->get("nombre"));
        $new->setFechaCreacion( new DateTime(date('Y-m-d H:i:s')));
        $new->setFechaTope( new DateTime(date('Y-m-d H:i:s',strtotime($request->get("fecha_tope")))));
        $new->setEstado(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($new);
        $em->flush();

        return $this->redirectToRoute('todo_list');
    }
}
