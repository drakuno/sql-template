<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\QualifiedName;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class QualifiedNameAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const TARGET_CLASS = QualifiedName::class;

	public function __invoke(TemplateInterface $expr):string
	{
		$partner	  = $this->getPartner();
		$expr_as_name = new Name($expr->getValue());
		return sprintf('%s.%s',
			$partner($expr->getQualifier()),
			$partner($expr_as_name)
		);
	}
}