<?php

namespace BooksSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BooksSearchBundle\Form\BookSearch;
use BooksSearchBundle\Entity\Book;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    const NUM_ITEMS = 9;
    
    public function indexAction($page = 1)
    {
   
        $form = $this->createForm(BookSearch::class, null);
        
        $query = $this->getDoctrine()
          ->getRepository(Book::class)
          ->findDefault();
        
        return $this->returnListView($query, $page, $form);
    }
    
    public function searchAction($page = 1, Request $request)
    {        
        $form = $this->createForm(BookSearch::class, null);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            
            return $this->returnListView($query, $page, $form, $key);
        }
        
        return $this->redirectToRoute('homepage');
    }

    public function bookAction($id)
    {
        $book = $this->getDoctrine()
        ->getRepository(Book::class)
        ->findOneById($id);

        if (!$book) {
            throw $this->createNotFoundException('Book not found!');
        }

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer), array($encoder));

        
        $book = $serializer->serialize($book, 'json');

        return new JsonResponse(array('book' => json_encode($book)), 200);

        // return $this->render('BooksSearchBundle:Default:book.html.twig', array(
        //     'book' => $book,
        // ));
    }
    
    private function returnListView($query, $page, $form, $key = null)
    {
        $paginator  = $this->get('knp_paginator');
        
        $books = $paginator->paginate(
            $query, 
            $page,
            self::NUM_ITEMS,
            array('wrap-queries'=>true)
        );
        if ($key) {
            $books->setParam('key', $key);
        }            

        return $this->render('BooksSearchBundle:Default:index.html.twig', array(
            'books' => $books,
            'cnt' => count($books),
            'form' => $form->createView(),
        ));
    }
}
