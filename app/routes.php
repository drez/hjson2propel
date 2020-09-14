<?php



use App\Application\Actions\Editor\ShowEditorAction;
use App\Application\Actions\Editor\ConvertEditorAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/p/hjson2propel/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/p/hjson2propel/', ShowEditorAction::class);
    $app->post('/p/hjson2propel/editor/convert', ConvertEditorAction::class);
};
