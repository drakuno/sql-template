<?php

namespace Drakuno\SqlTemplate;

use Drakuno\SqlTemplate\Tools as T;

class InsertValues implements TemplateInterface
{
  private $rows;

  public function __construct(array $rows=array())
  {
    $this->setRows($rows);
  }

  public function getChildren():array
  {
    return $this->getRows();
  }

  public function getRows():array{ return $this->rows; }
  public function setRows(array $rows)
  {
    if (!T\array_type_check($rows,Series::class))
      throw new TypeError(sprintf("Array elements must be of type %s",Series::class));
    $this->rows = $rows;
  }
}