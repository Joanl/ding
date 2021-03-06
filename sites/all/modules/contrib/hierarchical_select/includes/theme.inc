<?php
// $Id: theme.inc,v 1.4 2009/03/21 20:07:46 wimleers Exp $

/**
 * @file
 * All theme functions for the Hierarchical Select module.
 */


/**
 * @ingroup themeable
 * @{
 */

/**
 * Format a hierarchical select.
 *
 * @param $element
 *   An associative array containing the properties of the element.
 * @return
 *   A themed HTML string representing the form element.
 */
function theme_hierarchical_select($element) {
  $output = '';

  // Update $element['#attributes']['class'].
  $hsid = $element['hsid']['#value'];
  $level_labels_style = variable_get('hierarchical_select_level_labels_style', 'none');
  $classes = array(
   'hierarchical-select-wrapper',
   "hierarchical-select-level-labels-style-$level_labels_style",
  );
  $element['#attributes']['class'] .= ' '. implode(' ', $classes);
  $element['#attributes']['id'] = "hierarchical-select-$hsid-wrapper";

  $output .= theme(
    'form_element',
    array(
      '#title' => $element['#title'],
      '#description' => $element['#description'],
      '#id' => $element['#id'],
      '#required' => $element['#required'],
      '#error' => $element['#error'],
    ),
    '<div '. drupal_attributes($element['#attributes']) .'>'. $element['#children'] .'</div>'
  );

  return $output;
}

/**
 * Format the container for all selects in the hierarchical select.
 *
 * @param $element
 *   An associative array containing the properties of the element.
 * @return
 *   A themed HTML string representing the form element.
 */
function theme_hierarchical_select_selects_container($element) {
  $output = '';
  $output .= '<div class="hierarchical-select clear-block">';
  $output .= drupal_render($element);
  $output .= '</div>';
  return $output;
}

/**
 * Format a select in the .hierarchial-select div: prevent it from being
 * wrapped in a div. This simplifies the CSS and JS code.
 *
 * @param $element
 *   An associative array containing the properties of the element.
 * @return
 *   A themed HTML string representing the form element.
 */
// TODO: check if this has changed in D6.
function theme_hierarchical_select_select($element) {
  $select = '';
  $size = $element['#size'] ? ' size="'. $element['#size'] .'"' : '';
  _form_set_class($element, array('form-select'));
  $multiple = isset($element['#multiple']) && $element['#multiple'];
  return '<select name="'. $element['#name'] .''. ($multiple ? '[]' : '') .'"'. ($multiple ? ' multiple="multiple" ' : '') . drupal_attributes($element['#attributes']) .' id="'. $element['#id'] .'" '. $size .'>'. _hierarchical_select_options($element) .'</select>';
}

/**
 * Format a special option in a Hierarchical Select select. For example the
 * "none" option or the "create new item" option. This theme function allows
 * you to change how a special option is indicated textually.
 *
 * @param $option
 *   A special option.
 * @return
 *   A textually indicated special option.
 */
function theme_hierarchical_select_special_option($option) {
  return '<'. $option .'>';
}


/**
 * Format a textfield in the .hierarchial-select div: prevent it from being
 * wrapped in a div. This simplifies the CSS and JS code.
 *
 * @param $element
 *   An associative array containing the properties of the element.
 * @return
 *   A themed HTML string representing the form element.
 */
