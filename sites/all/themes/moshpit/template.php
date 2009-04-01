<?php
// Auto-rebuild the theme registry during theme development.
drupal_rebuild_theme_registry(); /*TODO: add a theme setting for this*/
/* =====================================
  General functions
* ------------------------------------- */
function zen_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  // If the first character is not a-z, add 'n' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id' . $string;
  }
  return $string;
}

/* =====================================
  preprocess
* ------------------------------------- */
function moshpit_preprocess_page(&$vars, $hook) {
  // Define the content width
//  $vars['column_left_classes'] = $vars['right'] ? 'grid-8' : 'grid-12';
  // Add HTML tag name for title tag.
  $vars['site_name_element'] = $vars['is_front'] ? 'h1' : 'div';


  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  $body_classes = array($vars['body_classes']);
  if (!$vars['is_front']) {
    // Add unique classes for each page and website section
    $path = drupal_get_path_alias($_GET['q']);
    list($section, ) = explode('/', $path, 2);
    $body_classes[] = zen_id_safe('page-' . $path);
    $body_classes[] = zen_id_safe('section-' . $section);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-add'; // Add 'section-node-add'
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-' . arg(2); // Add 'section-node-edit' or 'section-node-delete'
      }
    }
  }

  $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces
  
}

function moshpit_preprocess_node(&$vars, $hook) {
  // Special classes for nodes
  $classes =array();

  if ($vars['sticky']) {
    $classes[] = 'sticky';
  }
  if (!$vars['status']) {
    $classes[] = 'node-unpublished';
    $vars['unpublished'] = TRUE;
  }
  else {
    $vars['unpublished'] = FALSE;
  }
  //teaser or node
  if ($vars['teaser']) {
    $classes[] = 'node-teaser';
  }else{
    $classes[] = 'node';
  }
  // Class for node type: "node-page", "node-story"
  $classes[] = 'node-' . $vars['type'];
  
  $vars['classes'] = implode(' ', $classes);

  //Add regions to a node
  if ($vars['page'] == TRUE) {
    $vars['node_top'] = theme('blocks', 'node_top');
    $vars['node_bottom'] = theme('blocks', 'node_bottom');
  }

}

function moshpit_preprocess_block(&$vars, $hook) {
  $block = $vars['block'];
  // classes for blocks.
  $classes = array('block');
  $classes[] = 'block-' . $block->module;
  $classes[] = $vars['zebra'];

  $vars['edit_links_array'] = array();
  $vars['edit_links'] = '';
  if (user_access('administer blocks')) {
    include_once './' . drupal_get_path('theme', 'moshpit') . '/template.block-editing.inc';
    zen_preprocess_block_editing($vars, $hook);
    $classes[] = 'with-block-editing';
  }
  // Render block classes.
  $vars['classes'] = implode(' ', $classes);
}

/*views*/
function moshpit_preprocess_views_view_list(&$vars){
  moshpit_preprocess_views_view_unformatted($vars);  
}

  function moshpit_preprocess_views_view_unformatted(&$vars) {
  $view     = $vars['view'];
  $rows     = $vars['rows'];

  $vars['classes'] = array();
  // Set up striping values.
  foreach ($rows as $id => $row) {
  //  $vars['classes'][$id] = 'views-row-' . ($id + 1);
  //    $vars['classes'][$id] .= ' views-row-' . ($id % 2 ? 'even' : 'odd');
    if ($id == 0) {
      $vars['classes'][$id] .= ' first';
    }
  }
  $vars['classes'][$id] .= ' last';
  }


/* =====================================
  Breadcrumb
* ------------------------------------- */
function moshpit_preprocess(&$variables, $hook) {
    //Make active page title in breadcrumbs 
    if(!empty($variables['breadcrumb'])) $variables['breadcrumb'] = '<ul class="breadcrumb">'.$variables['breadcrumb'].'<li>: '.$variables['title'].'</li></ul>';
}

/*changes the home title to the sitename*/
function moshpit_breadcrumb($breadcrumb) {
  GLOBAL $base_path;
  if (strip_tags($breadcrumb[0]) == "Home") {
    $breadcrumb[0] ='<a href="'.$base_path.'">'.variable_get(site_name,'').'</a></li>';
  }

  if (!empty($breadcrumb)) {
    return '<li>'. implode('/</li><li>', $breadcrumb) .'</li>';
  }
}

/* =====================================
  Forms 
* ------------------------------------- */
function moshpit_form($element) {
  $action = $element['#action'] ? 'action="'. check_url($element['#action']) .'" ' : '';
  return '<form '. $action .' accept-charset="UTF-8" method="'. $element['#method'] .'" id="'. $element['#id'] .'"'. drupal_attributes($element['#attributes']) .">\n". $element['#children'] ."\n</form>\n";
}

function phptemplate_form_element($element, $value) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();
  $output = '<div>';
  //  removed $output = '<div class="form-item"';
//  $output = '<div ';
  // removed the ID wrapper
   if (!empty($element['#id'])) {
 //   $output .= ' id="'. $element['#id'] .'-wrapper"';
   }
//  $output .= ">\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="'. $element['#id'] .'">'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    else {
      $output .= ' <label>'. $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
  }

  $output .= " $value\n";

  if (!empty($element['#description'])) {
    $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

function phptemplate_file($element) {
  _form_set_class($element, array('form-file'));
  return theme('form_element', $element, '<input type="file" name="'. $element['#name'] .'"'. ($element['#attributes'] ? ' '. drupal_attributes($element['#attributes']) : '') .' id="'. $element['#id'] .'" size="20" />');
}

function phptemplate_checkbox($element) {
  _form_set_class($element, array('form-checkbox'));
  $checkbox = '<input ';
  $checkbox .= 'type="checkbox" ';
  $checkbox .= 'name="'. $element['#name'] .'" ';
  $checkbox .= 'id="'. $element['#id'] .'" ' ;
  $checkbox .= 'value="'. $element['#return_value'] .'" ';
  $checkbox .= $element['#value'] ? ' checked="checked" ' : ' ';
  $checkbox .= drupal_attributes($element['#attributes']) .' />';

  if (!is_null($element['#title'])) {
    $checkbox = '<label class="option" for="'. $element['#id'] .'">'. $checkbox .' '. $element['#title'] .'</label>';
  }

  unset($element['#title']);
  return theme('form_element', $element, $checkbox);
}

function phptemplate_button($element) {
  // Override theme_button adss spans around it so we can tweak the shit ouuta it
  //http://teddy.fr/blog/beautify-your-drupal-forms
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'];
  }

  // We here wrap the output with a couple span tags
  return '<span class="button"><span><input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ')  .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." /></span></span>\n";
}

/* =====================================
  Clean up
* ------------------------------------- */
//filter tips http://drupal.org/node/215653
function phptemplate_filter_tips($tips, $long = FALSE, $extra = '') {
  return '';
}
function phptemplate_filter_tips_more_info () {
  return '';
}