<?php

namespace BooksSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
//    public function indexAction()
//    {
//        $number = mt_rand(0, 100);
//        
//        return $this->render('BooksSearchBundle:Default:index.html.twig', array(
//            'number' => $number,
//        ));
//    }
    
    public function booksAction($page, $key)
    {
        $br = $this->getDoctrine()->getRepository('BooksSearchBundle:Book');
        $books = $br->findBy(array(), array('id' => 'DESC'), 30);
        

        return $this->render('BooksSearchBundle:Default:index.html.twig', array(
            'books' => $books,
            'cnt' => count($books)
        ));
    }
}
