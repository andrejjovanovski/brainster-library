<?php
require_once "./Clients/Client.php";

use Clients\Client as Client;

$client = new Client();

echo json_encode($client->isUsernameAvailable());