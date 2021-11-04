<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\Comparison;
use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class ComparisonAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const OPERATORS	   = ["=","<","<=",">",">=","!="];
	const TARGET_CLASS = Comparison::class;

	public function __invoke(TemplateInterface $comparison):string
	{
		$partner = $this->getPartner();
		return sprintf("%s%s%s",
			$partner($comparison->getLeftTemplate()),
			self::OPERATORS[$comparison->getOperatorCode()],
			$partner($comparison->getRightTemplate())
		);
	}
}