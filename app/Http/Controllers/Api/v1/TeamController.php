<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Integrations\ESPNApiConnector\ESPNApiConnector;
use App\Http\Integrations\ESPNApiConnector\Requests\GetSeason;
use App\Models\Team;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class TeamController extends Controller
{



    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

}
