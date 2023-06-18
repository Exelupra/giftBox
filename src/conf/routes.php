<?php

use gift\app\actions\GetCategoriesAction;
use gift\app\actions\GetCategorieByIdAction;
use gift\app\actions\GetPrestationsByIdAction;
use gift\app\actions\GetPrestationsByCategorieAction;
use gift\app\actions\GetPrestationsAction;
use gift\app\actions\MakeCategorieAction;
use gift\app\actions\MakeCategorieProcessAction;
use gift\app\actions\GetBoxAction;
use gift\app\actions\GetBoxByIdAction;
use gift\app\actions\MakeBoxAction;
use gift\app\actions\GetPrestationByBoxAction;
use gift\app\actions\MakeBoxProcessAction;
use gift\app\actions\AddPrestationAction;
use gift\app\actions\DelPrestationAction;
use gift\app\actions\UpdatePrestationAction;
use Slim\Views\Twig;


   return function ($app) {

        $app->get('', function ($request, $response, $args) {
            $twig = Twig::fromRequest($request);
            return $twig->render($response, 'home.twig');
        })->setName('home');

        $app->get('/categories', GetCategoriesAction::class)->setName('categ');

        $app->get('/prestations/[{id}[/]]', GetPrestationsByIdAction::class)->setName('prestid');

        $app->get('/categories/{id:\d+}/prestations', GetPrestationsByCategorieAction::class)->setName('prestcateg');

        $app->get('/prestations', GetPrestationsAction::class)->setName('prest');

        $app->get('/categories/[{id:\d+}[/]]', GetCategorieByIdAction::class)->setName('categid');

        $app->get('/categories/create[/]', MakeCategorieAction::class)->setName('catcreate');
        $app->post('/categories/create[/]', MakeCategorieProcessAction::class)->setName('catcreated');

        $app->get('/boxs', GetBoxAction::class)->setName('box');
        
        $app->get('/boxs/{id}/prestations', GetPrestationByBoxAction::class)->setName('prestabox');

        $app->get('/boxs/[{id}[/]]', GetBoxByIdAction::class)->setName('boxid');/**/

        $app->get('/box/create[/]', MakeBoxAction::class)->setName('boxform');
        $app->post('/box/create[/]', MakeBoxProcessAction::class)->setName('boxcreated');

        $app->post('/box/addprestation',AddPrestationAction::class)->setName('add2box');
        $app->post('/box/delprestation',DelPrestationAction::class)->setName('del2box');
        $app->post('/box/updateprestation',UpdatePrestationAction::class)->setName('updatebox');

        $app->get('/catalogue', function ($request, $response, $args) {
            //hello world
        })->setName('gestioncatalogue');

};

?>