<?php

namespace Drakuno\SqlTemplate;

class NullTest implements TemplateInterface
{
	use NaturalAccessorsTrait;

	private $target;
	private $negated;

	public function __construct(TemplateInterface $target,bool $negated=false)
	{
		$this->setTarget($target);
		$this->setNegated($negated);
	}

	public function getChildren():array{ return [$this->getTarget()]; }

	public function getNegated():bool{ return $this->negated; }
	public function setNegated(bool $negated)
	{
		$this->negated = $negated;
	}

	public function getTarget():TemplateInterface{ return $this->target; }
	public function setTarget(TemplateInterface $target)
	{
		$this->target = $target;
	}
}