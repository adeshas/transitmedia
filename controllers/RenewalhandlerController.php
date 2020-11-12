<?php

namespace PHPMaker2021\test;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * renewalhandler controller
 */
class RenewalhandlerController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Renewalhandler");
    }
}
