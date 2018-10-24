<?php

namespace App\Controller;

use Cocur\Slugify\Slugify;

class AdminController
{
    protected $view;
    protected $tableData;

    public function __construct(\Slim\Views\Twig $view, $tableData)
    {
        $this->view = $view;
        $this->tableData = $tableData;
    }

    //--------------------Insert--------------------//

    public function insert($request, $response, $args)
    {
        return $this->view->render($response, "insert.twig");
    }

    public function insertpost($request, $response, $args){

        $titre = $request->getParam('titre');
        $auteur = $request->getParam('auteur');
        $date = date("y-m-d");
        $contenu = $request->getParam('contenu');

        $slugify = new Slugify();
        $slug = $slugify->slugify($request->getParam('titre'));

        $this->tableData->insert([
            'titre' => $titre,
            'auteur' => $auteur,
            'date' => $date,
            'contenu' => $contenu,
            'slug' => $slug,
        ]);

    }

    //--------------------Edit--------------------//

    public function edit($request, $response, $args)
    {
        $slug = $args['slug'];
        return $this->view->render($response, "edit.twig", ['slug' => $slug]);
    }

    public function editpost($request, $response, $args){

        $titre = $request->getParam('titre');
        $auteur = $request->getParam('auteur');
        $contenu = $request->getParam('contenu');

        $slugify = new Slugify();
        $newslug = $slugify->slugify($request->getParam('titre'));

        $this->tableData->where("slug", "=", $args['slug'])->update([
            'titre' => $titre,
            'auteur' => $auteur,
            'date' => date("y-m-d"),
            'contenu' => $contenu,
            'slug' => $newslug,
        ]);

        return $response->withJson(['message' => 'Article bien modifié !'], 200);

    }

    //--------------------Supp--------------------//

    public function supp($request, $response, $args){

        $this->tableData->where("slug", "=", $args['slug'])->delete();

    }

    //--------------------Api--------------------//

    public function apiSingle($request, $response, $args){
        $slug = $args['slug'];
        $post = $this->tableData->where("slug", "=", $slug)->first();
        return $response->withJson($post, 200);
    }

}