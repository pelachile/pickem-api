<?php

namespace App\Http\DataTransferObjects;

readonly class Team
{
	public function __construct(
		public string $uuid,
		public string $location,
		public string $homeAway,
		public string $logo,
		public string $url,
		public string $color,
		public string $alternateColor,
	){}
}
