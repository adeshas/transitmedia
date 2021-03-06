<?php

namespace PHPMaker2021\test;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ZPriceSettingsController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ZPriceSettingsList");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ZPriceSettingsView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ZPriceSettingsEdit");
    }

    // update
    public function update(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ZPriceSettingsUpdate");
    }
}
