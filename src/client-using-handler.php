<?php
namespace Acme;

/**
 * This example is for demonstrating that we can pass a custom handler
 * and override the default handler of guzzle that makes the http call
 */

require "vendor/autoload.php";
use GuzzleHttp\Client;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;

// A handler function accepts a Psr\Http\Message\RequestInterface and array of request
// options and returns a GuzzleHttp\Promise\PromiseInterface that is fulfilled with a
// Psr\Http\Message\ResponseInterface or rejected with an exception.
$handler = function ($request, $options) {
    $response = new Response(200, ["Content-Type" => "text/plain"], "Hello World");
    return new FulfilledPromise($response);
};
$client = new Client([
    'base_uri' => 'https://openlibrary.org/api/',
    'handler' => $handler,
    'headers' => [
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'X-Foo'      => ['Bar', 'Baz']
    ]
]);

$response = $client->request('GET', 'books?bibkeys=ISBN:0385472579,LCCN:62019420&format=json');
var_dump($response->getBody()->getContents());