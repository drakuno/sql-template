<?php

namespace Drakuno\SqlTemplate;

use Drakuno\SqlTemplate\Tools as T;

class Series implements TemplateInterface
{
  public function __construct(array $items)
  {
    $this->setItems($items);
  }

  public function getChildren():array{ return $this->getItems(); }

  public function getItems():array{ return $this->items; }
  public function setItems(array $items)
  {
    if (!T\array_type_check($items,TemplateInterface::class))
      throw new TypeError(sprintf("Array elements must be of type %s",TemplateInterface::class));
    $this->items = $items;
  }
}