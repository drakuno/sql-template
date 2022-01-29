<?php

use PHPUnit\Framework\TestCase;

use Drakuno\SqlTemplate\Maps\PlaceholderFromValue as Map;
use Drakuno\SqlTemplate\Placeholder;

class PlaceholderFromValueMapTest extends TestCase
{
	public function testProducesPlaceholders():void
	{
		$map = new Map;
		$this->assertInstanceOf(Placeholder::class,$map("meow"));
		$this->assertInstanceOf(Placeholder::class,$map(5));
	}

	public function testCustomLabelPrefix():void
	{
		$map = new Map(label_prefix:":meow");
		foreach ([$map(1),$map(true),$map("tri")] as $result)
			$this->assertStringStartsWith(":meow",$result->label);
	}

	public function testLabelCounterIncrements():void
	{
		$map = new Map;
		$this->assertStringEndsWith("1",$map("miau")->label);
		$this->assertStringEndsWith("2",$map("miau")->label);
	}

	public function testCustomLabelCounter():void
	{
		$map = new Map(label_counter:10);
		$this->assertStringEndsWith("10",$map("asdfasdf")->label);
	}
}

