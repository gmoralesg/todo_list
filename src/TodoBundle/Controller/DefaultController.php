<?php

namespace TodoBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TodoBundle\Entity\Todo;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="welcome")
     */
    public function welcomeAction()
    {
        return $this->redirectToRoute('todo_list');
    }

    /**
     * @Route("/list", name="todo_list")
     * @Method("GET")
     */
    public function listAction()
    {
        // replace this example code with whatever you need
        return $this->render('@Todo/Default/index.html.twig', [
            'result' => $this->getList()
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

        return new Response(json_encode(($this->getList())));
    }

    /**
     * @Route("/change/{id}", name="todo_change")
     * @Method("PUT")
     */
    public function changeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $update = $this->getDoctrine()->getRepository('TodoBundle:Todo')->find($id);
        $update->setEstado(!$update->getEstado());
        $em->flush();

        return new Response(json_encode(($this->getList())));
    }

    /**
     * @Route("/remove/{id}", name="todo_remove")
     * @Method("DELETE")
     */
    public function removeAction($id) { 

        $em = $this->getDoctrine()->getManager();
        $delete = $this->getDoctrine()->getRepository('TodoBundle:Todo')->find($id);
        $em->remove($delete);
        $em->flush();
        
        return new Response(json_encode($this->getList()));
    }


    private function getList() {
        $list = $this->getDoctrine()->getRepository('TodoBundle:Todo')->findAll();
        $result = array();
        foreach($list as $e)
        {                   
            $name = $e->getNombre();
            $color = $e->getFechaCreacion()->format('d/m/Y');

            $result[] = array("id" => $e->getId(), 
                            "nombre" => $e->getNombre(), 
                            "fecha_creacion" => $e->getFechaCreacion()->format('d/m/Y'), 
                            "fecha_tope" => $e->getFechaTope()->format('d/m/Y'), 
                            "estado" => $e->getEstado());
        }
        return $result;
    }

}
