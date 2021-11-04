<?php

namespace Drakuno\SqlTemplate;

use Exception;
use TypeError;

use Drakuno\SqlTemplate\Tools as T;

class Select implements TemplateInterface
{
  use NaturalAccessorsTrait;

  private $columns;
  private $distinct = false;
  private $from     = null;
  private $group_by = array();
  private $having   = null;
  private $limit    = null;
  private $offset   = null;
  private $order_by = array();
  private $where    = null;

  public function __construct(
    array $columns,
    array $options=array()
  )
  {
    $this->setColumns($columns);
    T\object_properties_assignment($this,$options);
  }

  public function getChildren():array
  {
    $distinct = $this->getDistinct();
    return array_merge(
      is_array($distinct)?$distinct:array(),
      $this->getColumns(),
      array_filter([$this->getFrom(),$this->getWhere()]),
      $this->getGroupBy(),
      $this->getOrderBy(),
      array_filter(
      [
        $this->getHaving(),
        $this->getLimit(),
        $this->getOffset(),
      ])
    );
  }

  public function getColumns():array{ return $this->columns; }
  public function setColumns(array $columns)
  {
    if (!T\array_type_check($columns,TemplateInterface::class))
      throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
    $this->columns = $columns;
  }

  public function getDistinct(){ return $this->distinct; }
  public function setDistinct($distinct)
  {
    if (!is_bool($distinct)&&!is_array($distinct))
      throw new TypeError("Expecting bool or array");
    if (is_array($distinct)&&!T\array_type_check($distinct,TemplateInterface::class))
      throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
    $this->distinct = $distinct;
  }

  public function getGroupBy():array{ return $this->group_by; }
  public function setGroupBy(array $group_by)
  {
    if (!T\array_type_check($group_by,TemplateInterface::class))
      throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
    $this->group_by = $group_by;
  }

  public function getHaving():?TemplateInterface{ return $this->having; }
  public function setHaving(?TemplateInterface $having)
  {
    $this->having = $having;
  }

  public function getLimit():?TemplateInterface{ return $this->limit; }
  public function setLimit(?TemplateInterface $limit)
  {
    $this->limit = $limit;
  }

  public function getOffset():?TemplateInterface{ return $this->offset; }
  public function setOffset(?TemplateInterface $offset)
  {
    $this->offset = $offset;
  }

  public function getOrderBy():array{ return $this->order_by; }
  public function setOrderBy(array $order_by)
  {
    if (!T\array_type_check($order_by,TemplateInterface::class))
      throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
    $this->order_by = $order_by;
  }

  public function getFrom():?TemplateInterface{ return $this->from; }
  public function setFrom(?TemplateInterface $from)
  {
    $this->from = $from;
  }

  public function getWhere():?TemplateInterface{ return $this->where; }
  public function setWhere(?TemplateInterface $where)
  {
    $this->where = $where;
  }
}