<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DumpFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $router = service('router');
        die(json_encode([
            'path' => $request->getPath(),
            'controller' => $router->controllerName(),
            'method' => $router->methodName(),
            'matchedRoute' => $router->getMatchedRoute()
        ]));
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
