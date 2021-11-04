<?php

namespace Drakuno\SqlTemplate;

use TypeError;

use Drakuno\SqlTemplate\Tools as T;

class ConditionChain implements TemplateInterface
{
	use NaturalAccessorsTrait;

	const TYPE_AND = 0;
	const TYPE_OR  = 1;

	private $conditions;

	public function __construct(
		array $conditions,
		int $type=self::TYPE_AND
	)
	{
		$this->setConditions($conditions);
		$this->setType($type);
	}

	public function getChildren():array{ return $this->getConditions(); }

	public function getConditions():array{ return $this->conditions; }
	public function setConditions(array $conditions)
	{
		if (!T\array_type_check($conditions,TemplateInterface::class))
			throw new TypeError(sprintf("Array elements must implement %s",TemplateInterface::class));
		$this->conditions = $conditions;
	}

	public function getType():int{ return $this->type; }
	public function setType(int $type)
	{
		if ($type>self::TYPE_OR||$type<0)
			throw new TypeError;
		$this->type = $type;
	}

	public function childAdd(TemplateInterface $child)
	{
		$this->conditions[] = $child;
	}
}