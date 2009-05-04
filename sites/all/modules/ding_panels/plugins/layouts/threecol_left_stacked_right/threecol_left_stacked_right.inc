<?php
// $Id$

/**
 * @file ding_panels_layouts.module
 * Provides a few library-related Panels layouts.
 */

/**
 * Implementation of hook_panels_layouts()
 */
function ding_panels_threecol_left_stacked_right_panels_layouts() {
  return array('threecol_left_stacked_right' => array(
    'title' => t('Three column left stacked wide right'),
    'icon' => 'threecol_left_stacked_right.png',
    'theme' => 'ding_panels_threecol_left_stacked_right',
    'css' => 'threecol_left_stacked_right.css',
    'panels' => array(
      'top' => t('Top'),
      'left' => t('Left side'),
      'middle' => t('Middle column'),
      'right' => t('Right side'),
      'bottom' => t('Bottom'),
    ),
  ));
}

