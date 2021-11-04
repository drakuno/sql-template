<?php

namespace Drakuno\SqlTemplate;

interface TemplateInterface
{
	/**
	 * Returns tokens nested within
	 */
	public function getChildren():array;
}
