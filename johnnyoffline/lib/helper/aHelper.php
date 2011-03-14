<?php

// Loading of the a CSS, JavaScript and helpers is now triggered here 
// to ensure that there is a straightforward way to obtain all of the necessary
// components from any partial, even if it is invoked at the layout level (provided
// that the layout does use_helper('a'). 

function _a_required_assets()
{
  $response = sfContext::getInstance()->getResponse();

  sfContext::getInstance()->getConfiguration()->loadHelpers(
    array("Url", "jQuery", "I18N", 'PkDialog'));

  jq_add_plugins_by_name(array("ui"));

  if (sfConfig::get('app_a_use_bundled_stylesheet', true))
  {
    $response->addStylesheet('/apostrophePlugin/css/aToolkit.css', 'first');
    $response->addStylesheet('/apostrophePlugin/css/a.css', 'first');
  }

  $response->addJavascript('/apostrophePlugin/js/aUI.js');
  $response->addJavascript('/apostrophePlugin/js/aControls.js');
  // $response->addJavascript('/apostrophePlugin/js/jquery.hotkeys-0.7.9.min.js'); // this is plugin for hotkey toggle for cms UI // I turned this off because we aren't using it right now 1-8-2010 JB
  $response->addJavascript('/apostrophePlugin/js/jquery.autogrow.js'); // Autogrowing Textareas
  // $response->addJavascript('/apostrophePlugin/js/jquery.pulse.js'); // Ajax update highlight a color  // I turned this off because we aren't using it right now 1-8-2010 JB
	$response->addJavascript('/apostrophePlugin/js/jquery.keycodes-0.2.js'); // keycodes
  $webDir = sfConfig::get('sf_a_web_dir', '/apostrophePlugin');
  $response->addJavascript("$webDir/js/a.js");

}

_a_required_assets();

// Too many jquery problems
//sfContext::getInstance()->getResponse()->addJavascript(
// sfConfig::get('sf_a_web_dir', '/apostrophePlugin') . 
// '/js/aSubmitButton.js');
//<script type="text/javascript" charset="utf-8">
//aSubmitButtonAll();
//</script>
function a_slot($name, $type, $options = false)
{
  $options = a_slot_get_options($options);
  $options['type'] = $type;
  aTools::globalSetup($options);
  include_component("a", "area", 
    array("name" => $name, "options" => $options)); 
  aTools::globalShutdown();
}

function a_area($name, $options = false)
{
  $options = a_slot_get_options($options);
  $options['infinite'] = true; 
  aTools::globalSetup($options);
  include_component("a", "area", 
    array("name" => $name, "options" => $options)); 
  aTools::globalShutdown();
}

function a_slot_get_options($options)
{
  if (!is_array($options))
  {
    if ($options === false)
    {
      $options = array();
    }
    else
    {
      $options = aTools::getSlotOptionsGroup($options);
    }
  }
  return $options;
}

function a_slot_body($name, $type, $permid, $options, $validationData, $editorOpen)
{
  $page = aTools::getCurrentPage();
  $slot = $page->getSlot($name);
  $parameters = array("options" => $options);
  $parameters['name'] = $name;
  $parameters['type'] = $type;
  $parameters['permid'] = $permid;
  $parameters['validationData'] = $validationData;
  $parameters['showEditor'] = $editorOpen;
  $user = sfContext::getInstance()->getUser();
  $controller = sfContext::getInstance()->getController();
  $moduleName = $type . 'Slot';
  if ($controller->componentExists($moduleName, "executeSlot"))
  {
    include_component($moduleName, "slot", $parameters);
  }
  else
  {
    include_component("a", "slot", $parameters);
  }
}

function a_navtree($depth = null)
{
  $page = aTools::getCurrentPage();
  $children = $page->getTreeInfo(true, $depth);
  return a_navtree_body($children);
}

function a_navtree_body($children)
{
  $s = "<ul>\n";
  foreach ($children as $info)
  {
    $s .= '<li>' . link_to($info['title'], aTools::urlForPage($info['slug']));
    if (isset($info['children']))
    {
      $s .= a_navtree_body($info['children']);
    }
    $s .= "</li>\n";
  }
  $s .= "</ul>\n";
  return $s;
}

function a_navaccordion()
{
  $page = aTools::getCurrentPage();
  $children = $page->getAccordionInfo(true);
  return a_navtree_body($children);
}

// Keeping this functionality in a helper is very questionable.
// It should probably be a component.

// ... Sure enough, it's now called by a component in preparation to migrate
// the logic there as well.

function a_navcolumn()
{
  $page = aTools::getCurrentPage();
  return _a_navcolumn_body($page);
}

function _a_navcolumn_body($page)
{
  $sortHandle = "";
  $sf_user = sfContext::getInstance()->getUser();
  $admin = $page->userHasPrivilege('edit');
  if ($admin)
  {
    $sortHandle = "<div class='a-btn icon a-drag a-controls'></div>";
  }
  $result = "";
  // Inclusion of archived pages should be a bit generous to allow for tricky situations
  // in which those who can edit a subpage might not be able to find it otherwise.
  // We don't want the performance hit of checking for the right to edit each archived
  // subpage, so just allow those with potential-editor privs to see that archived pages
  // exist, whether or not they are allowed to actually edit them
  if (aTools::isPotentialEditor() && 
    $sf_user->getAttribute('show-archived', true, 'a'))
  {
    $livingOnly = false;
  }
  else
  {
    $livingOnly = true;
  }
  $result = '<ul id="a-navcolumn" class="a-navcolumn">';
  $childrenInfo = $page->getChildrenInfo($livingOnly);
  if (!count($childrenInfo))
  {
    $childrenInfo = $page->getPeerInfo($livingOnly);
  }
  foreach ($childrenInfo as $childInfo)
  {
    $class = "peer_item";
    if ($childInfo['id'] == $page->id)
    {
      $class = "self_item";
    }
    // Specific format to please jQuery.sortable
    $result .= "<li id=\"a-navcolumn_" . $childInfo['id'] . "\" class=\"$class\">\n";
    $title = $childInfo['title'];
    if ($childInfo['archived'])
    {
      $title = '<span class="a-archived-page" title="&quot;'.$title.'&quot; is Unpublished">'.$title.'</span>';
    }
    $result .= $sortHandle.link_to($title, aTools::urlForPage($childInfo['slug']));
    $result .= "</li>\n";
  }
  $result .= "</ul>\n";
  if ($admin)
  {
    $result .= jq_sortable_element('#a-navcolumn', array('url' => 'a/sort?page=' . $page->getId()));    
  }
  return $result;
}
