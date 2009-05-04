<?php // $Id$

/**
 * @file library.inc
 * Provides several library related panels content types.
 */


/**
 * Callback function to supply a list of content types.
 *
 * This is only required to make CTools know that we're providing 
 * multiple types here (since we have no single => TRUE in the array).
 */
function ding_panels_library_ctools_content_types() {
  return array(
    'title' => t('Library page'),
  );
}

/**
 * Callback function to supply a list of content types.
 */
function ding_panels_library_content_type_content_types() {
  $types = array(
    'library_title' => array(
      'title' => t('Library title and navigation'),
      'description' => t('The title and navigation for a library page.'),
    ),
    'library_location' => array(
      'title' => t('Library location'),
      'description' => t('Shows the address, map and other locative information for the library.'),
    ),
    'library_hours' => array(
      'title' => t('Library opening hours'),
      'description' => t('Shows the library opening hours.'),
    ),
    'library_about' => array(
      'title' => t('Library about text'),
      'description' => t('Shows the main library description text in its full length.'),
    ),
    'library_feature_list' => array(
      'title' => t('Library feature list'),
      'description' => t('Simple list of library features, containing only the title.'),
    ),
    'library_feature_detail_list' => array(
      'title' => t('Library detailed feature list'),
      'description' => t('More detailed view of library features with pictures and description.'),
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
function ding_panels_library_content_type_render($subtype, $conf, $panel_args, $context) {
  $block = new stdClass();
  $node = isset($context->data) ? drupal_clone($context->data) : NULL;
  switch($subtype) {
    case 'library_title':
      $block->content = theme('ding_panels_content_library_title', $node);
      break;
    case 'library_location':
      $block->content = theme('ding_panels_content_library_location', $node);
      break;
    case 'library_hours':
      $block->title = t('Opening hours');
      // Ask CCK to render the opening hours field for us.
      $block->content = content_format('field_opening_hours', $node->field_opening_hours, 'default', $node);
      break;
    case 'library_about':
      // Render the node body as block content.
      $block->content = check_markup($node->body, $node->format, $node->language);
      break;
    case 'library_feature_list':
    case 'library_feature_detail_list':
      $block->title = t('Services and facilities');
      $block->content = theme_item_list(_ding_panels_library_features_by_library($node));
  }
  return $block;
}

/**
 * Return the pane titles.
 */
function ding_panels_library_content_type_admin_title($subtype, $conf, $context) {
  switch($subtype) {
    case 'library_title':
      return t('Library title and navigation');
    case 'library_location':
      return t('Library location');
    case 'library_hours':
      return t('Library opening hours');
    case 'library_about':
      return t('Library about text');
    case 'library_feature_list':
    case 'library_feature_detail_list':
      return t('Services and facilities');
  }
}

/**
 * Returns an edit form for the content type.
 *
 * We're not actually doing anything here, but we need to have this hook 
 * for this content type to work.
 */
function ding_panels_library_content_type_edit_form(&$form, &$form_state) {
  return $form;
}

/**
 * Find all features related to a library node.
 *
 * @param object $node
 *    The library node we want features for.
 * @return array
 *    Array of feature titles, keyed by node id.
 */
function _ding_panels_library_features_by_library($node) {
  // First, get the feature with a nice bit of SQL.
  $query = db_query("
    SELECT n.nid, n.title
    FROM content_field_feature_ref AS fr
    LEFT JOIN node AS n ON ( n.nid = fr.field_feature_ref_nid )
    WHERE fr.field_feature_ref_nid IS NOT NULL
    AND fr.nid = %d
    ORDER BY fr.delta ASC;
  ", $node->nid);

  // And stick them in a nice little array.
  $features = array();
  while ($row = db_fetch_array($query)) {
    $features[$row['nid']] = $row['title'];
  }
  return $features;
}

