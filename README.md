# SQL Template v0.0.1

WIP toolset for dynamic *query building* (producing SQL output).

This project does **NOT**:
- Manage object relationships (not an ORM).
- Handle database connections.
- Handle query fetching.
- Validate syntax of generated SQL code (it is mostly up to you to assemble valid code).
- Provide an alternative to learning SQL.

This project aims to:
- Simplify dynamic writing of SQL code.
- Provide independence of SQL engine when applicable.

## Tokens

At its core, the toolset is a collection of SQL *template* classes that can be instantiated to represent a piece of SQL code.

Many templates are composed by other templates, and thus the basic interface defines a `getChildren()` method.

Ideally, the library will also provide quicker ways of instantiating templates.

### Raw

A simple template for raw SQL.

Paired with a compiler, it provides the possibility of freely writing templates while keeping track of nested templates at will.

Code Example
```php
use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Maps\Sql\SqlMap;

$template = new Sql\Select(
[
  new Sql\Name("col"),
  new Sql\Raw(
    'CASE "col" WHEN {0} THEN \'meow\' ELSE ({whatever}) {end}',
    [
      '{0}'=>new Sql\Placeholder("someval",":val"),
      '{whatever}'=>new Sql\Select([new Sql\Value('bork')]),
      '{end}'=>"END"
    ]
  )
],
[
  'from'=>new Sql\Name("table"),
]);

$compiler = SqlMap::make();
echo $compiler($template);
```

Output
```sql
SELECT "col", CASE "col" WHEN :val THEN 'meow' ELSE (SELECT 'bork') END FROM "table"
```

Ideally, all use cases would be covered by predefined templates in the future. Realistically, the raw template covers edge cases without sacrificing functionality.

## Maps

Callables that take a single input to produce an output.

All maps described take templates as input.

### Sql (Compilers)

In other projects, maps that take the equivalent of `TemplateInterface` to produce SQL output are commonly known as *compilers*.

Compilers included are currently defined in a per-template basis, and tuned for PostgreSQL output.

The main SQL compiler is the class defined at `Drakuno\SqlTemplate\Maps\Sql\SqlMap.php`. It can be instantiated through `SqlMap::make()` to automatically include all the default compilers.

Code
```php
use Drakuno\SqlTemplate\{Name,QualifiedName};
use Drakuno\SqlTemplate\Maps\Sql\SqlMap;

$template = new QualifiedName(new Name("table"),"id");

$compiler = SqlMap::make();
echo $compiler($template);
```

Output
```sql
"table"."id"
```

### Placeholders

These maps serve as a utility for prepared statements.

The included placeholders map is `Drakuno\SqlTemplate\Maps\Placeholders\PlaceholdersMap`. It can be instantiated through its default constructor (`new PlaceholdersMap`) or `PlaceholdersMap::make()` for the sake of consistency. It relies on the correct order of items returned by each template's `getChildren()`.

Example Code
```php
use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Maps\Placeholders\PlaceholdersMap;
use Drakuno\SqlTemplate\Maps\Placeholders\SqlMap;

$template = new Sql\Delete(
  new Sql\Name("table"),
  [
    'where'=>new Sql\ConditionChain(
    [
      new Sql\Comparison(new Sql\Name("field"),new Sql\Placeholder("value1")),
      new Sql\Raw(
        '(? AND (? OR ?))',
        [
          new Sql\Placeholder(true),
          new Sql\Placeholder(false),
          new Sql\Placeholder(true),
        ]
      ),
    ])
  ]
);

$compiler         = SqlMap::make();
$placeholders_map = PlaceholdersMap::make();

echo $compiler($template);
print_r($placeholders_map($template));
```

Output
```sql
DELETE FROM "table" WHERE "field"=? AND (? AND (? OR ?))
(
  [0] => Drakuno\SqlTemplate\Placeholder Object
    (
      [label:Drakuno\SqlTemplate\Placeholder:private] => ?
      [value:Drakuno\SqlTemplate\Placeholder:private] => value1
    )

  [1] => Drakuno\SqlTemplate\Placeholder Object
    (
      [label:Drakuno\SqlTemplate\Placeholder:private] => ?
      [value:Drakuno\SqlTemplate\Placeholder:private] => 1
    )

  [2] => Drakuno\SqlTemplate\Placeholder Object
    (
      [label:Drakuno\SqlTemplate\Placeholder:private] => ?
      [value:Drakuno\SqlTemplate\Placeholder:private] => 
    )

  [3] => Drakuno\SqlTemplate\Placeholder Object
    (
      [label:Drakuno\SqlTemplate\Placeholder:private] => ?
      [value:Drakuno\SqlTemplate\Placeholder:private] => 1
    )
)
```