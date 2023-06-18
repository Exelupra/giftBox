<?php

namespace gift\app\actions;

use gift\app\services\prestations\BoxServices;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

class GetPrestationByBoxAction extends AbstractAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $data = BoxServices::getPrestationByBox($args['id']);
        $box = BoxServices::getBoxById($args['id']);
        $routeContext = RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'prestabox.twig', ['box' => $box,'prestations' => $data]);
    }

}