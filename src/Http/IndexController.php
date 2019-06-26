<?php

namespace App\Http;

use App\Entities\Book;

class IndexController extends Controller
{
    public function indexAction()
    {
        $entityManager = app()->get('orm')->getEntityManager();

        $book = new Book();

        $book->title = 'Test doctrine';

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render("index", [
            'title' => 'Index Page'
        ]);
    }

    public function pageAction($alias)
    {
        $entityManager = app()->get('orm')->getEntityManager();

        $book = new Book();

        $book->title = $alias;

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->render("index", [
            'title' => 'создана новая запись в БД'
        ]);
    }


}