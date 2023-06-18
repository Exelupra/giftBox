<?php

namespace gift\api\action;

use gift\app\action\AbstractAction;
use gift\app\services\box\BoxService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetBoxeByIdAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
$id = $args['id'];
        $boxservice = new BoxService();
        $box = $boxservice->getBoxById($id);


        $data = ['type' => 'ressource','box' => $box];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}