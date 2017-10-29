<?php

namespace BooksSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
//    public function indexAction()
//    {
//        return $this->render('BooksSearchBundle:Post:index.html.twig', array(
//            // ...
//        ));
//    }

    public function searchAction() {
        $form = $this->createForm(BookSearch::class, null);
    }
}
