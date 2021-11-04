<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Value;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;

class ValueAsSqlMap implements SqlMapInterface
{
	use ClassBasedHandlesTestTrait;

	const TARGET_CLASS = Value::class;

	public function __invoke(TemplateInterface $expr):string
	{
		$value = $expr->get();
		if (is_string($value))
			return sprintf("'%s'",strtr($value,["'"=>"''"]));
		else if (is_numeric($value))
			return strval($value);
		else if (is_bool($value))
			return $value?"TRUE":"FALSE";
		else if (is_null($value))
			return "NULL";
		else
			throw new Exception("Unknown value representation");
	}
}