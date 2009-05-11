<?php
//dsm($fields);
?>

<div class="subject"><?php print $fields['tid']->content; ?> </div>
<h2><?php print $fields['title']->content; ?></h2>
<div class="meta">
  <ul>
    <li><?php print $fields['field_library_ref_nid']->content; ?></li>
  </ul>
  
  <span class="time"><?php print $fields['created']->content; ?></span>
  af <?php print $fields['name']->content; ?>  
  <?php 
    if($fields['comment_count']->raw >= "1"){
      print "(". $fields['comment_count']->content .")";
    }  
  ?>

  <?php print $fields['edit_node']->content; ?>
</div>
<p>
  <?php print $fields['field_teaser_value']->content; ?>  
  
  <?php print $fields['body']->content; ?>    
  
  <span class="more-link"><?php print $fields['view_node']->content; ?></span>
</p>
