<?php
// $Id: term_view.inc,v 1.3 2009/04/30 17:15:30 merlinofchaos Exp $

/**
 * @file
 * Handle the 'term view' override task.
 *
 * This plugin overrides term/%term and reroutes it to the delegator, where
 * a list of tasks can be used to service this request based upon criteria
 * supplied by access plugins.
 */

/**
 * Specialized implementation of hook_delegator_tasks(). See api-task.html for
 * more information.
 */
function delegator_term_view_delegator_tasks() {
  return array(
    // This is a 'page' task and will fall under the page admin UI
    'task type' => 'page',

    'title' => t('Taxonomy term view'),
    'description' => t('Control what handles the job of displaying a term at taxonomy/term/%term.'),
    'admin title' => 'Taxonomy term view', // translated by menu system
    'admin description' => 'Overrides for the built in taxonomy term handler at <em>taxonomy/term/%term</em>.',
    'admin path' => 'taxonomy/term/%term',

    // Menu hooks so that we can alter the term/%term menu entry to point to us.
    'hook menu' => 'delegator_term_view_menu',
    'hook menu alter' => 'delegator_term_view_menu_alter',

    // Provide a setting to the primary settings UI for Panels
    'admin settings' => 'delegator_term_view_admin_settings',

    // This is task uses 'context' handlers and must implement these to give the
    // handler data it needs.
    'handler type' => 'context',
    'get arguments' => 'delegator_term_view_get_arguments',
    'get context placeholders' => 'delegator_term_view_get_contexts',

    // Allow additional operations
    'operations' => array(
      array(
        'title' => t('Task handlers'),
        'href' => "admin/build/delegator/term_view",
      ),
      array(
        'title' => t('Settings'),
        'href' => "admin/build/delegator/term_view/settings",
      ),
    ),
  );
}

/**
 * Create the term view settings page menu item.
 */
function delegator_term_view_menu(&$items, $task) {
  $items['admin/build/delegator/term_view/settings'] = array(
    'page callback' => 'drupal_get_form',
    'page arguments' => array('delegator_term_view_settings'),
    'file path' => $task['path'],
    'file' => $task['file'],
    'access arguments' => array('administer delegator'),
    'type' => MENU_CALLBACK,
  );
}

/**
 * Callback defined by delegator_term_view_delegator_tasks().
 *
 * Alter the term view input so that term view comes to us rather than the
 * normal term view process.
 */
function delegator_term_view_menu_alter(&$items, $task) {
  // Override the term view handler for our purpose.
  $items['taxonomy/term/%']['page callback'] = 'delegator_term_view';
  $items['taxonomy/term/%']['file path'] = $task['path'];
  $items['taxonomy/term/%']['file'] = $task['file'];
}

/**
 * Entry point for our overridden term view.
 *
 * This function asks its assigned handlers who, if anyone, would like
 * to run with it. If no one does, it passes through to Drupal core's
 * term view, which is term_page_view().
 */
function delegator_term_view($terms, $depth = 0, $op = 'page') {
  // While we ordinarily should never actually get feeds through here,
  // just in case
  if ($op != 'feed') {
    // Load my task plugin
    $task = delegator_get_task('term_view');

    // Load the term into a context.
    ctools_include('context');
    ctools_include('context-task-handler');
    $contexts = ctools_context_handler_get_task_contexts($task, '', array($terms, $depth));
    if (empty($contexts)) {
      return drupal_not_found();
    }

    $output = ctools_context_handler_render($task, '', $contexts, array($terms, $depth, $op));
    if ($output !== FALSE) {
      return $output;
    }
  }

  // Otherwise, fall back.
  module_load_include('inc', 'taxonomy', 'taxonomy.pages');
  return taxonomy_term_page($terms, $depth, $op);
}

/**
 * Callback to get arguments provided by this task handler.
 *
 * Since this is the term view and there is no UI on the arguments, we
 * create dummy arguments that contain the needed data.
 */
function delegator_term_view_get_arguments($task, $subtask_id) {
  return array(
    array(
      'keyword' => 'term',
      'identifier' => variable_get('delegator_term_view_type', 'multiple') == 'multiple' ? t('Term(s) being viewed') : t('Term being viewed'),
      'id' => 1,
      'name' => variable_get('delegator_term_view_type', 'multiple') == 'multiple' ? 'terms' : 'term',
      'settings' => array('input_form' => 'tid'),
      'default' => '404',
    ),
    array(
      'keyword' => 'depth',
      'identifier' => t('Depth'),
      'id' => 1,
      'name' => 'string',
      'settings' => array(),
    ),
  );
}

/**
 * Callback to get context placeholders provided by this handler.
 */
function delegator_term_view_get_contexts($task, $subtask_id) {
  return ctools_context_get_placeholders_from_argument(delegator_term_view_get_arguments($task, $subtask_id));
}

/**
 * Settings page for this item.
 */
function delegator_term_view_settings() {
  $task = delegator_get_task('term_view');
  delegator_set_trail($task);
  $form = array();

  // This passes thru because the setting can also appear on the main Panels
  // settings form.
  delegator_term_view_admin_settings($form);
  $form['delegator_term_view_type'] = array(
    '#type' => 'radios',
    '#title' => t('Allow multiple terms'),
    '#options' => array('single' => t('Single term'), 'multiple' => t('Multiple terms')),
    '#description' => t('By default, Drupal allows multiple terms as an argument by separating them with commas or plus signs. If you set this to single, that feature will be disabled.'),
    '#default_value' => variable_get('delegator_term_view_type', 'multiple'),
  );

  return system_settings_form($form);
}

/**
 * Provide a setting to the Panels administrative form.
 */
function delegator_term_view_admin_settings(&$form) {
  $form['delegator_term_view_type'] = array(
    '#type' => 'radios',
    '#title' => t('Allow multiple terms on taxonomy/term/%term'),
    '#options' => array('single' => t('Single term'), 'multiple' => t('Multiple terms')),
    '#description' => t('By default, Drupal allows multiple terms as an argument by separating them with commas or plus signs. If you set this to single, that feature will be disabled.'),
    '#default_value' => variable_get('delegator_term_view_type', 'multiple'),
  );
}
