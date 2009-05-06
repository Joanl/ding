<?php // $Id$

/**
 * @file
 * Plugin to provide access control based upon a library node's status 
 * as a special library.
 */

/**
 * Implementation of hook_ctools_access().
 */
function ding_panels_library_page_type_ctools_access() {
  $items = array();
  $items['library_page_type'] = array(
    'title' => t('Library: Page type'),
    'description' => t('Control access by library type.'),
    'callback' => 'ding_panels_library_page_type_ctools_access_check',
    'default' => array('library_page_type' => 'normal'),
    'settings form' => 'ding_panels_library_page_type_ctools_access_settings',
    'summary' => 'ding_panels_library_page_type_ctools_access_summary',
    'required context' => new ctools_context_required(t('Node'), 'node'),
  );
  return $items;
}

/**
 * Check for access.
 */
function ding_panels_library_page_type_ctools_access_check($conf, $context) {
  // As far as I know there should always be a context at this point,
  // but this is safe.
  if (empty($context) || empty($context->data) || empty($context->data->type) || $context->data->type != 'library') {
    return FALSE;
  }

  $type = (isset($conf['library_page_type'])) ? $conf['library_page_type'] : 'normal';
  $node = $context->data;

  // If library type is not set on the node, we allow it to pass if the 
  // selected type is normal.
  if (!isset($node->library_page_type) && $type != 'normal') {
    return FALSE;
  }
  elseif ($node->library_page_type != $type) {
    return FALSE;
  }

  return TRUE;
}

/**
 * Add the type to the settings form.
 */
function ding_panels_library_page_type_ctools_access_settings(&$form, &$form_state, $conf) {
  $form['settings']['library_page_type'] = array(
    '#type' => 'radios',
    '#title' => t('Library type'),
    '#options' => array(
      'normal' => t('Normal library page'),
      'portal' => t('Portal-style library page'),
    ),
    '#default_value' => (isset($conf['library_page_type'])) ? $conf['library_page_type'] : 'normal',
    '#description' => t('Pick the allowed library type.'),
  );
}

/**
 * Provide a summary description of what we checked.
 */
function ding_panels_library_page_type_ctools_access_summary($conf, $context) {
  $type = (isset($conf['library_page_type'])) ? $conf['library_page_type'] : 'normal';
  return t('@identifier must be a "@type" library', array('@identifier' => $context->identifier, '@type' => $type));
}

