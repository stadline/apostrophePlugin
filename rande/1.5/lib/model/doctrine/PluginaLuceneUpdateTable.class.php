<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginaLuceneUpdateTable extends Doctrine_Table
{
  static public function requestUpdate($page)
  {
    $update = new aLuceneUpdate();
    $update->page_id = $page->getId();
    $update->culture = $page->getCulture();
    $update->save();
  }
}