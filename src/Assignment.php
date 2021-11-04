<?php

namespace Drakuno\SqlTemplate;

class Assignment implements TemplateInterface
{
  use NaturalAccessorsTrait;

  private $left_template;
  private $right_template;

  public function __construct(
    TemplateInterface $left_template,
    TemplateInterface $right_template
  )
  {
    $this->setLeftTemplate($left_template);
    $this->setRightTemplate($right_template);
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

  public function getRightTemplate():TemplateInterface
  {
    return $this->right_template;
  }
  public function setRightTemplate(TemplateInterface $right_template)
  {
    $this->right_template = $right_template;
  }
}