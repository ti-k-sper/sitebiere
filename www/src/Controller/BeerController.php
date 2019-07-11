<?php
namespace App\Controller;

use \Core\Controller\Controller;

use App\Controller\PaginatedQueryAppController;

class BeerController extends Controller
{

    public function __construct()
    {
        $this->loadModel('beer');
    }

    public function home()
    {
        $title = 'Beer shop - Home';
        $this->render(
            'beer/home',
            [
                "title" => $title,
                "connect" => false
            ]
        );
    }

    public function all()
    {
        $paginatedQuery = new PaginatedQueryAppController(
            $this->beer,
            $this->generateUrl('articles'), 9
        );

        $articles = $paginatedQuery->getItems();
        $tva = getenv('ENV_TVA');

        $title = 'Tous les articles';
        $this->render(
            'beer/articles',
            [
                "title" => $title,
                "articles" => $articles,
                "tva" => $tva,
                "paginate" => $paginatedQuery->getNavHtml()
            ]
        );
    }
}