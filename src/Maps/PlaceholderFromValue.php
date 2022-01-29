<?php

namespace Drakuno\SqlTemplate\Maps;

use Drakuno\SqlTemplate as Sql;

class PlaceholderFromValue
{
	public function __construct(
		public string $label_prefix=":placeholder",
		public int $label_counter=1,
	)
	{}

	public function __invoke($value):Sql\Placeholder
	{
		$label = $this->labelMake($value);
		return new Sql\Placeholder($value,$label);
	}

	public function labelMake():string
	{
		return sprintf("%s%d",$this->label_prefix,$this->label_counter++);
	}
}

