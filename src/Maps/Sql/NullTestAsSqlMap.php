<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\NullTest;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class NullTestAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const TARGET_CLASS = NullTest::class;

	public function __invoke(TemplateInterface $test):string
	{
		return sprintf("%s IS %s",
			$this->getPartner()($test->getTarget()),
			$test->getNegated()?"NOT NULL":"NULL"
		);
	}
}