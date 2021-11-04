<?php

use PHPUnit\Framework\TestCase;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Maps\{
  Sql\SqlMap,
  Placeholders\PlaceholdersMap,
};

class SqlMapTest extends TestCase
{
  public function testSelectMap():void
  {
    $select = new Sql\Select(
      [
        new Sql\Value("meow"),
        new Sql\QualifiedName(new Sql\Name("table"),"column"),
        new Sql\Alias(new Sql\Name("columntwo"),new Sql\Name("two")),
      ],
      [
        'from'=>new Sql\Subject(
          new Sql\Name("table"),
          [new Sql\Join(new Sql\Name("table2"),0,new Sql\Comparison(new Sql\QualifiedName(new Sql\Name("table"),"id"),new Sql\QualifiedName(new Sql\Name("table2"),"table_id")))]
        )
      ]
    );

    $compiler = SqlMap::make();
    $this->assertEquals(
      $compiler($select),
      'SELECT \'meow\', "table"."column", "columntwo" "two" FROM "table" INNER JOIN "table2" ON "table"."id"="table2"."table_id"'
    );
  }

  public function testInsertMap():void
  {
    $insert = new Sql\Insert(
      new Sql\Name("table"),
      new Sql\InsertValues([
        new Sql\Series([new Sql\Value(1),new Sql\Value("one")]),
        new Sql\Series([new Sql\Value(2),new Sql\Value("two")]),
      ]),
      ['columns'=>[new Sql\Name("colone"),new Sql\Name("coltwo")]]
    );

    $compiler = SqlMap::make();
    $this->assertEquals(
      $compiler($insert),
      'INSERT INTO "table"("colone","coltwo") VALUES (1,\'one\'),(2,\'two\')'
    );
  }

  public function testUpdateMap():void
  {
    $update = new Sql\Update(
      new Sql\Name("table"),
      [
        new Sql\Assignment(new Sql\Name("colone"),new Sql\Value(1)),
        new Sql\Assignment(
          new Sql\Series([new Sql\Name("coltwo"),new Sql\Name("colthree")]),
          new Sql\Series([new Sql\Value("two"),new Sql\Value("three")])
        ),
        new Sql\Assignment(
          new Sql\Name("colfour"),
          new Sql\Select([new Sql\Value('rawr')])
        )
      ],
      [
        'where'=>new Sql\ConditionChain(
          [
            new Sql\Comparison(new Sql\Name("id"),new Sql\Value(5),Sql\Comparison::OPERATOR_GT),
            new Sql\Name("updatable"),
          ]
        )
      ]
    );

    $compiler = SqlMap::make();
    $this->assertEquals(
      $compiler($update),
      'UPDATE "table" SET "colone"=1,("coltwo","colthree")=(\'two\',\'three\'),"colfour"=(SELECT \'rawr\') WHERE "id">5 AND "updatable"'
    );
  }

  public function testDeleteMap():void
  {
    $delete = new Sql\Delete(
      new Sql\Name("table"),
      [
        'where'=>new Sql\Comparison(new Sql\Name("id"),new Sql\Value(1))
      ]
    );

    $compiler = SqlMap::make();
    $this->assertEquals(
      $compiler($delete),
      'DELETE FROM "table" WHERE "id"=1'
    );
  }

  public function testRawMap():void
  {
    $template = new Sql\Raw(
      "{field1} * !field2",
      [
        '{field1}'=>new Sql\Name("unit_price"),
        '!field2'=>new Sql\Name("qty"),
      ]
    );

    $compiler = SqlMap::make();
    $this->assertEquals(
      $compiler($template),
      '"unit_price" * "qty"'
    );

    $template = new Sql\Raw(
      "{0} + {1}",
      [
        '{0}'=>new Sql\Name("unit_price"),
        '{1}'=>new Sql\Name("tax"),
      ]
    );
    $this->assertEquals(
      $compiler($template),
      '"unit_price" + "tax"'
    );

    $template = new Sql\Raw(
      "(field1) * field2",
      [
        'field1'=>$template,
        'field2'=>new Sql\Name("qty"),
      ]
    );
    $this->assertEquals(
      $compiler($template),
      '("unit_price" + "tax") * "qty"'
    );

    $template = new Sql\Raw(
      'SELECT * FROM "table" WHERE',
      ['WHERE'=>""]
    );
    $this->assertEquals(
      $compiler($template),
      'SELECT * FROM "table" '
    );
  }
}