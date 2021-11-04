<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Exception;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Processors\JointProcessor;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;

class SqlMap extends JointProcessor implements SqlMapInterface
{
	private $options;

	public function __invoke(TemplateInterface $token):string
	{
		$map = $this->tokenAsChildMap($token);
		if ($map)
			return $map($token);
		else
			throw new Exception(sprintf("No map for %s",get_class($token)));
	}

	static public function make():SqlMap
	{
		$children = [
			new AliasAsSqlMap,
			new ArrayComparisonAsSqlMap,
			new AssignmentAsSqlMap,
			new ComparisonAsSqlMap,
			new ConditionChainAsSqlMap,
			new DeleteAsSqlMap,
			new InsertAsSqlMap,
			new InsertValuesAsSqlMap,
			new JoinAsSqlMap,
			new SeriesAsSqlMap,
			new NameAsSqlMap,
			new NullTestAsSqlMap,
			new OrderAsSqlMap,
			new PlaceholderAsSqlMap,
			new QualifiedNameAsSqlMap,
			new RawAsSqlMap,
			new SelectAsSqlMap,
			new SubjectAsSqlMap,
			new UpdateAsSqlMap,
			new ValueAsSqlMap
		];
		$map = new self($children);

		foreach ($children as $child)
			if (is_a($child,PartneredProcessorInterface::class))
				$child->setPartner($map);

		return $map;
	}
}