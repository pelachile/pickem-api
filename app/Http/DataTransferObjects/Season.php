<?php

namespace App\Http\DataTransferObjects;

readonly class Season
{

	public function __construct(
		public string $url,
		public string $year,
		public string $startDate,
		public string $endDate,
		public array  $week,
		public string $events
	){}

}
