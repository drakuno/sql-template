<?php

namespace Drakuno\SqlTemplate;

use Exception;

/**
 * Allows inaccessible property access through getters and setters
 * 
 * The static methods propertyAs{Getter|Setter}NameMap define the
 * respective accessor for a property name. When such an accessor
 * is inexistent, the trait attempts to fall back to default
 * behavior.
 */
trait NaturalAccessorsTrait
{
  static public function propertyAsGetterNameMap(string $prop_name):string
  {
    return sprintf("get%s",implode("",array_map("ucfirst",explode("_",$prop_name))));
  }

  static public function propertyAsSetterNameMap(string $prop_name):string
  {
    return sprintf("set%s",implode("",array_map("ucfirst",explode("_",$prop_name))));
  }

  public function __get($prop_name)
  {
    $getter = static::propertyAsGetterNameMap($prop_name);
    if (method_exists($this,$getter))
      return $this->$getter();
    else if (get_parent_class())
      return parent::__get($prop_name);
    else
      throw new Exception(
        sprintf("Undefined property: %s::\$%s",
          static::class,
          $prop_name
        )
      );
  }

  public function __set($prop_name,$value)
  {
    $setter = static::propertyAsSetterNameMap($prop_name);
    if (method_exists($this,$setter))
      return $this->$setter($value);
    else if (get_parent_class())
      return parent::__set($prop_name,$value);
    else
      $this->$prop_name = $value;
  }
}