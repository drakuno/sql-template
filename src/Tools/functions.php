<?php

namespace Drakuno\SqlTemplate\Tools;

use ArrayIterator;

function array_type_check(array $array,string $type):bool
{
  $iterator = new ArrayIterator($array);
  $result   = true;
  while ($result&&$iterator->valid())
    if (is_a($iterator->current(),$type))
      $iterator->next();
    else
      $result = false;
  return $result;
}

function is_array_of_callables(array $array):bool
{
  $iterator = new ArrayIterator($array);
  $result   = true;
  while ($result&&$iterator->valid())
    if (is_callable($iterator->current()))
      $iterator->next();
    else
      $result = false;
  return $result;
}

function object_properties_assignment($obj,array $assignments)
{
  foreach ($assignments as $prop_name=>$value)
    $obj->$prop_name = $value;
}