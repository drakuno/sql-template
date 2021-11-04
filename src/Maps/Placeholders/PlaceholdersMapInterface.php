<?php

namespace Drakuno\SqlTemplate\Maps\Placeholders;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Processors\ProcessorInterface;

/**
 * Maps an token to an array of placeholder tokens
 * 
 * The resulting placeholder tokens are those that exist
 * within the original token (including itself if it is a
 * placeholder), and are returned in the order they appear in
 * sql code.
 */
interface PlaceholdersMapInterface extends ProcessorInterface
{
	/**
	 * Maps the token to an array of placeholder tokens
	 */
	public function __invoke(TemplateInterface $token):array;
}