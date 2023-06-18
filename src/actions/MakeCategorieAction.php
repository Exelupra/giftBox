<?php

namespace gift\app\actions;

    use gift\app\actions\AbstractAction as AbstractAction;
    use gift\app\services\prestations\PrestationsServices as PrestationsServices;
    use Slim\Views\Twig;
    use Slim\Routing\RouteContext;
    use gift\app\services\utils\CsrfService as CsrfService;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;

    class MakeCategorieAction extends AbstractAction {

        public function __invoke(ServerRequestInterface $request, 
            ResponseInterface $response, array $args): ResponseInterface {
            $data = [
                'csrf' => CsrfService::generate()
            ];
            $view = Twig::fromRequest($request);
            return $view->render($response, 'categoriecreate.twig', 
                array_merge($data, $this->getGlobalTemplateVar($request)));
            /**/
            
        }
    }

?>