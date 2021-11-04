<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Exception;

use Drakuno\SqlTemplate\ArrayComparison;
use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\Placeholder;
use Drakuno\SqlTemplate\Value;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class ArrayComparisonAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const KEYWORDS     = ["IN","NOT IN","ANY","SOME","ALL"];
  const TARGET_CLASS = ArrayComparison::class;

  public function __invoke(TemplateInterface $array_comparison):string
  {
    $partner  = $this->getPartner();
    $type     = $array_comparison->getType();
    $operator = $array_comparison->getOperator();

    if ($type>=2&&empty($operator))
      throw new Exception("Template type '$type' requires operator");

    return sprintf("%s %s (%s)",
      $partner($array_comparison->getTarget()),
      $type<2
        ?self::KEYWORDS[$type]
        :sprintf("%s %s",
          $partner($array_comparison->getOperator()),
          self::KEYWORDS[$type]
        ),
      implode(",",array_map(
        [$this,"arrayItemMap"],
        $array_comparison->getArray()
      ))
    );
  }

  public function arrayItemMap(TemplateInterface $item):string
  {
    $sql = $this->getPartner()($item);
    if (!is_a($item,Name::class)&&!is_a($item,Placeholder::class)&&!is_a($item,Value::class))
      $sql = "($sql)";
    return $sql;
  }
}