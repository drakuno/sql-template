<?php

namespace Drakuno\SqlTemplate;

use Drakuno\SqlTemplate\Tools as T;

class Delete implements TemplateInterface
{
  use NaturalAccessorsTrait;

  private $table_name;
  private $where = null;

  public function __construct(
    Name $table_name,
    array $options=array()
  )
  {
    $this->setTableName($table_name);
    T\object_properties_assignment($this,$options);
  }

  public function getChildren():array
  {
    return array_filter([
      $this->getTableName(),
      $this->getWhere(),
    ]);
  }

  public function getTableName():Name{ return $this->table_name; }
  public function setTableName(Name $table_name)
  {
    $this->table_name = $table_name;
  }

  public function getWhere():?TemplateInterface{ return $this->where; }
  public function setWhere(?TemplateInterface $where)
  {
    $this->where = $where;
  }
}