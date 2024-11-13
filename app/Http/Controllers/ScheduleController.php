<?php

namespace App\Http\Controllers;

use App\Http\DataTransferObjects\Game;
use App\Http\DataTransferObjects\Season;
use App\Http\DataTransferObjects\Team;
use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetSeason;
use App\Http\Integrations\ESPNApiConnector\Requests\GetWeeklySchedule;
use App\Http\Integrations\ESPNApiConnector\Requests\GetWeeklyGames;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class ScheduleController extends Controller
{
	protected ESPNApiConnector $connector;
	protected GetSeason $currentSeason;
	protected GetWeeklySchedule $getCurrentWeekGames;
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
	public function getWeeklySchedule(): GetWeeklyGames
	{
		$url = $this->getSeason()->week['url'];
		$url = explode('/nfl', $url);
		$requestGamesLinkUrl = new GetWeeklySchedule($url[1]);
		$gameLinkUrl = $this->connector->send($requestGamesLinkUrl)->json()['events']['$ref'];
		return new GetWeeklyGames($gameLinkUrl);
	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws JsonException
	 */
	public function getGames()
	{
		$request = $this->getWeeklySchedule();
		$games = $this->connector->send($request);
		$gameArray = $games->json()['items'];
		$dtos = [];
		foreach ($gameArray as $game) {
			$request = new GetWeeklyGames($game['$ref']);
			$response = $this->connector->send($request);
			$dtos[] = $response->dto();
		}

		return $dtos;
	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws JsonException
	 */
	public function getTeams()
	{
		$teams = $this->getGames();

		$games = [];
		foreach ($teams as $team) {
		$games[] = $team->competitions[0]['competitors'];
		}

		$homeTeam = [];
		$awayTeam = [];
		for ($i=0;$i<count($games); $i++) {
			$homeTeam[] = $games[$i][0]['team']['$ref'];
			$awayTeam[] = $games[$i][1]['team']['$ref'];
		}

	return $homeTeam[0] . ' vs ' . $awayTeam[0];
	}


}
