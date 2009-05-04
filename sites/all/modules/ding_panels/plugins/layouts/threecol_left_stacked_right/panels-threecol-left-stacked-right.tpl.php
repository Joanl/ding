<?php
// $Id$

/**
 * Implementation of hook_panels_layouts()
 */
function panels_threecol_left_stacked_right_panels_layouts() {
  $items['panels_threecol_left_stacked_right'] = array(
   'title' => t('Three column left stacked right'),
    'icon' => 'threecol_left_stacked_right.png',
    'theme' => 'panels_threecol_left_stacked_right',
    'css' => 'threecol_left_stacked_right.css',
    'panels' => array(
      'top' => t('Top'),
      'left' => t('Left side'),
      'middle' => t('Middle column'),
      'right' => t('Right side'),
      'bottom' => t('Bottom'),
    ),
  );
  return $items;
}

