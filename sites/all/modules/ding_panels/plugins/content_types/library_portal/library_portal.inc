<?php // $Id$

/**
 * @file library_portal.inc
 * Provides several library portal page related panels content types.
 */


/**
 * Callback function to supply a list of content types.
 *
 * This is only required to make CTools know that we're providing 
 * multiple types here (since we have no single => TRUE in the array).
 */
function ding_panels_library_portal_ctools_content_types() {
  return array(
    'title' => t('Library page'),
  );
}

/**
 * Callback function to supply a list of content types.
 */
function ding_panels_library_portal_content_type_content_types() {
  $types = array(
    'library_portal_title' => array(
      'title' => t('Library portal title'),
      'description' => t('The title and navigation for a library page.'),
    ),
    'library_portal_navigation' => array(
      'title' => t('Library portal navigation.'),
      'description' => t('Shows the address, map and other locative information for the library.'),
    ),
  );

  // Append our default settings to every type.
  foreach ($types as $name => $type) {
    $types[$name] += array(
      'category' => t('Library page'),
      'required context' => new ctools_context_required(t('Node'), 'node'),
    );
  }
  return $types;
}

/**
 * Return the pane contents.
 */
function ding_panels_library_portal_content_type_render($subtype, $conf, $panel_args, $context) {
  $block = new stdClass();
  $node = isset($context->data) ? drupal_clone($context->data) : NULL;
  switch($subtype) {
    case 'library_portal_title':
      $block->content = theme('ding_panels_library_portal_title', $node);
      break;
    case 'library_portal_navigation':
      $block->content = _ding_panels_library_portal_navigation_render($node);
      break;
  }
  return $block;
}

/**
 * Return the pane titles.
 */
function ding_panels_library_portal_content_type_admin_title($subtype, $conf, $context) {
  switch($subtype) {
    case 'library_portal_title':
      return t('Library portal title');
    case 'library_portal_navigation':
      return t('Library portal navigation');
  }
}

/**
 * Returns an edit form for the content type.
 *
 * We're not actually doing anything here, but we need to have this hook 
 * for this content type to work.
 */
function ding_panels_library_portal_content_type_edit_form(&$form, &$form_state) {
  return $form;
}

/**
 * Render the menu for a portal page.
 *
 * @param object $node
 *    The library node.
 * @return string
 *    Rendered menu.
 */
function _ding_panels_library_portal_navigation_render($node) {
  $tree = menu_tree_all_data('ding_library_' . $node->nid);

  //dpm($tree);
  return menu_tree_output($tree);
}


