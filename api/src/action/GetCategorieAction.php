<?php

namespace gift\api\action;

use gift\app\action\AbstractAction;
use gift\app\services\prestation\PrestationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetCategorieAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $prestationService = new PrestationService();
        $categories = $prestationService->getCategorie();
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $categories_data = [];
        foreach ($categories as $categorie) {
            array_push($categories_data,['caegorie' => $categorie, 'links' => ['self' => ['href' => $routeParser->urlFor('apicategories', ['id' => $categorie['id']])]]]);
        }
        $data = ['type' => 'collection','count'=>count($categories) ,'categories' => $categories_data];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}