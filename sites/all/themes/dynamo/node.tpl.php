<?php // dsm($node->content);	?>	
<?php  //dsm(get_defined_vars());  ?> 
<?php //print $FIELD_NAME_rendered ?>
<?php if ($page == 0){ ?>
<div class="<?php print $classes ?>">

  	<?php if($node->title){	?>	
      <h2><?php print l($node->title, 'node/'.$node->nid); ?></h2>
  	<?php } ?>

    <?php print $content ?>
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