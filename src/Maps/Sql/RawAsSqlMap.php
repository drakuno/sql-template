<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Raw;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class RawAsSqlMap implements PartneredProcessorInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const TARGET_CLASS = Raw::class;

	public function __invoke(TemplateInterface $raw):string
	{
		$partner = $this->getPartner();
		$sql		 = $raw->getSql();
		foreach ($raw->getReplacements() as $token=>$replacement)
			$sql = str_replace(
				$token,
				is_a($replacement,TemplateInterface::class)
					?$partner($replacement)
					:$replacement,
				$sql
			);
		return $sql;
	}
}