<?php

namespace Drakuno\SqlTemplate;

use TypeError;

use Drakuno\SqlTemplate\Tools as T;

class Subject implements TemplateInterface
{
	use NaturalAccessorsTrait;

	private $base;
	private $joins;

	public function __construct(TemplateInterface $base,array $joins=array())
	{
		$this->setBase($base);
		$this->setJoins($joins);
	}

	public function getBase():TemplateInterface{ return $this->base; }
	public function setBase(TemplateInterface $base)
	{
		$this->base = $base;
	}

	public function getChildren():array
	{
		return array_merge(
			[$this->getBase()],
			$this->getJoins()
		);
	}

	public function getJoins():array{ return $this->joins; }
	public function setJoins(array $joins)
	{
		if (!T\array_type_check($joins,Join::class))
			throw new TypeError(sprintf("Array elements must be of type %s",Join::class));
		$this->joins = $joins;
	}

	public function joinAdd(Join $join)
	{
		$this->joins[] = $join;
	}

	public function joinsMerge(array $joins)
	{
		if (!T\array_type_check($joins,Join::class))
			throw new TypeError(sprintf("Array elements must be of type %s",Join::class));
		$this->joins = array_merge($this->joins,$joins);
	}
}