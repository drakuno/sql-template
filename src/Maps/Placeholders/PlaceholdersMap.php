<?php

namespace Drakuno\SqlTemplate\Maps\Placeholders;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Placeholder;

/**
 * Basic token to placeholders map
 * 
 * Relies on the correct order of each token's children;
 * some SQL engines may require different orders, in which
 * case a different mapping method is necessary
 */
class PlaceholdersMap implements PlaceholdersMapInterface
{
	public function __invoke(TemplateInterface $token):array
	{
		if (is_a($token,Placeholder::class))
			return [$token];
		else
			return call_user_func_array(
				"array_merge",
				array_map($this,$token->getChildren())
			);
	}

	static public function make():PlaceholdersMap
	{
		return new static;
	}

	public function handlesTest(TemplateInterface $token):bool{ return true; }
}
