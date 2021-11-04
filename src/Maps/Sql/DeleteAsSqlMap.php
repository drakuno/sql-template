<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\{
  ClassBasedHandlesTestTrait,
  PartneredProcessorInterface,
  SimplePartnerTrait,
};

class DeleteAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\Delete::class;

  public function __invoke(Sql\TemplateInterface $delete):string
  {
    $partner = $this->getPartner();

    $table_sql = $partner($delete->getTableName());

    $sql = "DELETE FROM {$table_sql}";

    if ($where=$delete->getWhere()) {
      $where_sql =  $partner($where);
      $sql       .= " WHERE {$where_sql}";
    }

    return $sql;
  }
}