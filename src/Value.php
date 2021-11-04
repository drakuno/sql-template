<?php

namespace Drakuno\SqlTemplate;

class Value implements TemplateInterface
{
	use NoChildrenTrait;

	private $_;

	public function __construct($_)
	{
		$this->set($_);
	}

	static public function map($value):Value
	{
		return new static($value);
	}

	public function get(){ return $this->_; }
	public function set($_)
	{
		$this->_ = $_;
	}
}