<?php

/** davidggdev - main index controller */

/**
 * @OA\Info(title="Balrog API", version="0.1.0")
 */

namespace Balrog;

/** 
 * @OA\Info(
 *     version="0.1.0",
 *     title="Balrog API",
 *     description="Example info",
 *     @OA\Contact(name="Swagger API Team")
 * )
 * @OA\Server(
 *     url="http://192.168.1.6:9010/",
 *     description="API server"
 * )
 */
class Handler
{
    /**
     * @var ?Utils  $utils  Utils class instance
     */
    private ?Utils $utils = null;

    /**
     * @var ?Router $router  Router class instance
     */
    private ?Router $router = null;

    /**
     * @var ?array  $endpoints  Endpoints allowed collection
     */
    private ?array $endpoints = null;

    /**
     * @var ?array  $url    Collection with url values
     */
    private ?array $url = null;

    /**
     * Setup and enable Api
     */
    public function __construct(array $endpoints)
    {
        $this->endpoints = $endpoints;
        $this->utils = new Utils();
        $this->router = new Router();

        if (!$this->enableConfiguration()) {
            echo $this->utils->parseArrayToJson(["Total error"]);
            die();
        }

        $this->url = $this->router->getRoute();
        $this->checkRoute();
    }
  
    /**
     * Check configuration security most basic level
     */
    private function enableConfiguration(): bool
    {
        try {
            /** Check request schema security access */
            if (!isset($_SERVER['REQUEST_SCHEME'])) {
                throw new \Exception('Fatal error: RESQUEST_SCHEME not found');
            } else {
                if (true === BLR_ENABLE_ONLY_HTTPS && 'http' === $_SERVER['REQUEST_SCHEME']) {
                    throw new \Exception('Fatal error: Client rejected');
                }
            }

            /** Check request methods alloweds */
            if (!isset($_SERVER['REQUEST_METHOD'])) {
                throw new \Exception('Fatal error: REQUEST_METHOD not found');
            } else {
                if (false === in_array($_SERVER['REQUEST_METHOD'], explode(',', BLR_REQUEST_ALLOW))) {
                    throw new \Exception('Fatal error: Client rejected');
                }
            }
            return true;
        } catch (\Exception $th) {
            echo $this->utils->parseArrayToJson([$th->getMessage()], JSON_THROW_ON_ERROR);
            die();
        }
        return false;
    }

    /**
     * Check and execute statics endpoints methods
     */
    private function checkRoute()
    {
        /** Forbidden root */
        if ($this->url['request_uri'] === '/') {
            $this->setResponse('403');
        }
  
        /** Check endpoints */
        foreach ($this->endpoints as $action => $payload) {
            if ($this->url['request_uri'] === "/api$action") {
                $class = "Balrog\\$payload[0]";
                if(!class_exists($class)){
                    $this->setResponse('403');
                } 
                call_user_func_array([new $class,$payload[1]],[]);         
                return $this->setResponse('200');
            }
        }
        return $this->setResponse('404');
    }

    /**
     * Set response and die if begin by 4xx
     */
    private function setResponse(string $statusCode)
    {
        http_response_code($statusCode);

        // if status code begin by 4xx then die execution
        if ($statusCode[0] === '4') {
            echo $statusCode;
            die();
        }
    }
}
