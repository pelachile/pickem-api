<?php

namespace Tests;

use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetCurrentWeek;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

abstract class TestCase extends BaseTestCase
{
	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 */
	public function test_it_connects_to_Espn() {

		$connector = new ESPNApiConnector();
		$request = new GetCurrentWeek();

		$response = $connector->send($request);

		$this->assertEquals(200, (string)$response->status());

	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws \JsonException
	 */
	public function test_it_returns_current_week() {
		$connector = new ESPNApiConnector();
		$request = new GetCurrentWeek();

		$response = $connector->send($request);

		$this->assertContains('Week 10', $response->json('types')['items'][1]['week']);
		$this->assertTrue($response->isCached());


	}

	public function test_request_is_cached() {
		$connector = new ESPNApiConnector();
		$request = new GetCurrentWeek();

		$response = $connector->send($request);
		$this->assertTrue($response->isCached());

	}

	public function test_dto_creation() {
		$connector = new ESPNApiConnector();
		$response = $connector->send(new GetCurrentWeek());

		$season = $response->dto();
		dd($season);
	}
}

