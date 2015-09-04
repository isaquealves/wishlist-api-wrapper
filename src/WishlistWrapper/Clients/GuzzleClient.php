<?php

namespace WishlistWrapper\Clients;

use GuzzleHttp\Client;

class GuzzleClient
{
    protected $client;

    public function __construct($baseUrl)
    {

        $this->client =  new Client(
            [
                'base_url' => $baseUrl
            ]
        );

        return $this;

    }

    /**
     * Build and executes a post request over wishlist api address
     * @param  [type] $fragmentUrl            The fragment url which have to be accessed
     * @param  [type] $requestBody            Request body content
     * @param  [type] $returnType             Type of return
     * @return [type]                         [description]
     */
    public function post($fragmentUrl, $requestBody, $returnType)
    {
        $request = $this->client->createRequest(
            'POST',
            $fragmentUrl,
            [
                'body' => $requestBody
            ]
        );
       
        $response = $this->client->send($request);

        return $response;
    }


    public function get($fragmentUrl, $requestQueryParameters, $returnType)
    {
        $request = $this->client->createRequest(
            'GET',
            $fragmentUrl,
            ['query' => $queryParameters]
        );

        $response = $this->client->send($request);

        return $this->returns($response,$returnType);
    }

    private function returns($response, $returnType)
    {
        switch($returnType) {

            case 'xml':
                return $response->xml();
                break;
            case 'php':
                return serialize($response->json());
                break;
            default:
                return $response->json();
        }
    }
}