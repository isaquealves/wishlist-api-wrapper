<?php

namespace WishlistWrapper\Clients;

use Guzzlehttp\Client;

class GuzzleClient
{
	protected $client;

	public function __construct()
	{

	}

	public function init($baseUrl)
	{

		$this->client =  new Client(
			[
				'base_url' => $this->baseUrl
			]
		);

		return $this->client;
	}

	public function post($fragmentUrl, $requestQueryParameters, $requestBody, $returnType)
	{
		$request = $this->client->createRequest(
			'POST',
			$fragmentUrl,
			'query' => $requestQueryParameters,
			'body' => $requestBody
		);


		$response = $this->client->send($request);

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


	public function get($fragmentUrl, $requestQueryParameters, $returnType)
	{
		$request = $this->client->createRequest(
			'GET',
			$fragmentUrl,
			'query' => $queryParameters
		);

		$response = $this->client->send($request);

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