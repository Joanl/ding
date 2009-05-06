<?php // $Id$

/**
 * @file node_body.inc
 * Provides several library portal page related panels content types.
 */


/**
 * Callback function to supply a list of content types.
 *
 * This is only required to make CTools know that we're providing 
 * multiple types here (since we have no single => TRUE in the array).
 */
function ding_panels_node_body_ctools_content_types() {
  return array(
    'title' => t('Node'),
  );
}

/**
 * Callback function to supply a list of content types.
 */
function ding_panels_node_body_content_type_content_types() {
  return array(
    'node_body_title' => array(
      'title' => t('Node body'),
      'description' => t('The rendered node body.'),
      'category' => t('Node'),
      'required context' => new ctools_context_required(t('Node'), 'node'),
    ),
  );
}

/**
 * Return the pane contents.
 */
function ding_panels_node_body_content_type_render($subtype, $conf, $panel_args, $context) {
  $block = new stdClass();
  $node = isset($context->data) ? drupal_clone($context->data) : NULL;
  $block->content = check_markup($node->body, $node->format, $node->language);
  return $block;
}

/**
 * Return the pane titles.
 */
function ding_panels_node_body_content_type_admin_title($subtype, $conf, $context) {
  return t('Node body');
}

/**
 * Returns an edit form for the content type.
 *
 * We're not actually doing anything here, but we need to have this hook 
 * for this content type to work.
 */
function ding_panels_node_body_content_type_edit_form(&$form, &$form_state) {
  return $form;
}

