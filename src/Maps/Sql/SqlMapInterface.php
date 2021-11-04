<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Processors\ProcessorInterface;

/**
 * Describes a token map that outputs SQL code (compiler)
 */
interface SqlMapInterface extends ProcessorInterface
{
	/**
	 * Maps the token to sql code
	 */
	public function __invoke(TemplateInterface $expr):string;
}