<?php
 if($node->nid =="1" ){
//   dsm($node);	   
 }

 
 ?>	
<?php  //dsm(get_defined_vars());  ?> 
<?php //print $FIELD_NAME_rendered ?>
<?php if ($page == 0){ ?>

<div class="clearfix">
  <div class="picture">
    <?php print $field_image_rendered; ?>
  </div>
  <div class="info">
    

    <div class="libary-status <?php print $node->field_opening_hours_processed['status'];?>">
        <?php print t($node->field_opening_hours_processed['status']);?>
      </div>


  	<?php if($node->title){	?>	
      <h3><?php print l($node->title, 'biblioteker/'.$node->nid); ?>...</h3>
  	<?php } ?>
    
      <?php print $node->locations['0']['street'];?><br/> 
      <?php print $node->locations['0']['city'];?>  <?php print $node->locations['0']['postal_code'];?>
      <br/><br/>
      tlf:<?php print $node->locations['0']['phone'];?><br/>        
      fax: <?php print $node->locations['0']['fax'];?><br/>
      E-mail: <?php print $node->field_email['0']['view'];?><br/>

  </div>

    <?php print $node->field_opening_hours['0']['view'];?>
</div>

<?php }else{ 
//Content
?>
<div class="<?php print $classes ?>">

	<h1><?php print $title;?></h1>
		
	<div class="meta">
  	<?php if ($picture) { ;?>
			<span class="author-picture">
		  		<?php print $picture; ?>  
			</span>
		<?php } ?>


		<span class="time">
			<?php print format_date($node->created, 'custom', "j F Y") ?> 
		</span>	
		<span class="author">
			af <?php print theme('username', $node); ?>
		</span>	



		<?php if (count($taxonomy)){ ?>
		  <div class="taxanomy">
	   	  <?php print $terms ?> 
		  </div>  
		<?php } ?>
	</div>

	<div class="content">
		<?php print $content ?>
	</div>
		
	<?php if ($links){ ?>
    <?php  print $links; ?>
	<?php } ?>
</div>
<?php } ?>