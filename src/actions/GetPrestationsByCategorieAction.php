<?php

namespace gift\app\actions;

use gift\app\services\prestations\PrestationsServices;
use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;

    class GetPrestationsByCategorieAction extends AbstractAction {

        public function __invoke(Request $request, Response $response, array $args): Response {
            $prestations = PrestationsServices::getPrestationsByCategorie($args['id']);
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            
            $twig = Twig::fromRequest($request);
            return $twig->render($response, 'prestationscateg.twig', ['idcat' => $args['id'], 'prestations' => $prestations]);
        }
    }

?>



