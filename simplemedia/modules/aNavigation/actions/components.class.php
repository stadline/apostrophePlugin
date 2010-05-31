<?php


class aNavigationComponents extends sfComponents
{
  
  public function executeAccordion()
  {
    $this->root = isset($this->root)? $this->root : '/';
    $this->active = isset($this->active)? $this->active : $this->root;
    
    $this->maxDepth = isset($this->maxDepth)? $this->maxDepth : 999;
    $this->navigation = new aNavigationAccordion($this->root, $this->active);
    $this->nav = $this->navigation->getNav();
    
    $this->nest = 0;
    $page = aPageTable::retrieveBySlug($this->root);
    $this->draggable = $page->userHasPrivilege('edit');
  }
  
  public function executeBreadcrumb()
  {
    $this->root = isset($this->root)? $this->root : '/';
    $this->active = isset($this->active)? $this->active : $this->root;
    
    $this->separator = isset($this->separator)? $this->separator : ' > ';
    $this->navigation = new aNavigationBreadcrumb($this->root, $this->active, $this->options);
    $this->nav = $this->navigation->getNav();
  }
  
  public function executeTabs()
  {
    $this->root = isset($this->root)? $this->root : '/';
    $this->active = isset($this->active)? $this->active : $this->root;
    
    $this->options = array('depth' => isset($this->depth)? $this->depth : 1);
    
    $this->navigation = new aNavigationTabs($this->root, $this->active, $this->options);
    $this->nav = $this->navigation->getNav();
  }
  
}