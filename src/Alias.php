<?php

namespace Drakuno\SqlTemplate;

class Alias implements TemplateInterface
{
	use NaturalAccessorsTrait;

	private $template;
	private $name;

	public function __construct(TemplateInterface $template,Name $name)
	{
		$this->setTemplate($template);
		$this->setName($name);
	}

	public function getChildren():array
	{
		return [$this->getTemplate(),$this->getName()];
	}

	public function getName():Name{ return $this->name; }
	public function setName(Name $name)
	{
		$this->name = $name;
	}

	public function getTemplate():TemplateInterface{ return $this->template; }
	public function setTemplate(TemplateInterface $template)
	{
		$this->template = $template;
	}
}