<?php
namespace Acme;

require "vendor/autoload.php";
use GuzzleHttp\Client as Client;

$client = new Client(['base_uri' => 'https://openlibrary.org/api/']);

$response = $client->request('GET', 'books?bibkeys=ISBN:0385472579,LCCN:62019420&format=json');
var_dump($response->getBody()->getContents());