<?php

namespace gift\app\actions;

    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\BoxServices as BoxServices;
    use Slim\Views\Twig;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Slim\Routing\RouteContext;

    class GetBoxAction extends AbstractAction {

        public function __invoke(ServerRequestInterface $request, 
            ResponseInterface $response, array $args): ResponseInterface {
            $data = BoxServices::getBoxs();
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            foreach($data as $key => $value){
                $data[$key]['url'] = $routeParser->urlFor('boxid', ['id' => $value['id']]);
            }
            $view = Twig::fromRequest($request);
            return $view->render($response, 'box.twig', ['box' => $data]);
            /**/
            
        }
    }