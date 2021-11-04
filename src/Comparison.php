<?php

namespace Drakuno\SqlTemplate;

class Comparison implements TemplateInterface
{
	use NaturalAccessorsTrait;

	const OPERATOR_EQ   = 0;
	const OPERATOR_LT   = 1;
	const OPERATOR_LTEQ = 2;
	const OPERATOR_GT   = 3;
	const OPERATOR_GTEQ = 4;
	const OPERATOR_NEQ	= 5;

	private $left_template;
	private $right_template;
	private $operator_code;

	public function __construct(
		TemplateInterface $left_template,
		TemplateInterface $right_template,
		int $operator_code=0
	)
	{
		$this->setLeftTemplate($left_template);
		$this->setRightTemplate($right_template);
		$this->setOperatorCode($operator_code);
	}

	public function getChildren():array
	{
		return [$this->getLeftTemplate(),$this->getRightTemplate()];
	}

	public function getLeftTemplate():TemplateInterface
	{
		return $this->left_template;
	}
	public function setLeftTemplate(TemplateInterface $left_template)
	{
		$this->left_template = $left_template;
	}

	public function getOperatorCode():int
	{
		return $this->operator_code;
	}
	public function setOperatorCode(int $operator_code)
	{
		if ($operator_code<0||$operator_code>self::OPERATOR_NEQ)
			throw new TypeError;
		$this->operator_code = $operator_code;
	}

	public function getRightTemplate():TemplateInterface
	{
		return $this->right_template;
	}
	public function setRightTemplate(TemplateInterface $right_template)
	{
		$this->right_template = $right_template;
	}
}