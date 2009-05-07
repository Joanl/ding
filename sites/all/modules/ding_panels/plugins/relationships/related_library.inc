<?php // $Id$

/**
 * @file related_library.inc
 * Provide the library related to a node as a Panels relation.
 */

/**
 * Implementation of hook_ctools_relationships().
 */
function ding_panels_related_library_ctools_relationships() {
  $args = array();
  $args['related_library'] = array(
    'title' => t('Related library'),
    'keyword' => 'related_library',
    'description' => t('Finds the related library from a node context.'),
    'required context' => new ctools_context_required(t('Node'), 'node'),
    'context' => 'ding_panels_related_library_context',
    'settings form' => 'ding_panels_related_library_settings_form',
  );
  return $args;
}

/**
 * Return a new context based on an existing context
 */
function ding_panels_related_library_context($context = NULL, $conf) {
  // If unset it wants a generic, unfilled context, which is just NULL
  if (empty($context->data)) {
    return ctools_context_create_empty('node');
  }

  if (isset($context->data->field_library_ref[0]) && $context->data->field_library_ref[0] > 0) {
    $node = node_load($context->data->field_library_ref[0]);
    if ($node) {
      return ctools_context_create('node', $node);
    }
  }
  return FALSE;
}

/**
 * Settings form for the relationship
 */
function ding_panels_related_library_settings_form($conf) {
  return $form;
}



