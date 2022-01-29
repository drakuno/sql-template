<?php

use PHPUnit\Framework\TestCase;

use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\Raw;

use Drakuno\SqlTemplate\Maps\FromNameString as Map;

class FromNameStringMapTest extends TestCase
{
	public function testSimpleName():void
	{
		$map = new Map;
		$this->assertInstanceOf(Name::class,$map("meow"));
		$this->assertEquals("meow",$map("meow")->value);
	}

	public function testQualifiedName():void
	{
		$map    = new Map;
		$result = $map("cat.meow"); # cus each cat has its own meow
		$this->assertInstanceOf(Raw::class,$result);

		$replacement_keys = array_keys($result->replacements);
		$this->assertEquals(
			sprintf("%s.%s",...$replacement_keys),
			$result->sql
		);

		$this->assertEquals("cat",$result->replacements[$replacement_keys[0]]->value);
		$this->assertEquals("meow",$result->replacements[$replacement_keys[1]]->value);
	}

	public function testHyperQualifiedName():void
	{
		$map    = new Map;
		$result = $map("animals.cat.meow");
		$this->assertInstanceOf(Raw::class,$result);

		$replacement_keys = array_keys($result->replacements);
		$this->assertEquals(
			sprintf("%s.%s",...$replacement_keys),
			$result->sql
		);

		$nested_template  = $result->replacements[$replacement_keys[0]];
		$this->assertInstanceOf(Raw::class,$nested_template);
		$nested_replacement_keys = array_keys($nested_template->replacements);
		$this->assertEquals(
			sprintf("%s.%s",...$nested_replacement_keys),
			$nested_template->sql,
		);

		$this->assertEquals("animals",$nested_template->replacements[$nested_replacement_keys[0]]->value);
		$this->assertEquals("cat",$nested_template->replacements[$nested_replacement_keys[1]]->value);
		$this->assertEquals("meow",$result->replacements[$replacement_keys[1]]->value);
	}

	public function testAsteriskCases():void
	{
		$map    = new Map;
		$result = $map("*");
		$this->assertInstanceOf(Raw::class,$result);
		$this->assertEquals("*",$result->sql);

		$result = $map("cat.*");
		$this->assertInstanceOf(Raw::class,$result);
		list($replacement_q,$replacement_l) = array_values($result->replacements);

		$this->assertInstanceOf(Name::class,$replacement_q);
		$this->assertEquals("cat",$replacement_q->value);
		$this->assertInstanceOf(Raw::class,$replacement_l);
		$this->assertEquals("*",$replacement_l->sql);
	}

	public function testReferences():void
	{
		$map             = new Map;
		$map->references = $references = [
			'srltn'=>$map("some_really_long_table_name"),
			'id'=>$map("UGLY_ID"),
		];;

		$result = $map("srltn.id");
		$this->assertInstanceOf(Raw::class,$result);
		list($replacement_q,$replacement_l) = array_values($result->replacements);

		$this->assertEquals($references['srltn'],$replacement_q);
		$this->assertEquals($replacement_q->value,"some_really_long_table_name");
		$this->assertEquals($references['id'],$replacement_l);
		$this->assertEquals($replacement_l->value,"UGLY_ID");

		$references['srltn']->value = "srltn";
		$this->assertEquals($replacement_q->value,"srltn");
	}
}

