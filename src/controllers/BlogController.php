<?php

namespace App\Controller;

class BlogController
{
    protected $view;
    protected $tableData;

    public function __construct(\Slim\Views\Twig $view, $tableData)
    {
        $this->view = $view;
        $this->tableData = $tableData;
    }

    public function home($request, $response, $args)
    {
        return $this->view->render($response, "index.twig");
    }

    public function show($request, $response, $args)
    {
        $articles = $this->tableData->get();
        return $this->view->render($response, "blog.twig", ['posts' => $articles]);
    }

    public function single($request, $response, $args)
    {
        $slug = $args['slug'];
        $post = $this->tableData->where("slug", "=", $slug)->first();
        return $this->view->render($response, "single.twig", ['post' => $post]);
    }

}
