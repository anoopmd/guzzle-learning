<?php
namespace Acme;

/**
 * This example is for demonstrating that, in case of custom handlers,
 * exceptions will be thrown when wrapping handler with guzzles handler stack
 * This is because guzzle implements the feature of
 * cookies, redirects, HTTP error exceptions handling via middleware
 */

require "vendor/autoload.php";
use GuzzleHttp\Client;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;


$handler = function ($request, $options) {
    $response = new Response(500, ["Content-Type" => "text/plain"], "Internal Server Error");
    return new FulfilledPromise($response);
};

/**
 * Creates a default handler stack that can be used by clients.
 *
 * The returned handler will wrap the provided handler or use the most
 * appropriate default handler for your system. The returned HandlerStack has
 * support for cookies, redirects, HTTP error exceptions, and preparing a body
 * before sending.
 */
$handlerStack = HandlerStack::create($handler); // Wrap w/ middleware

$client = new Client([
    'base_uri' => 'https://openlibrary.org/api/',
    'handler' => $handlerStack,
    'headers' => [
        'User-Agent' => 'testing/1.0',
        'Accept'     => 'application/json',
        'X-Foo'      => ['Bar', 'Baz']
    ]
]);

try {
    $response = $client->request('GET', 'books?bibkeys=ISBN:0385472579,LCCN:62019420&format=json');
    var_dump($response->getBody()->getContents());
    echo "No exception occured \n";
} catch (\Exception $exception) {
    echo "An exception occured \n";
    // var_dump($exception);
}
