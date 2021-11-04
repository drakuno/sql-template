<?php

namespace Drakuno\SqlTemplate\Maps\Sql;

use Drakuno\SqlTemplate\TemplateInterface;
use Drakuno\SqlTemplate\Name;
use Drakuno\SqlTemplate\Order;
use Drakuno\SqlTemplate\Processors\ClassBasedHandlesTestTrait;
use Drakuno\SqlTemplate\Processors\PartneredProcessorInterface;
use Drakuno\SqlTemplate\Processors\SimplePartnerTrait;

class OrderAsSqlMap implements PartneredProcessorInterface,SqlMapInterface
{
	use ClassBasedHandlesTestTrait,SimplePartnerTrait;

	const KEYWORDS	   = ["ASC","DESC"];
	const TARGET_CLASS = Order::class;

	public function __invoke(TemplateInterface $order):string
	{
		$sql = sprintf('%s %s',
			$this->getPartner()($order->getTarget()),
			self::KEYWORDS[$order->getType()]
		);

		$nulls_first = $order->getNullsFirst();
		if (!is_null($nulls_first))
			$sql = sprintf("%s NULLS %s",
				$sql,
				$nulls_first?"FIRST":"LAST"
			);

		return $sql;
	}
}