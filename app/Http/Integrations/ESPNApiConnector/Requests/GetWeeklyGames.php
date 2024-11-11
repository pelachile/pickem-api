<?php

namespace App\Http\Integrations\ESPNApiConnector\Requests;

use App\Http\DataTransferObjects\Game;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetWeeklyGames extends Request
{

	public function __construct(protected readonly string $url) {

	}
	/**
	 * The HTTP method of the request
	 */
	protected Method $method = Method::GET;

	/**
	 * The endpoint for the request
	 */
	public function resolveEndpoint(): string
	{
		return $this->url;
	}

	/**
	 * @throws \JsonException
	 */
	public function createDtoFromResponse(Response $response): Game
	{
		$data = $response->json();

		return new Game(
			id: $data['id'],
			url: $data['$ref'],
			date: $data['date'],
			name: $data['name'],
			shortName: $data['shortName'],
			competitions: $data['competitions'],
		);
	}

	protected function defaultQuery(): array
	{
		return [
			'lang' => 'en',
			'region' => 'us'
		];
	}
}
