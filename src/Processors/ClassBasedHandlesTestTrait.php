<?php

namespace Drakuno\SqlTemplate\Processors;

use Exception;

use Drakuno\SqlTemplate\TemplateInterface;

trait ClassBasedHandlesTestTrait
{
	public function handlesTest(TemplateInterface $expr):bool
	{
		if (empty(static::TARGET_CLASS))
			throw new Exception("Target class unspecified.");

		// does not use is_a() to avoid ancestor handling
		return get_class($expr)==(static::TARGET_CLASS);
	}
}