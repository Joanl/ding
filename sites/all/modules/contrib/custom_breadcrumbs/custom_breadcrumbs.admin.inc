<?php
// $Id: custom_breadcrumbs.admin.inc,v 1.1.2.3.2.4 2009/04/25 01:05:03 mgn Exp $

// Lists all current custom breadcrumbs, and provides a link to the edit page.
function custom_breadcrumbs_page() {
  $header = array();
  $multilingual = _custom_breadcrumbs_multilingual();
  $header[] = t('Name');
  $header[] = t('Page type');
  if ($multilingual) {
    $header[] = t('Language');
  }
  $header[] = t('Operations');

  $rows = array();
  $breadcrumbs = _custom_breadcrumbs_load_all_breadcrumbs(TRUE);

  foreach ($breadcrumbs as $breadcrumb) {
    $row = array();
    $name = $breadcrumb->name;
    $type = $breadcrumb->breadcrumb_type;
    $row[] = $name . (!empty($breadcrumb->visibility_php) ? ' '. t('with PHP snippet') : '');
    $row[] = $type;
    if ($multilingual) {
      $row[] = module_invoke('locale', 'language_name', $breadcrumb->language);
    }
    $row[] =  l(t('edit'), 'admin/build/custom_breadcrumbs/'. $breadcrumb->breadcrumb_type .'/edit/'. $breadcrumb->bid);
    $rows[] = $row;
  }
  if (count($rows) == 0) {
    $rows[] = array(array('data' => t('No custom breadcrumbs have been defined.'), 'colspan' => 2 + (int)$multilingual));
  }
  return theme('table', $header, $rows);
}

// Displays an edit form for a custom breadcrumb record.

function custom_breadcrumbs_form(&$form_state, $type) {
  $form = array();
  $breadcrumb = NULL;
  $bid = arg(5);
  if (isset($bid)) {
    drupal_set_title('Edit Custom Breadcrumb for Node');
    $breadcrumb = array_pop(custom_breadcrumbs_load_breadcrumbs_bid('custom_breadcrumbs', $bid));
  }
  else {
    drupal_set_title('Add Custom Breadcrumb for Node');
  }
  $options = array();
  foreach (node_get_types('names') as $type => $name) {
    $options[$type] = $name;
  }
  $form['node_type'] = array(
    '#type' => 'select',
    '#title' => t('Node type'),
    '#required' => TRUE,
    '#options' => $options,
    '#description' => t('The node type this custom breadcrumb trail will apply to.'),
    '#default_value' => $bid ? $breadcrumb->node_type : NULL,
    '#weight' => -10,
  );
  // store information needed to save this breadcrumb
  $form['#table'] = 'custom_breadcrumb';
  $form += custom_breadcrumbs_common_form_elements($bid, $breadcrumb);

  return $form;
}

function custom_breadcrumbs_admin_settings() {
  $form = array();
  drupal_set_title(t('Custom Breadcrumbs Configuration'));

  $form['settings'] = array(
    '#type'           => 'fieldset',
    '#title'          => t('Basic Settings'),
    '#collapsible'    => TRUE,
  );

  $form['settings']['custom_breadcrumb_home'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Home breadcrumb text'),
    '#default_value'  => variable_get('custom_breadcrumb_home', t('Home')),
    '#description'    => t('Text to display at top of breadcrumb trail.  Typically home or your site name.  Leave blank to have no home breadcrumb.'),
  );

  $form['adv_settings'] = array(
    '#type'           => 'fieldset',
    '#title'          => t('Advanced Settings'),
    '#collapsible'    => TRUE,
  );

  $form['adv_settings']['custom_breadcrumbs_force_active_trail'] = array(
    '#type' => 'checkbox',
    '#title' => t('Force the active trail'),
    '#description' => t('This options sets the active trail to match the custom breadcrumb trail and overrides the normal theme_links() implementation to add the active-trail class to links. This is experimental and may not work as expected. If this is of interest to you, please test and report back to the custom breadcrumbs issue queue.'),
    '#default_value' => variable_get('custom_breadcrumbs_force_active_trail', FALSE),
    '#weight' => -10,
  );

  $form['#submit'][] = 'custom_breadcrumbs_admin_settings_submit';

  return system_settings_form($form);
}

function custom_breadcrumbs_admin_settings_submit($form, &$form_state) {
  drupal_rebuild_theme_registry();  // rebuild the theme registry
  drupal_set_message('The theme registry has been rebuilt');
}

