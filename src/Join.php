<?php

namespace Drakuno\SqlTemplate;

class Join implements TemplateInterface
{
	use NaturalAccessorsTrait;

	const TYPE_INNER = 0;
	const TYPE_LEFT  = 1;
	const TYPE_RIGHT = 2;
	const TYPE_OUTER = 3;
	const TYPE_CROSS = 4;

	private $condition;
	private $target;
	private $type;

	public function __construct(
		TemplateInterface $target,
		int $type=0,
		?TemplateInterface $condition=null
	)
	{
		$this->setTarget($target);
		$this->setType($type);
		$this->setCondition($condition);
	}

	public function getChildren():array
	{
		return array_filter([$this->getTarget(),$this->getCondition()]);
	}

	public function getCondition():?TemplateInterface{ return $this->condition; }
	public function setCondition(?TemplateInterface $condition)
	{
		$this->condition = $condition;
	}

	public function getTarget():TemplateInterface{ return $this->target; }
	public function setTarget(TemplateInterface $target)
	{
		$this->target = $target;
	}

	public function getType():int{ return $this->type; }
	public function setType(int $type)
	{
		if ($type>self::TYPE_CROSS)
			throw new TypeError;
		$this->type = $type;
	}
}