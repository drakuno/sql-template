<?php

namespace Drakuno\SqlTemplate;

class Placeholder implements TemplateInterface
{
	use NaturalAccessorsTrait,NoChildrenTrait;

	private $label;
	private $value;

	public function __construct($value,string $label="?")
	{
		$this->setValue($value);
		$this->setLabel($label);
	}

	static public function arrayMake(array $values):array
	{
		return array_map([self::class,"map"],$values);
	}

	static public function labeledArrayMake(
		array $values,
		string $prefix,
		int $offset=0
	):array
	{
		$result = array();
		foreach ($values as $value)
			$result[] = new self(
				$value,
				sprintf("%s%d",$prefix,$offset++)
			);
		return $result;
	}

	static public function map($value):Placeholder
	{
		return new Placeholder($value);
	}

	public function getLabel():string{ return $this->label; }
	public function setLabel(string $label)
	{
		$this->label = $label;
	}

	public function getValue(){ return $this->value; }
	public function setValue($value){ $this->value=$value; }
}