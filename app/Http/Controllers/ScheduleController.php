<?php

namespace App\Http\Controllers;

use App\Http\DataTransferObjects\Game;
use App\Http\DataTransferObjects\Season;
use App\Http\DataTransferObjects\Team;
use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetSeason;
use App\Http\Integrations\ESPNApiConnector\Requests\GetTeams;
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
	public function getWeeklySchedule(): array
	{
		$url = $this->getSeason()->week['url'];
		$url = explode('/nfl', $url);
		$request = new GetWeeklySchedule($url[1]);
		$response = $this->connector->send($request)->json()['events']['$ref'];
		$games = new GetWeeklyGames($response);
		$response = $this->connector->send($games);
		return $response->json()['items'];
	}

	/**
	 * @throws FatalRequestException
	 * @throws RequestException
	 * @throws JsonException
	 */
	public function getGames(): array
	{
		$links = $this->getWeeklySchedule();
		$games = [];
		foreach ($links as $link) {
			$request = new GetWeeklyGames($link['$ref']);
			$response = $this->connector->send($request);
			$games[] = $response->dto();
		}
	return $games;
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
		$teams = [];
		for ($i=0;$i<count($games); $i++) {
			$homeTeamUrl[$i] = explode('/nfl',$games[$i][0]['team']['$ref']);
			$homeTeam[$i] = $homeTeamUrl[$i][1];
			$awayTeamUrl = explode('/nfl', $games[$i][1]['team']['$ref']);
			$awayTeam[$i] = $awayTeamUrl[1];
			$teams['home'] = new GetTeams($homeTeam[$i]);
			$homeResponse = $this->connector->send($teams['home']);
			$teams[$i]['home'] = $homeResponse->dto();
			$teams['away'] = new GetTeams($awayTeam[$i]);
			$awayResponse = $this->connector->send($teams['away']);
			$teams[$i]['away'] = $awayResponse->dto();

		}

		return $teams;

	}


}
