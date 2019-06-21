<?php

namespace App\Http;

class IndexController extends Controller
{
    public function indexAction()
    {
        dump(app()->get('config')->get('database.dbname'));
        return $this->render("index", [
            'title' => 'Index Page'
        ]);
    }

    public function pageAction()
    {
        dd('yap!!! - pageAction');
        return $this->render("index", [
            'title' => 'Index Page'
        ]);
    }


}