<?php

namespace gift\app\actions;

use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Faker\Provider\Uuid;
use Slim\Routing\RouteContext;
use Exception;

use gift\app\services\prestations\BoxServices;

class MakeBoxProcessAction extends AbstractAction {

    public function __invoke(ServerRequestInterface $request, 
        ResponseInterface $response, array $args): ResponseInterface {
            
            $post_data = $request->getParsedBody();

            $token = $post_data['csrf'] ?? null;
            try{
                CsrfService::check($token);
            } catch(Exception $e){
                throw new HttpBadRequestException($request, $e->getMessage());
            }

            echo $token;

            $data = [
                'id' => Uuid::uuid(),
                'token' => $token,
                'libelle' => $post_data['libelle'] ?? 
                    throw new HttpBadRequestException($request, "libelle manquant"),
                'description' => $post_data['description'] ?? 
                    throw new HttpBadRequestException($request, "description manquante"),
            ];

            //verifier si la checkbox kdo est coché
            if(isset($post_data['kdo'])){
                $data['kdo'] = 1;
                $data['message_kdo'] = $post_data['kdomsg'] ?? 
                    throw new HttpBadRequestException($request, "message manquant");
            } else {
                $data['kdo'] = 0;
                $data['message_kdo  '] = "";
            }

            $box = BoxServices::createBox($data);
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('box');
            return $response->withHeader('Location', $url)->withStatus(302);
        
    }

}