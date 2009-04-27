<?php 
  //converts the date value to time
  $date = strtotime($fields['field_datetime_value']->raw);
?>
<div class="leaf">
  <div class="day"><?php print date("l", $date);?></div>
  <div class="date"><?php print date("j", $date);?></div>
  <div class="month"><?php print date("M", $date);?></div>
</div>

<div class="data">
  <?php print $fields['field_library_ref_nid']->content; ?>
  <h4><?php print $fields['title']->content; ?></h4>
  <?php print date("h:i", $date); ?>  -   <?php print $fields['field_entry_price_value']->content; ?>
</div>  









