<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate as Sql;
use Drakuno\SqlTemplate\Processors\{
  ClassBasedHandlesTestTrait,
  PartneredProcessorInterface,
  SimplePartnerTrait,
};

class UpdateAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Sql\Update::class;

  public function __invoke(Sql\TemplateInterface $update):string
  {
    $partner = $this->getPartner();

    $table_sql = $partner($update->getTableName());

    $assignments_sql = implode(",",array_map($partner,$update->getAssignments()));

    $sql = "UPDATE {$table_sql} SET {$assignments_sql} ";

    $where = $update->getWhere();
    if ($where)
      $sql .= "WHERE {$partner($where)}";

    return trim($sql);
  }
}