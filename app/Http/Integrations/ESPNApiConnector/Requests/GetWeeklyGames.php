<?php

namespace App\Http\Integrations\ESPNApiConnector\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

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

}
