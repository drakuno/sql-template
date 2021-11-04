<?php

namespace Drakuno\SqlTemplate;

use Drakuno\SqlTemplate\Tools as T;

class Insert implements TemplateInterface
{
  use NaturalAccessorsTrait;

  private $table_name;
  private $values;
  private $columns = array();

  public function __construct(
    Name $table_name,
    TemplateInterface $values,
    array $options=array()
  )
  {
    $this->setTableName($table_name);
    $this->setValues($values);
    T\object_properties_assignment($this,$options);
  }

  public function getChildren():array
  {
    return [
      $this->getTableName(),
      ...$this->getColumns(),
      $this->getValues(),
    ];
  }

  public function getColumns():array{ return $this->columns; }
  public function setColumns(array $columns)
  {
    if (!T\array_type_check($columns,Name::class))
      throw new TypeError(sprintf("Array elements must be of type %s",Name::class));
    $this->columns = $columns;
  }

  public function getTableName():Name{ return $this->table_name; }
  public function setTableName(Name $table_name)
  {
    $this->table_name = $table_name;
  }

  public function getValues():TemplateInterface{ return $this->values; }
  public function setValues(TemplateInterface $values)
  {
    $this->values = $values;
  }
}