<?php

namespace PHPMaker2021\test;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * paymentshandler controller
 */
class PaymentshandlerController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Paymentshandler");
    }
}
