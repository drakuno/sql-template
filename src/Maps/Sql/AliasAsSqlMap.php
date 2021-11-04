<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\Alias;
use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class AliasAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
  use ClassBasedHandlesTestTrait,SimplePartnerTrait;

  const TARGET_CLASS = Alias::class;

  public function __invoke(TemplateInterface $alias):string
  {
    $template  = $alias->getTemplate();
    $partner   = $this->getPartner();
    $sql       = $partner($template);

    if (!is_a($template,Name::class))
      $sql = sprintf("(%s)",$sql);

    return sprintf('%s %s',
      $sql,
      $partner($alias->getName())
    );
  }
}