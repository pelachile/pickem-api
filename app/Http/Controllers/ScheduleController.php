<?php

namespace App\Http\Controllers;

use App\Http\DataTransferObjects\Season;
use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetSeason;
use App\Http\Integrations\ESPNApiConnector\Requests\getCurrentWeekGames;
use App\Http\Integrations\ESPNApiConnector\Requests\GetWeeklyGames;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class ScheduleController extends Controller
{
	protected ESPNApiConnector $connector;
	protected GetSeason $currentSeason;
	protected GetCurrentWeekGames $getCurrentWeekGames;
	protected GetWeeklyGames $getWeeklyGames;

	public function __construct()
	{
		$this->connector = new ESPNApiConnector();
	}

	/**
	 * Display a listing of the resource.
	 * @return Season
	 * @throws FatalRequestException
	 * @throws RequestException|JsonException
	 */
	public function getSeason():Season
	{
		$request = new GetSeason();
		$response = $this->connector->send($request);
		return $response->dto();
	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws \JsonException
	 */
	public function getGameLinks(): string
	{
		$url = $this->getSeason()->week['url'];
		$url = explode('/nfl', $url);
		$requestGamesLinkUrl = new GetCurrentWeekGames($url[1]);
		$gameLinkUrl = $this->connector->send($requestGamesLinkUrl)->json()['events']['$ref'];
		$requestGamesLinkArray = new GetWeeklyGames($gameLinkUrl);

		$gameLinks = $this->connector->send($requestGamesLinkArray)->json()['items'];
		dd($gameLinks);
	}

}
