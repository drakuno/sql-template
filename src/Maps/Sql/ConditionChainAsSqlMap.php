<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\ConditionChain;
use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class ConditionChainAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const KEYWORDS	   = ["AND","OR"];
	const TARGET_CLASS = ConditionChain::class;

	public function __invoke(TemplateInterface $chain):string
	{
		$keyword = self::KEYWORDS[$chain->getType()];
		return implode(
			" $keyword ",
			array_map(
				[$this,"childMap"],
				$chain->getConditions()
			)
		);
	}

	public function childMap(TemplateInterface $child):string
	{
		$sql = $this->getPartner()($child);
		if (is_a($child,ConditionChain::class))
			$sql = "($sql)";
		return $sql;
	}
}