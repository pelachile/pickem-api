<?php

namespace App\Http\Controllers;

use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetCurrentWeek;
use App\Http\Integrations\ESPNApiConnector\Requests\getCurrentWeekGames;
use App\Http\Integrations\ESPNApiConnector\Requests\GetWeeklyGames;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class ScheduleController extends Controller
{
	protected ESPNApiConnector $connector;
	protected GetCurrentWeek $currentWeek;
	protected GetCurrentWeekGames $getCurrentWeekGames;
	protected GetWeeklyGames $getWeeklyGames;

	public function __construct()
	{
		$this->connector = new ESPNApiConnector();
	}

	/**
	 * Display a listing of the resource.
	 * @return string
	 * @throws FatalRequestException
	 * @throws RequestException|\JsonException
	 */
	public function getCurrentWeek():string
	{
		$request = new GetCurrentWeek();
		$response = $this->connector->send($request);
//		return $response->json('types')['items'][1]['week']['$ref'];
		return json_encode($response->dto());
	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws \JsonException
	 */
	public function getGameLinks(): array
	{
		$week = $this->getCurrentWeek();
		$url = explode('/nfl', $week);
		$requestGamesLinkUrl = new GetCurrentWeekGames($url[1]);

		$gameLinkUrl = $this->connector->send($requestGamesLinkUrl)->json()['events']['$ref'];

		$requestGamesLinkArray = new GetWeeklyGames($gameLinkUrl);

		$gameLinks = $this->connector->send($requestGamesLinkArray)->json()['items'];

		return $gameLinks;

	}

}
