<?php
/* =====================================
  Dynamo
  template.php
* ------------------------------------- */
drupal_rebuild_theme_registry(); /*TODO: add a theme setting for this*/


/**
* Implementation of hook_theme().
*/
function dynamo_theme($existing, $type, $theme, $path) {
 return array(
   'ding_panels_content_library_title' => array(
     'template' => 'ding_panels_content_libary_title',
   ),
   'ding_panels_content_library_location' => array(
     'template' => 'ding_panels_content_libary_location',
   ),
 );
}


function dynamo_preprocess_views_view_list(&$vars){
  dynamo_preprocess_views_view_unformatted($vars);  
}

  function dynamo_preprocess_views_view_unformatted(&$vars) {
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


/*
* panels
*/
function dynamo_panels_pane($content, $pane, $display) {
  if (!empty($content->content)) {
    $idstr = $classstr = '';
    if (!empty($content->css_id)) {
      $idstr = ' id="' . $content->css_id . '"';
    }
    if (!empty($content->css_class)) {
      $classstr = ' ' . $content->css_class;
    } 
    //  $output = "<div class=\"panel-pane $classstr\"$idstr>\n";
    $output = "<div class=\"pane-$pane->subtype\">\n";
    if (user_access('view pane admin links') && !empty($content->admin_links)) {
      $output .= "<div class=\"admin-links panel-hide\">" . theme('links', $content->admin_links) . "</div>\n";
    }
    if (!empty($content->title)) {
      $output .= "<h3>$content->title</h3>\n";
    }

    if (!empty($content->feeds)) {
      $output .= "<div class=\"feed\">" . implode(' ', $content->feeds) . "</div>\n";
    }

    //  $output .= "<div class=\"content\">$content->content</div>\n";
    $output .= $content->content;

    if (!empty($content->links)) {
      $output .= "<div class=\"links\">" . theme('links', $content->links) . "</div>\n";
    }

    if (!empty($content->more)) {
      if (empty($content->more['title'])) {
        $content->more['title'] = t('more');
      }
      $output .= "<div class=\"panels more-link\">" . l($content->more['title'], $content->more['href']) . "</div>\n";
    }

    $output .= "</div>\n";
    return $output;
  }
}


function dynamo_panels_default_style_render_panel($display, $panel_id, $panes, $settings) {
  $output = '';

  $print_separator = FALSE;
  foreach ($panes as $pane_id => $content) {
    // Add the separator if we've already displayed a pane.
    if ($print_separator) {
     // $output .= '<div class="panel-separator"></div>';
    }
    $output .= $text = panels_render_pane($content, $display->content[$pane_id], $display);

    // If we displayed a pane, this will become true; if not, it will become
    // false.
    $print_separator = (bool) $text;
  }

  return $output;
}
