<?php

namespace Drakuno\SqlTemplate;

class Order implements TemplateInterface
{
	use NaturalAccessorsTrait;

	const TYPE_ASC	= 0;
	const TYPE_DESC = 1;

	private $nulls_first;
	private $target;
	private $type;

	public function __construct(
		TemplateInterface $target,
		int $type=0,
		?bool $nulls_first=null
	)
	{
		$this->setTarget($target);
		$this->setType($type);
		$this->setNullsFirst($nulls_first);
	}

	public function getChildren():array
	{
		return [$this->getTarget()];
	}

	public function getNullsFirst():?bool{ return $this->nulls_first; }
	public function setNullsFirst(?bool $nulls_first)
	{
		$this->nulls_first = $nulls_first;
	}

	public function getTarget():TemplateInterface{ return $this->target; }
	public function setTarget(TemplateInterface $target)
	{
		$this->target = $target;
	}

	public function getType():int{ return $this->type; }
	public function setType(int $type)
	{
		if ($type>self::TYPE_DESC)
			throw new TypeError;
		$this->type = $type;
	}
}