<?php
/* =====================================
  template.php
* ------------------------------------- */

// Auto-rebuild the theme registry during theme development.
drupal_rebuild_theme_registry(); /*TODO: add a theme setting for this*/



/**
 * Implements theme_menu_item_link()
 * yup original is from zen and we humbly say thanx :)
 */
function moshpit_menu_item_link($link) {
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }

  //define a class for each tab 
  //TODO check out the multilang hell....
  $linkclass = mothership_id_safe($link['title']);
  
  // If an item is a LOCAL TASK, render it as a tab
  if ($link['type'] & MENU_IS_LOCAL_TASK) {
    $link['title'] = '<span class="tab '. $linkclass .' ">' . check_plain($link['title']) . '</span>';
    $link['localized_options']['html'] = TRUE;
    $link['localized_options']['attributes'] = array('class' => $linkclass);
  }

  return l($link['title'], $link['href'], $link['localized_options']);
}

