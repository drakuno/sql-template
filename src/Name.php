<?php

namespace Drakuno\SqlTemplate;

class Name implements TemplateInterface
{
	use NaturalAccessorsTrait,NoChildrenTrait;

	private $value;

	public function __construct(string $value)
	{
		$this->setValue($value);
	}

	public function getValue():string{ return $this->value; }
	public function setValue(string $value)
	{
		if (empty($value))
			throw new Exception("ValueError: Value cannot be empty.");
		$this->value = $value;
	}
}