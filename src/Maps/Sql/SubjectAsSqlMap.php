<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Subject;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class SubjectAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const TARGET_CLASS = Subject::class;

	public function __invoke(TemplateInterface $expr):string
	{
		$partner = $this->getPartner();

		$sql = $partner($expr->getBase());

		$joins = $expr->getJoins();
		if (!empty($joins))
			$sql = sprintf("%s %s",
				$sql,
				implode(" ",array_map($partner,$joins))
			);

		return $sql;
	}
}