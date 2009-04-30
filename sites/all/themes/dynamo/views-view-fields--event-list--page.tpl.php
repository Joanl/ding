<?php 
  //converts the date value to time
  $date = strtotime($fields['field_datetime_value']->raw);
?>

<div class="clearfix">
  <div class="picture">
    <?php print $fields['field_image_fid']->content; ?>  
  </div>
  <div class="info">
    <h2><?php print $fields['title']->content; ?></h2>

    <span class="time"><?php print date("l j M h:i", $date); ?> </span>
    <span class="price"><?php print $fields['field_entry_price_value']->content; ?></span>
    <span class="libary-tag"><?php print $fields['field_library_ref_nid']->content; ?></span>
    
    <p><?php print $fields['body']->content; ?></p>
    

    <?php print $fields['edit_node']->content; ?>  
  </div>
</div>  
