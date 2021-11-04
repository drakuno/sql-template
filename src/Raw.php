<?php

namespace Drakuno\SqlTemplate;

use TypeError;

use Drakuno\SqlTemplate\Tools as T;

class Raw implements TemplateInterface
{
	use NaturalAccessorsTrait;

	private $replacements;
	private $sql;

	public function __construct(string $sql,array $replacements=array())
	{
		$this->setSql($sql);
		$this->setReplacements($replacements);
	}

	public function getChildren():array
	{
		return array_filter(
			$this->getReplacements(),
			function($rep){ return is_a($rep,TokenInterface::class); }
		);
	}

	public function getReplacements():array{ return $this->replacements; }
	public function setReplacements(array $replacements)
	{
		if (count(array_filter($replacements,"is_string",ARRAY_FILTER_USE_KEY))!=count($replacements))
			throw new TypeError("Replacements array must only contain string keys");
		$this->replacements = $replacements;
	}

	public function getSql():string{ return $this->sql; }
	public function setSql(string $sql)
	{
		$this->sql = $sql;
	}
}
