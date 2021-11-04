<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\{
  ClassBasedHandlesTestTrait,
  PartneredProcessorInterface,
  SimplePartnerTrait,
};

class InsertAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\Insert::class;

  public function __invoke(Sql\TemplateInterface $insert):string
  {
    $partner = $this->getPartner();

    $table_sql  = $partner($insert->getTableName());
    $sql        = "INSERT INTO {$table_sql}";

    $columns = $insert->getColumns();
    if (!empty($columns))
      $sql .= sprintf("(%s)",
        implode(",",array_map($partner,$columns))
      );

    $values_sql =  $partner($insert->getValues());
    $sql        .= " {$values_sql}";
    return $sql;
  }
}