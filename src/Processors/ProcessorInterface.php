<?php

namespace Drakuno\SqlTemplate\Processors;

use Drakuno\SqlTemplate\TemplateInterface;

interface ProcessorInterface
{
	/**
	 * Indicates if the processor can handle the provided token
	 */
	public function handlesTest(TemplateInterface $expr):bool;
}