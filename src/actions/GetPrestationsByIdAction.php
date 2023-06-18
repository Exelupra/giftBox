<?php

namespace gift\app\actions;

use gift\app\services\prestations\BoxServices;
use gift\app\services\prestations\PrestationsServices;
use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Exception\HttpBadRequestException;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;

    class GetPrestationsByIdAction extends AbstractAction {

        public function __invoke(Request $request, Response $response, array $args): Response {
            if(isset($args['id'])){
                $prestations = PrestationsServices::getPrestationById($args['id']);
                $boxs = BoxServices::getBoxs();
            } else {
                throw new HttpBadRequestException($request, "Paramètre manquant");
            }
                $routeContext = RouteContext::fromRequest($request);
                $routeParser = $routeContext->getRouteParser();
                $url = $routeParser->urlFor('prestcateg', ['id' => $prestations['cat_id']]);
                $twig = Twig::fromRequest($request);
                return $twig->render($response, 'prestationsid.twig', ['p' => $prestations, 'boxs'=>$boxs, 'idcat' => $prestations['cat_id']]);
        }
    }

?>