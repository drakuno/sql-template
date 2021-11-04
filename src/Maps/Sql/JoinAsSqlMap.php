<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Join;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class JoinAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const KEYWORDS	   = ["INNER","LEFT","RIGHT","OUTER","CROSS"];
	const TARGET_CLASS = Join::class;

	public function __invoke(TemplateInterface $expr):string
	{
		$partner   = $this->getPartner();
		$condition = $expr->getCondition();
		$on_clause = empty($condition)
					   ?""
					   :sprintf(" ON %s",$partner($condition));

		return sprintf("%s JOIN %s%s",
			self::KEYWORDS[$expr->getType()],
			$partner($expr->getTarget()),
			$on_clause
		);
	}
}