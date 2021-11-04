<?php

use PHPUnit\Framework\TestCase;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Maps\{
  Sql\SqlMap,
  Placeholders\PlaceholdersMap,
};

class RawTemplateTest extends TestCase
{
  public function testGetChildrenOnlyReturnsTemplates():void
  {
    $template = new Sql\Raw("{0} {1} {2}",[
      '{0}'=>new Sql\Name("meow"),
      '{1}'=>"STRING REPLACEMENT",
      '{2}'=>new Sql\Raw("RAW REPLACEMENT"),
    ]);

    $children = $template->getChildren();
    $this->assertContainsOnlyInstancesOf(
      Sql\TemplateInterface::class,
      $children
    );
  }

  public function testReplacementsOnlyAllowStringKeys():void
  {
    $this->expectException(TypeError::class);
    new Sql\Raw("0",[new Sql\Name("bop")]);
  }
}