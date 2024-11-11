<?php

namespace App\Http\Integrations\ESPNApiConnector\Requests;

use App\Http\DataTransferObjects\Season;
use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetCurrentWeek extends Request
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
        return '/seasons/2024';
    }

	/**
	 * @throws JsonException
	 */
	public function createDtoFromResponse(Response $response): Season
	{
			$data = $response->json();

			return new Season(
				url: $data['$ref'],
				year: $data['year'],
				startDate: $data['startDate'],
				endDate: $data['endDate'],
				week: [
					'url' => $data['type']['week']['$ref'],
					'weekNumber' => $data['type']['week']['number'],
					'startDate' => $data['type']['week']['startDate'],
					'endDate' => $data['type']['week']['endDate'],
					],
				events: $data['type']['week']['events']['$ref']
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
