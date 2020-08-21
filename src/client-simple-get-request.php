<?php
namespace Acme;

require "vendor/autoload.php";
use GuzzleHttp\Client as Client;

$client = new Client();

$response = $client->request('GET', 'https://openlibrary.org/api/books?bibkeys=ISBN:0385472579,LCCN:62019420&format=json');
var_dump($response->getBody()->getContents());