<?php

namespace Drakuno\SqlTemplate\Maps;

use TypeError;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\NaturalAccessorsTrait;
use Drakuno\SqlTemplate\Tools as T;

class FromNameString
{
	use NaturalAccessorsTrait;

	private array $references;

	public function __construct(array $references=array())
	{
		$this->setReferences($references);
	}

	public function __invoke(string $name):Sql\TemplateInterface
	{
		if (strlen($name)>=3&&(($last_period_index=strrpos($name,".",-2))!==FALSE)) {
			$qualifier_str = substr($name,0,$last_period_index);
			$local_str     = substr($name,$last_period_index+1);

			$qualifier = $this($qualifier_str);
		} else {
			$qualifier = null;
			$local_str = $name;
		}

		$local = $local_str=="*"
			?new Sql\Raw("*")
			:$this->nameAsReference($local_str)
		;

		return is_null($qualifier)
			?$local
			:new Sql\Raw('{Q}.{N}',[
				'{Q}'=>$qualifier,
				'{N}'=>$local,
			]);
	}

	public function getReferences():array{ return $this->references; }
	public function setReferences(array $references):void
	{
		if (!T\array_type_check($references,Sql\TemplateInterface::class))
			throw new TypeError(sprintf("All items must implement %s",Sql\TemplateInterface::class));
		$this->references = $references;
	}

	public function nameAsReference(string $name):Sql\TemplateInterface
	{
		return $this->references[$name]
			= $this->references[$name]
			??new Sql\Name($name)
		;
	}
}

