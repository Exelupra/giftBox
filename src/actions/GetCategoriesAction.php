<?php

namespace gift\app\actions;

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\PrestationsServices as PrestationsServices;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;

    class GetCategoriesAction extends AbstractAction {

        public function __invoke(Request $request, Response $response, array $args): Response {
            $prestationsService = PrestationsServices::getCategories();
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            foreach($prestationsService as $key => $value){
                $prestationsService[$key]['url'] = $routeParser->urlFor('categid', ['id' => $value['id']]);
            }
            $twix = Twig::fromRequest($request);
            return $twix->render($response, 'categories.twig', ['categories' => $prestationsService]);
        }
    }

?>