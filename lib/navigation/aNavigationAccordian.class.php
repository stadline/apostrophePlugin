<?php

class aNavigationAccordian extends aNavigation
{
  protected $cssClass = 'a-tab-nav-item'; 
  public function buildNavigation()
  {
    $this->rootInfo = parent::$hash[$this->root];
    $this->activeInfo = parent::$hash[$this->active];
    $this->nav = $this->rootInfo['children'];
    $this->traverse($this->nav);
  }
  
  public function traverse(&$tree)
  {
    foreach($tree as $pos => &$node)
    {
      $node['class'] = $this->cssClass;
      if($pos == 0) $node['class'] = $node['class'].' first';
      if($pos == count($tree)-1) $node['class'] = $node['class'].' last';
      
      if(self::isAncestor($node, $this->activeInfo))
      {
        //We need to set this nodes peers to have the ancestor-peer class
        foreach($tree as &$peer)
        {
          $peer['class'] = @$peer['class'].' ancestor-peer';
        } 
        //This page is an ancestor so set the class
        $node['class'] = $node['class'].' ancestor';
      }
      else if($node['id'] == $this->activeInfo['id'])
      {
        //We need to set this nodes peer to have the peer class
        foreach($tree as &$peer)
        {
          $peer['class'] = @$peer['class'].' peer';
        }
        //This node is the current so set the class
        $node['class'] = $node['class'].' current';
      }
      else
      {
        unset($node['children']);
      }
      
      if(isset($node['children']) && count($node['children']))
        $this->traverse($node['children']);
      if($node['archived'] == true)
      {
        $node['class'] = $node['class'] . ' archived';
        if($this->livingOnly)
          unset($tree[$pos]);
      }
    }  
  }
  
  public function getNav()
  {
    return $this->nav;
  }
  
}
