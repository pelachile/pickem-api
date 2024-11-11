<?php

namespace App\Http\DataTransferObjects;

readonly class Game

{
	public function __construct(
		public string $id,
		public string $url,
		public string $date,
		public string $name,
		public string $shortName,
		public array $competitions,
	){}
}
