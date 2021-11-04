<?php

namespace Drakuno\SqlTemplate;

use Drakuno\SqlTemplate\Tools as T;

class ArrayComparison implements TemplateInterface
{
	use NaturalAccessorsTrait;

	const TYPE_IN	 = 0;
	const TYPE_NOTIN = 1;
	const TYPE_ANY	 = 2;
	const TYPE_SOME	 = 3;
	const TYPE_ALL	 = 4;

	private $array;
	private $operator;
	private $target;
	private $type;

	public function __construct(
		TemplateInterface $expr,
		array $arr,
		int $type=0,
		TemplateInterface $operator=null
	)
	{
		$this->setTarget($expr);
		$this->setArray($arr);
		$this->setType($type);
		$this->setOperator($operator);
	}

	public function getArray():array{ return $this->array; }
	public function setArray(array $array)
	{
		if (!T\array_type_check($array,TemplateInterface::class))
			throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
		$this->array = $array;
	}

	public function getChildren():array
	{
		return array_merge(
			array_filter(
			[
				$this->getTarget(),
				$this->getOperator(),
			]),
			$this->getArray()
		);
	}

	public function getOperator():?TemplateInterface{ return $this->operator; }
	public function setOperator(?TemplateInterface $operator)
	{
		$this->operator = $operator;
	}

	public function getTarget():TemplateInterface{ return $this->target; }
	public function setTarget(TemplateInterface $target)
	{
		$this->target = $target;
	}

	public function getType():int{ return $this->type; }
	public function setType(int $type)
	{
		if ($type<0||$type>self::TYPE_ALL)
			throw new TypeError;
		$this->type = $type;
	}
}