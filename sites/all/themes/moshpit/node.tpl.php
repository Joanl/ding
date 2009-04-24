<?php // krumo($node);	?>	
<?php // krumo($node->content);	?>	
<?php // print_r(get_defined_vars());  ?> 
<?php //print $FIELD_NAME_rendered ?>
<?php if ($page == 0){ ?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes ?>">

	<?php if($node->title){	?>	
    <h2><?php print l($node->title, 'node/'.$node->nid); ?></h2>
	<?php } ?>

	<div class="meta">

    <?php
      if($node->picture){
        $image = theme('imagecache', 'user-thumbnail', $node->picture); 
        print l($image, 'user/'.$node->uid, $options= array('html'=>TRUE));
      }
    ?>

		<span class="author">
			<?php print theme('username', $node); ?>
		</span>	

		<span class="date">
			<?php print format_date($node->created, 'custom', "j F Y") ?> 
		</span>	

    <?php if($node->comment_count){ ?>
  		<span class="comments">
        <?php print $node->comment_count; ?> comments
  		</span>  
    <?php } ?>
	</div>

	<div class="content">
		<?php  print $content;?>	
  </div>

</div>
<?php }else{ 
//Content
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes ?> clearfix">

	<h1><?php print $title;?></h1>
		
	<div class="meta">
  	<?php if ($picture) { ;?>
			<span class="author-picture">
		  		<?php print $picture; ?>  
			</span>
		<?php } ?>

		<span class="author">
			<?php print theme('username', $node); ?>
		</span>	

		<span class="date">
			<?php print format_date($node->created, 'custom', "j F Y") ?> 
		</span>	

		<?php if (count($taxonomy)){ ?>
		  <div class="taxanomy">
	   	  <?php print $terms ?> 
		  </div>  
		<?php } ?>
	</div>

	<div class="content">
		<?php print $content ?>
  	<?php print $node_region_two;?>	
  	<?php print $node_region_one;?>
	</div>
		
	<?php if ($links){ ?>
    <?php  print $links; ?>
	<?php } ?>
</div>
<?php } ?>