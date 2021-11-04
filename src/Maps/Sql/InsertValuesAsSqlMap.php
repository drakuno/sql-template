<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\{
  ClassBasedHandlesTestTrait,
  PartneredProcessorInterface,
  SimplePartnerTrait,
};

class InsertValuesAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\InsertValues::class;

  public function __invoke(Sql\TemplateInterface $insert_values):string
  {
    $partner = $this->getPartner();

    $rows = $insert_values->getRows();
    if (empty($rows))
      return "DEFAULT VALUES";
    else
      return sprintf("VALUES (%s)",
        implode("),(",array_map($partner,$rows))
      );
  }
}