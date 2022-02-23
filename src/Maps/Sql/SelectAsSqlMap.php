<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Select;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class SelectAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Select::class;

  public function __invoke(TemplateInterface $expr):string
  {
    $partner = $this->getPartner();

    $sql = "SELECT ";

    if ($expr->getDistinct()!==false)
      $sql .= is_array($distinct)
                ?sprintf("DISTINCT ON (%s)",
                  implode(",",array_map($partner,$distinct))
                )
                :"DISTINCT";

    $sql .= sprintf("%s ",
      implode(", ",array_map($partner,$expr->getColumns()))
    );

    $from = $expr->getFrom();
    if (!empty($from))
      $sql .= sprintf("FROM %s",$partner($from));

    $where_cond = $expr->getWhere();
    if (!empty($where_cond))
      $sql = sprintf("%s WHERE %s",$sql,$partner($where_cond));

    $group_by = $expr->getGroupBy();
    if (!empty($group_by))
      $sql = sprintf("%s GROUP BY %s",
				$sql,
        implode(", ",array_map($partner,$group_by))
      );

    $having = $expr->getHaving();
    if (!empty($having))
      $sql = sprintf("%s HAVING %s",$sql,$partner($having));

    $order_by = $expr->getOrderBy();
    if (!empty($order_by))
      $sql = sprintf("%s ORDER BY %s",
        $sql,
        implode(", ",array_map($partner,$order_by))
      );

    $limit = $expr->getLimit();
    if (!empty($limit))
      $sql = sprintf("%s LIMIT %s",$sql,$partner($limit));

    $offset = $expr->getOffset();
    if (!empty($offset))
      $sql = sprintf("%s OFFSET %s",$sql,$partner($offset));

    return trim($sql);
  }
}
