<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\App;
use App\Server;

require './vendor/autoload.php';
require './strings.php';

App::init();

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server()
        )
    ),
    8080
);
$server->run();