<?php

namespace BooksSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BooksSearchBundle\Form\BookSearch;
use BooksSearchBundle\Entity\Book;


class DefaultController extends Controller
{
    const NUM_ITEMS = 9;
    
    public function indexAction($page = 1)
    {
   
        $form = $this->createForm(BookSearch::class, null);
        
        $query = $this->getDoctrine()
          ->getRepository(Book::class)
          ->findDefault();
        
        return $this->returnView($query, $page, $form);
    }
    
    public function searchAction($page = 1, Request $request)
    {        
        $form = $this->createForm(BookSearch::class, null);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $key = $data['key'];
//            $where = $data['where'];
            $key = $form->get('key')->getData();
            $where = $form->get('where')->getData();
            switch ($where) {                
                case BookSearch::SEARCH_TITLE:
                    $query = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->findByTitle($key, self::NUM_ITEMS);
                    break;
                case BookSearch::SEARCH_AUTHOR:
                    $query = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->findByAuthor($key, self::NUM_ITEMS);
                    break;
                case BookSearch::SEARCH_EVERYWHERE:
                default:
                    $query = $this->getDoctrine()
                        ->getRepository(Book::class)
                        ->findByTitleOrAuthor($key, self::NUM_ITEMS);
            }
            
            return $this->returnView($query, $page, $form, $key);
        }
        
        return $this->redirectToRoute('homepage');
    }
    
    private function returnView($query, $page, $form, $key = "")
    {
        $paginator  = $this->get('knp_paginator');
        
        $books = $paginator->paginate(
            $query, 
            $page,
            self::NUM_ITEMS,
            array('wrap-queries'=>true)
        );
        $books->setParam('key', $key);

        return $this->render('BooksSearchBundle:Default:index.html.twig', array(
            'books' => $books,
            'cnt' => count($books),
            'form' => $form->createView(),
        ));
    }
}
