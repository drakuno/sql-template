<?php

namespace Drakuno\SqlTemplate\Processors;

use TypeError;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Tools as T;

class JointProcessor implements ProcessorInterface
{
	private $children;

	public function __construct(array $children)
	{
		$this->setChildren($children);
	}

	public function getChildren():array{ return $this->children; }
	public function setChildren(array $children)
	{
		if (!T\array_type_check($children,ProcessorInterface::class))
			throw new TypeError(sprintf("Array elements must implement interface %s",ProcessorInterface::class));
		if (!T\is_array_of_callables($children))
			throw new TypeError("Array elements must be callable");
		$this->children = $children;
	}

	public function childRegistration(ProcessorInterface $child)
	{
		$this->children[] = $child;
	}

	public function tokenAsChildMap(TemplateInterface $token):?ProcessorInterface
	{
		$children = $this->getChildren();
		$result	  = null;
		while (!$result&&$child=current($children))
			if ($child->handlesTest($token))
				$result = $child;
			else
				next($children);
		return $result;
	}

	public function handlesTest(TemplateInterface $token):bool
	{
		return boolval($this->tokenAsChildMap($token));
	}
}