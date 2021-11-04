<?php

namespace Drakuno\SqlTemplate\Processors;

trait SimplePartnerTrait
{
	private $partner;

	public function getPartner():ProcessorInterface{ return $this->partner; }
	public function setPartner(ProcessorInterface $partner)
	{
		$this->partner = $partner;
	}
}