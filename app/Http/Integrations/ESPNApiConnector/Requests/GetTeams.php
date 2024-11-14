<?php

namespace App\Http\Integrations\ESPNApiConnector\Requests;

use App\Http\DataTransferObjects\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeams extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

		public function __construct(protected readonly string $url)
		{

		}

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
	public function createDtoFromResponse(Response $response): Team
	{
		$data = $response->json();
		return new Team(
			$data['id'],
			$data['location'],
			$data['name'],
			$data['logos'][0]['href'],
			$data['$ref'],
			$data['color'],
			$data['alternateColor'],
		);
	}
}