// TODO: check if this has changed in D6.
function theme_hierarchical_select_textfield($element) {
  $size = $element['#size'] ? ' size="'. $element['#size'] .'"' : '';
  $class = array('form-text');
  $extra = '';
  $output = '';

  if ($element['#autocomplete_path']) {
    drupal_add_js('misc/autocomplete.js');
    $class[] = 'form-autocomplete';
    $extra =  '<input class="autocomplete" type="hidden" id="'. $element['#id'] .'-autocomplete" value="'. check_url(url($element['#autocomplete_path'], NULL, NULL, TRUE)) .'" disabled="disabled" />';
  }
  _form_set_class($element, $class);

  if (isset($element['#field_prefix'])) {
    $output .= '<span class="field-prefix">'. $element['#field_prefix'] .'</span> ';
  }

  $output .= '<input type="text" maxlength="'. $element['#maxlength'] .'" name="'. $element['#name'] .'" id="'. $element['#id'] .'" '. $size .' value="'. check_plain($element['#value']) .'"'. drupal_attributes($element['#attributes']) .' />';

  if (isset($element['#field_suffix'])) {
    $output .= ' <span class="field-suffix">'. $element['#field_suffix'] .'</span>';
  }

  return $output . $extra;
}

/**
 * Forms API theming callback for the dropbox. Renders the dropbox as a table.
 *
 * @param $element
 *   An element for which the #theme property was set to this function.
 * @return
 *   A themed HTML string.
 */
function theme_hierarchical_select_dropbox_table($element) {
  $output = '';


  $title     = $element['title']['#value'];
  $separator = $element['separator']['#value'];
  $is_empty  = $element['is_empty']['#value'];

  $separator_html = '<span class="hierarchical-select-item-separator">'. $separator .'</span>';

  $output .= '<div class="dropbox">';
  $output .= '<table>';
  $output .= '<caption class="dropbox-title">'. $title .'</caption>';
  $output .= '<tbody>';

  if (!$is_empty) {
    // Each lineage in the dropbox corresponds to an entry in the dropbox table.
    $lineage_count = count(element_children($element['lineages']));
    for ($x = 0; $x < $lineage_count; $x++) {
      $db_entry = $element['lineages'][$x];
      $zebra = $db_entry['#zebra'];
      $first = $db_entry['#first'];
      $last  = $db_entry['#last'];
      // The deepest level is the number of child levels minus one. This "one"
      // is the element for the "Remove" checkbox.
      $deepest_level = count(element_children($db_entry)) - 1;

      $output .= '<tr class="dropbox-entry '. $first .' '. $last .' '. $zebra .'">';
      $output .= '<td>';
      // Each item in a lineage is separated by the separator string.
      for ($depth = 0; $depth < $deepest_level; $depth++) {
        $output .= drupal_render($db_entry[$depth]);

        if ($depth < $deepest_level - 1) {
          $output .= $separator_html;
        }
      }
      $output .= '</td>';
      $output .= '<td class="dropbox-remove">'. drupal_render($db_entry['remove']) .'</td>';
      $output .= '</tr>';
    }
  }
  else {
    $output .= '<tr class="dropbox-entry first last dropbox-is-empty"><td>';
    $output .= t('Nothing has been selected.');
    $output .= '</td></tr>';
  }

  $output .= '</tbody>';
  $output .= '</table>';
  $output .= '</div>';

  return $output;
}

/**
 * Themeing function to render the level_labels settings as a table.
 */
// TODO: rename $form to $element for consistency (and update hook_theme() after that), make the comment consistent.
function theme_hierarchical_select_common_config_form_level_labels($form) {
  // Recover the stored strings.
  $strings = $form['#strings'];

  $output = '';
  $header = array(t('Level'), t('Label'));
  $rows = array();

  $output .= drupal_render($form['status']);

  $output .= '<div class="level-labels-settings">';
  if (count(element_children($form['labels']))) {
    foreach (element_children($form['labels']) as $depth) {
      $row = array();
      $row[]['data'] = ($depth == 0) ? t('Root level') : t('Sublevel !depth', array('!depth' => $depth));
      $row[]['data'] = drupal_render($form['labels'][$depth]);
      $rows[] = $row;
    }

    // Render the table.
    $output .= theme('table', $header, $rows, array('style' => 'width: auto;'));
  }
  else {
    // No levels exist yet in the hierarchy!
    $output .= '<p><strong>';
    $output .= t('There are no levels yet in this !hierarchy!', array('!hierarchy' => $strings['hierarchy']));
    $output .= '</strong></p>';
  }
  $output .= '</div>';

  // Render the remaining form items.
  $output .= drupal_render($form);

  return $output;
}

