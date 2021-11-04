<?php

namespace Drakuno\SqlTemplate\Processors;

/**
 * Describes a token processor that relies on cooperation.
 * 
 * Whenever an implementing processor encounters a token
 * it cannot process, it should delegate the task to its partner.
 */
interface PartneredProcessorInterface extends ProcessorInterface
{
	public function getPartner():ProcessorInterface;
	public function setPartner(ProcessorInterface $partner);
}