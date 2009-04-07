<?php
// $Id$

/**
 * @file ding_panels_content.theme.inc
 * Theming implementation for library panes.
 */

/**
 * Preprocess hook for the library title and navigation pane.
 */
function ding_panels_content_preprocess_library_title(&$variables) {
  $node = $variables['node'];
  if (isset($node->ding_slug) && !empty($node->ding_slug)) {
    $base_path = 'biblioteker/' . $node->ding_slug;
  }
  else {
    $base_path = 'biblioteker/' . $node->nid;
  }

  $variables['library_links'] = _ding_panels_content_theme_library_title_navigation($node, $base_path);
  $variables['library_navigation'] = theme('item_list', $variables['library_links']);
  $variables['library_title'] = l($node->title, $base_path);
}

function _ding_panels_content_theme_library_title_navigation($node, $base_path) {
  $links = array();
  if ($node->type == 'library') {
    $links['blog'] = l(t('Blog'), $base_path . '/blog');
    $links['events'] = l(t('Events'), $base_path . '/arrangementer');
    $links['facilities'] = l(t('Facilities'), $base_path . '/faciliteter');
    $links['about'] = l(t('About'), $base_path . '/om');
  }
  return $links;
}

/**
 * Preprocess hook for the library location.
 */
function ding_panels_content_preprocess_library_location(&$variables) {
  $node = $variables['node'];

  // Add a static Google map to the location information.
  if (function_exists(location_has_coordinates) && location_has_coordinates($node->location)) {
    $map_url = url('http://maps.google.com/staticmap', array('query' => array(
      'zoom' => 14,
      'size' => '194x140',
      'markers' => $node->location['latitude'] . ',' . $node->location['longitude'],
      'key' => keys_api_get_key('gmap', $_SERVER['HTTP_HOST']),
      'sensor' => 'false',
    )));
    $variables['library_map'] = theme('image', $map_url, '', '', NULL, FALSE);
  }
}

