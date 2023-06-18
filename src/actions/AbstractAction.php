<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

abstract class AbstractAction {
    abstract public function __invoke(Request $request, Response $response, array $args): Response;

    protected function getGlobalTemplateVar(Request $request): array {
        
        $routeContext = RouteContext::fromRequest($request)->getRouteParser();

        $output = [
            "globals" => [
                'css_dir' => 'css',
                'imd_dir' => 'img',
                'menu' => [
                    ['url' => $routeContext->urlFor('categ'), 'libelle' => 'categories'],
                    ['url' => $routeContext->urlFor('boxform'), 'libelle' => 'créer ma box'],
                    ['url' => '#', 'libelle' => 'voir ma box'],
                    ['url' => $routeContext->urlFor('gestioncatalogue'), 'libelle' => 'gerer le catalogue'],
                    ['url' => '#', 'libelle' => 'signin'],
                    ['url' => '#', 'libelle' => 'register']
                ]
            ]
        ];
        return $output;
    }
}