/**
 * Themeing function to render the per-level editability settings as a table,
 * (these are the item_types and allowed_levels settings).
 */
// TODO: rename $form to $element for consistency (and update hook_theme() after that), make the comment consistent.
function theme_hierarchical_select_common_config_form_editability($form) {
  // Recover the stored strings.
  $strings = $form['#strings'];

  $output = '';
  $header = array(t('Level'), t('Allow'), t('!item_type', array('!item_type' => drupal_ucfirst($strings['item_type']))));
  $rows = array();

  $output .= drupal_render($form['status']);

  $output .= '<div class="editability-per-level-settings">';
  if (count(element_children($form['item_types']))) {
    foreach (element_children($form['item_types']) as $depth) {
      $row = array();
      $row[]['data'] = ($depth == 0) ? t('Root level') : t('Sublevel !depth', array('!depth' => $depth));
      $row[]['data'] = drupal_render($form['allowed_levels'][$depth]);
      $row[]['data'] = drupal_render($form['item_types'][$depth]);
      $rows[] = $row;
    }

    // Render the table and description.
    $output .= theme('table', $header, $rows, array('style' => 'width: auto;'), '<em>'. t('Per-level settings for creating new !items.', array('!items' => $strings['items'])));
    $output .= '<div class="description">';
    $output .= t(
      'The %item_type you enter for each level is what will be used in
      each level to replace a "&lt;create new item&gt;" option with a
      "&lt;create new %item_type&gt;" option, which is often more
      intuitive.',
      array(
        '%item_type' => $strings['item_type'],
      )
    );
    $output .= '</div>';
  }
  else {
    // No levels exist yet in the hierarchy!
    $output .= '<p><strong>';
    $output .= t('There are no levels yet in this !hierarchy!', array('!hierarchy' => $strings['hierarchy']));
    $output .= '</strong></p>';
  }
  $output .= '</div>';

  // Render the remaining form items.
  $output .= drupal_render($form);

  return $output;
}

/**
 * @} End of "ingroup themeable".
 */


//----------------------------------------------------------------------------
// Private functions.

/**
 * This is an altered clone of form_select_options(). The reason: I need to be
 * able to set a class on an option element if it contains a level label, to
 * allow for level label styles.
 * TODO: rename to _hierarchical_select_select_options().
 */
// TODO: check if this has changed in D6.
function _hierarchical_select_options($element) {
  if (!isset($choices)) {
    $choices = $element['#options'];
  }
  // array_key_exists() accommodates the rare event where $element['#value'] is NULL.
  // isset() fails in this situation.
  $value_valid = isset($element['#value']) || array_key_exists('#value', $element);
  $value_is_array = is_array($element['#value']);
  $options = '';
  foreach ($choices as $key => $choice) {
    $key = (string)$key;
    if ($value_valid && (!$value_is_array && (string)$element['#value'] === $key || ($value_is_array && in_array($key, $element['#value'])))) {
      $selected = ' selected="selected"';
    }
    else {
      $selected = '';
    }

    // If an option DOES NOT have child info, then it's a special option:
    // - label_\d+ (level label)
    // - none ("<none>")
    // - create_new_item ("<create new item>")
    // Only when it's a level label, we have to add a class to this option.
    if (!isset($element['#childinfo'][$key])) {
      $class = (preg_match('/label_\d+/', $key)) ? ' level-label' : '';
    }
    else {
      $class = ($element['#childinfo'][$key] == 0) ? 'has-no-children' : 'has-children';
    }

    $options .= '<option value="'. check_plain($key) .'" class="'. $class .'"'. $selected .'>'. check_plain($choice) .'</option>';
  }
  return $options;
}
