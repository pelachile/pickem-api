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

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/example';
    }

	/**
	 * @throws \JsonException
	 */
	public function createDtoFromResponse(Response $response): Team
	{
		$data = $response->json();

		return new Team(
			uuid: $data['uuid'],
			location: $data['location'],
			homeAway: $data['homeAway'],
			logo: $data['logo'],
			url: $data['url'],
			color: $data['color'],
			alternateColor: $data['alternateColor'],
		);
	}
}
