<?php

namespace Drakuno\SqlTemplate;

class QualifiedName extends Name
{
	private $qualifier;

	public function __construct(Name $qualifier,string $value)
	{
		parent::__construct($value);
		$this->setQualifier($qualifier);
	}

	public function getChildren():array
	{
		return [$this->getQualifier()];
	}

	public function getQualifier():Name{ return $this->qualifier; }
	public function setQualifier(Name $qualifier)
	{
		$this->qualifier = $qualifier;
	}
}