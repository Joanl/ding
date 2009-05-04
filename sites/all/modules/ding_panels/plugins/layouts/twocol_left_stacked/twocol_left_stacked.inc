<?php
// $Id$

/**
 * Implementation of hook_panels_layouts()
 */
function ding_panels_twocol_left_stacked_panels_layouts() {
  $items = array();
  $items['twocol_left_stacked'] = array(
    'title' => t('Two column left stacked wide left'),
    'icon' => 'twocol_left_stacked.png',
    'theme' => 'panels_twocol_left_stacked',
    'css' => 'twocol_left_stacked.css',
    'panels' => array(
      'top' => t('Top'),
      'left' => t('Left side'),
      'right' => t('Right side'),
      'bottom' => t('Bottom'),
    ),
  );
  return $items;
}

