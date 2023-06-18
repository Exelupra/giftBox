<?php

namespace gift\app\actions;

    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\BoxServices as BoxServices;
    use Slim\Exception\HttpBadRequestException;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Routing\RouteContext;
    use Slim\Views\Twig;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    class GetBoxByIdAction extends AbstractAction {

        public function __invoke(ServerRequestInterface $request, 
            ResponseInterface $response, array $args): ResponseInterface {
                if(!isset($args['id'])){
                    throw new HttpBadRequestException($request, "Paramètre manquant");
                } else {
                    $box = BoxServices::getBoxById($args['id']);
                        $routeContext = RouteContext::fromRequest($request);
                        $routeParser = $routeContext->getRouteParser();
                        $twig = Twig::fromRequest($request);
                        return $twig->render($response, 'boxid.twig', $box);
                }
                return null;
            
        }
    }