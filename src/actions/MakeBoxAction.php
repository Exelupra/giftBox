<?php

namespace gift\app\actions;

use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class MakeBoxAction extends AbstractAction {

    public function __invoke(ServerRequestInterface $request, 
            ResponseInterface $response, array $args): ResponseInterface {
            $data = [
                'csrf' => CsrfService::generate()
            ];
            $view = Twig::fromRequest($request);
            return $view->render($response, 'boxform.twig', 
                array_merge($data, $this->getGlobalTemplateVar($request)));
            /**/
            
        }

}