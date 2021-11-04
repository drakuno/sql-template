<?php

namespace Drakuno\SqlTemplate;

trait NoChildrenTrait
{
	public function getChildren():array{ return array(); }
}