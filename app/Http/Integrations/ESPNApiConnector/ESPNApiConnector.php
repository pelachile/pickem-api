<?php

namespace App\Http\Integrations\ESPNApiConnector;

use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class ESPNApiConnector extends Connector implements Cacheable
{
    use AcceptsJson, HasCaching;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'http://sports.core.api.espn.com/v2/sports/football/leagues/nfl/';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
					'Accept' => 'application/json',
					'Content' => 'application/json'
				];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [
					'lang' => 'en',
					'region' => 'us'
				];
    }

	public function resolveCacheDriver(): Driver
	{
		return new LaravelCacheDriver(Cache::store('database'));
	}

	public function cacheExpiryInSeconds(): int
	{
		return 3600*24;
	}
}
