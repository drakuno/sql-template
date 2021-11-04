<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\{
  ClassBasedHandlesTestTrait,
  PartneredProcessorInterface,
  SimplePartnerTrait,
};

class SeriesAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\Series::class;

  public function __invoke(Sql\TemplateInterface $list):string
  {
    $partner = $this->getPartner();
    return implode(",",array_map($partner,$list->getItems()));
  }
}