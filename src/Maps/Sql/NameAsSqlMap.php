<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\ProcessorInterface;

class NameAsSqlMap implements ProcessorInterface
{
	use ClassBasedHandlesTestTrait;

	const TARGET_CLASS = Name::class;

	public function __invoke(TemplateInterface $expr):string
	{
		return sprintf('"%s"',$expr->getValue());
	}
}