function custom_breadcrumbs_common_form_elements($bid, $breadcrumb) {
  $form = array();
  $form['bid'] = array('#type' => 'hidden', '#value' => $bid, );
  $multilingual = _custom_breadcrumbs_multilingual();
  if ($multilingual) {
    $form['language'] = array(
      '#type' => 'select',
      '#title' => t('Language'),
      '#options' => array('' => t('All languages')) + locale_language_list('name'),
      '#default_value' => $bid ? $breadcrumb->language : NULL,
      '#description' => t('A breadcrumb set for a specific language will always be used when displaying a node in that language, and takes precedence over breadcrumbs set for <em>All languages</em>.'),
    );
  }
  else {
    $form['language'] = array('#type' => 'value', '#value' => '', );
  }
  $form['visibility_php'] = array(
    '#type' => 'textarea',
    '#title' => t('Breadcrumb visibility'),
    '#access' => user_access('use php in custom breadcrumbs'),
    '#description' => t('Determine whether this breadcrumb should be displayed by using a snippet of PHP to return TRUE or FALSE. Note that this code has access to the $node variable, and can check its type or any other property.'),
    '#default_value' => $bid ? $breadcrumb->visibility_php : '',
  );
  $form['titles'] = array(
    '#type' => 'textarea',
    '#title' => t('Titles'),
    '#required' => TRUE,
    '#description' => t('A list of titles for the breadcrumb links, one on each line.'),
    '#default_value' => $bid ? $breadcrumb->titles : NULL,
  );
  $form['paths'] = array(
    '#type' => 'textarea',
    '#title' => t('Paths'),
    '#required' => TRUE,
    '#description' => t('A list of Drupal paths for the breadcrumb links, one on each line.'),
    '#default_value' => $bid ? $breadcrumb->paths : NULL,
  );
  $form['help'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#title' => t('Placeholder tokens'),
    '#description' => t("The following placeholder tokens can be used in both paths and titles. When used in a path or title, they will be replaced with the appropriate values."),
  );
  if (module_exists('token')) {
    $form['help']['tokens'] = array('#value' => theme('token_help', array('node', 'user')), );
  }
  else {
    $form['help']['#description'] = t("To use dynamic placeholder tokens in your breadcrumb trails (the ID or title of the current node, for example), download and install the <a href='@token'>Token module</a> from Drupal.org.", array('@token' => 'http://www.drupal.org/project/token'));
    $form['help']['#collapsible'] = FALSE;
    $form['help']['#collapsed'] = FALSE;
  }
  $form['help2'] = array(
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#title' => t('Special identifiers'),
    '#description' => t("The following special identifiers can be used to achieve a special behavior. Identifiers should be added to the paths area in the following format:  identifier|path. <br />Example: ". check_plain('<pathauto>') ."|[ogname-raw]"),
  );
  $form['help2']['tokens'] = array('#value' => theme('custom_breadcrumbs_help_identifiers'), );

  $form['buttons']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );
  if ($bid) {
    $form['buttons']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete'),
      '#submit' => array('custom_breadcrumbs_form_delete'),
    );
  }
  $form['buttons']['cancel'] = array(
    '#type' => 'submit',
    '#value' => t('Cancel'),
    '#submit' => array('custom_breadcrumbs_form_cancel'),
  );
  return $form;
}

function custom_breadcrumbs_form_validate($form, &$form_state) {
  $path_count = count(explode("\n", trim($form_state['values']['paths'])));
  $title_count = count(explode("\n", trim($form_state['values']['titles'])));
  if ($title_count != $path_count) {
    $error_field = ($title_count < $path_count) ? 'titles' : 'paths';
    form_set_error($error_field, t('Every link path must have a matching title. There are !paths paths, and !titles titles.', array('!paths' => $path_count, '!titles' => $title_count)));
  }
}

function custom_breadcrumbs_form_submit($form, &$form_state) {
  $breadcrumb = (object)$form_state['values'];
  _custom_breadcrumbs_save_breadcrumb($form['#table'], $breadcrumb, $form['#save_func']);
  $form_state['redirect'] = 'admin/build/custom_breadcrumbs';
}

function custom_breadcrumbs_form_delete($form, &$form_state) {
  _custom_breadcrumbs_delete_breadcrumb($form['#table'], $form_state['values']['bid'], $form['#delete_func']);
  $form_state['redirect'] = 'admin/build/custom_breadcrumbs';
}

function custom_breadcrumbs_form_cancel($form, &$form_state) {
  $form_state['redirect'] = 'admin/build/custom_breadcrumbs';
}

/**
 * Check whether the administration interface should show multilingual features.
 */
function _custom_breadcrumbs_multilingual() {
  return module_exists('locale'); // || db_result(db_query("SELECT COUNT(*) FROM {custom_breadcrumb} WHERE language != ''"));
}
