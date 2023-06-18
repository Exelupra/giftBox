<?php

namespace gift\app\actions;

use gift\app\services\prestations\BoxServices;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class DelPrestationAction extends AbstractAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface{

            $post_data = $request->getParsedBody();
            
            $data = [
                'boxid' => $post_data['idbox'] ?? 
                    throw new HttpBadRequestException($request, "boxid manquant"),
                'prestid' => $post_data['idprest'] ??
                    throw new HttpBadRequestException($request, "prestid manquant"),
            ];
            
            $boxservices = BoxServices::delPrestation($data);
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('prestabox', ['id' => $data['boxid']]);
            return $response->withHeader('Location', $url)->withStatus(302);

    }
}