<?php

namespace Drakuno\SqlTemplate;

use TypeError;

use Drakuno\SqlTemplate\Tools as T;

class Update implements TemplateInterface
{
  use NaturalAccessorsTrait;

  private $assignments;
  private $table_name;
  private $where = null;

  public function __construct(
    Name $table_name,
    array $assignments,
    array $options=array()
  )
  {
    $this->setTableName($table_name);
    $this->setAssignments($assignments);
    T\object_properties_assignment($this,$options);
  }

  public function getChildren():array
  {
    return [
      $this->getTableName(),
      ...$this->getAssignments(),
      $this->getWhere()
    ];
  }

  public function getAssignments():array{ return $this->assignments; }
  public function setAssignments(array $assignments)
  {
    if (!T\array_type_check($assignments,Assignment::class))
      throw new TypeError(sprintf("Array elements must be of type %s",Assignment::class));
    $this->assignments = $assignments;
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