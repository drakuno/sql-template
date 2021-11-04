<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class AssignmentAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\Assignment::class;

  public function __invoke(Sql\TemplateInterface $assignment):string
  {
    $partner = $this->getPartner();

    $left  = $assignment->getLeftTemplate();
    $right = $assignment->getRightTemplate();

    $left_sql  = $partner($assignment->getLeftTemplate());
    $right_sql = $partner($assignment->getRightTemplate());

    if (is_a($left,Sql\Series::class))
      $left_sql = "({$left_sql})";
    if (is_a($right,Sql\Series::class)||is_a($right,Sql\Select::class))
      $right_sql = "({$right_sql})";

    return "{$left_sql}={$right_sql}";
  }
}