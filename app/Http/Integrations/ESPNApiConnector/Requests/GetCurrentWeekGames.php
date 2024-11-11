<?php

namespace App\Http\Integrations\ESPNApiConnector\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCurrentWeekGames extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;



		public function __construct(protected readonly string $url) {

		}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/'. $this->url;
    }
}
