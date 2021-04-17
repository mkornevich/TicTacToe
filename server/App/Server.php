<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2021
 * Time: 22:40
 */

namespace App;


use App\Entities\Client;
use App\Handlers\Handler_onCloseConnection;
use App\Handlers\Handler_onOpenConnection;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface
{
    public function onOpen(ConnectionInterface $connection)
    {
        $handler = new Handler_onOpenConnection(new Client());
        $handler->execute(['connection' => $connection]);
    }

    public function onMessage(ConnectionInterface $from, $rawMsg)
    {
        try {
            $client = App::$clientDao->getByConnection($from);
            $msg = json_decode($rawMsg, true);

            $name = str_replace(['Screen.', '.'], ['_', '_'], $msg['event']);
            $handlerClass = "App\\Handlers\\Handler_$name";
            $handler = new $handlerClass($client);
            $handler->execute($msg['options']);
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL . $e->getTraceAsString();
        }
    }

    public function onClose(ConnectionInterface $connection)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $handler = new Handler_onCloseConnection(App::$clientDao->getByConnection($connection));
        $handler->execute([]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
        $this->onClose($conn);
    }
}