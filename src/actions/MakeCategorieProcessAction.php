<?php

namespace gift\app\actions;

    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\PrestationsServices as PrestationsServices;
    use Slim\Exception\HttpBadRequestException;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;
    use gift\app\services\utils\CsrfService as CsrfService;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Exception;

    class MakeCategorieProcessAction extends AbstractAction {

        public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
            
            $post_data = $request->getParsedBody();

            $token = $post_data['csrf'] ?? null;
            try{
                CsrfService::check($token);
            } catch(Exception $e){
                throw new HttpBadRequestException($request, $e->getMessage());
            }

            $data = [
                'libelle' => $post_data['libelle'] ?? 
                    throw new HttpBadRequestException($request, "libelle manquant"),
                'description' => $post_data['description'] ?? 
                    throw new HttpBadRequestException($request, "description manquante"),
            ];

            $categorie = PrestationsServices::createCategorie($data);
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('categ');
            return $response->withHeader('Location', $url)->withStatus(302);

        }
    }

?>