<?php

class aCreateForm extends BaseForm
{
  protected $page;
  // PARAMETERS ARE REQUIRED, no-parameters version is strictly to satisfy i18n-update
  public function __construct($page = null)
  {
    if (!$page)
    {
      $page = new aPage();
    }
    $this->page = $page;
    parent::__construct();
  }
    
  public function configure()
  {
    $this->setWidget('parent', new sfWidgetFormInputHidden(array('default' => $this->page->getSlug())));
    $this->setWidget('title', new sfWidgetFormInputText(array(), array('class' => 'a-breadcrumb-create-childpage-title a-breadcrumb-input')));
    
    $this->setWidget('engine', new sfWidgetFormSelect(array('choices' => aTools::getEngines())));
    $this->widgetSchema['engine']->setLabel('Page Type');

    $this->setWidget('template', new sfWidgetFormSelect(array('choices' => aTools::getTemplates())));
    $this->widgetSchema['template']->setLabel('Page Template');
    
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('apostrophe');
  }
}
