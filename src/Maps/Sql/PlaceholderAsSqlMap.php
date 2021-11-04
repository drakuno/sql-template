<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Placeholder;
use Drakuno\SqlTemplate\Value;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class PlaceholderAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const TARGET_CLASS = Placeholder::class;

	private $prepared_stmt_support;

	public function __construct(bool $prepared_stmt_support=true)
	{
		$this->setPreparedStmtSupport($prepared_stmt_support);
	}

	public function __invoke(TemplateInterface $expr):string
	{
		if ($this->getPreparedStmtSupport())
			return $expr->getLabel();
		else
			return $this->getPartner()(new Value($expr->getValue()));
	}

	public function getPreparedStmtSupport():bool{ return $this->prepared_stmt_support; }
	public function setPreparedStmtSupport(bool $prepared_stmt_support)
	{
		$this->prepared_stmt_support = $prepared_stmt_support;
	}
}