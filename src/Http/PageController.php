<?php

namespace App\Http;

class PageController extends Controller
{
    public function showAction($alias)
    {
        return $this->render("page", [
            'alias' => $alias
        ]);
    }
}