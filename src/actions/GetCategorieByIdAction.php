<?php

namespace gift\app\actions;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use gift\app\services\prestations\PrestationsServices;
    use gift\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

    class GetCategorieByIdAction extends AbstractAction {

        public function __invoke(Request $request, Response $response, array $args): ResponseInterface {
            if(!isset($args['id'])){
                throw new HttpBadRequestException($request, "Paramètre manquant");
            } else {
                $categorie = PrestationsServices::getCategorieById($args['id']);
                $routeContext = RouteContext::fromRequest($request);
                $routeParser = $routeContext->getRouteParser();
                $twig = Twig::fromRequest($request);
                return $twig->render($response, 'categorieid.twig', $categorie);
            }
            return null;
        }
    }

?>