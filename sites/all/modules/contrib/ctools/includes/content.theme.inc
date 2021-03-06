<?php
// $Id: content.theme.inc,v 1.2 2009/04/18 02:00:34 merlinofchaos Exp $

/**
 * @file
 * Contains theme registry and theme implementations for the content types.
 */

/**
 * Implementation of hook_theme to load all content plugins and pass thru if
 * necessary.
 */
function ctools_content_theme(&$theme) {
  ctools_include('content');

  $plugins = ctools_get_content_types();
  foreach ($plugins as $plugin) {
    if (ctools_plugin_get_function($plugin, 'hook theme')) {
      $function($theme, $plugin);
    }
  }
}
