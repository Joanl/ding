<?php
/* =====================================
  Dynamo
  template.php
* ------------------------------------- */
drupal_rebuild_theme_registry(); /*TODO: add a theme setting for this*/


function dynamo_office_hours_format_day($name, $values) {
  $output = '<div>' . $name;
  foreach ($values as $val) {
    $output .= ' <span class="hours start">' . _office_hours_format_time($val['start']) . '</span>';
    $output .= ' – <span class="hours end">' . _office_hours_format_time($val['end']) . '</span>';
  }
  return $output . '</div>';
}