<?php

namespace gift\app\actions;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\BoxServices as BoxServices;
    use Slim\Exception\HttpBadRequestException;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;

    class AddPrestationAction extends AbstractAction {

        public function __invoke(Request $request, Response $response, array $args): Response {
            $post_data = $request->getParsedBody();
            
            $data = [
                'boxid' => $post_data['boxid'] ?? 
                    throw new HttpBadRequestException($request, "boxid manquant"),
                'prestid' => $post_data['prestid'] ??
                    throw new HttpBadRequestException($request, "prestid manquant"),
                'qte' => $post_data['qte'] ??
                    throw new HttpBadRequestException($request, "qte manquant"),
            ];
            
            $boxservices = BoxServices::addPrestation($data);
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('prestabox', ['id' => $data['boxid']]);
            return $response->withHeader('Location', $url)->withStatus(302);

        }
    }