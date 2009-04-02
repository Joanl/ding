<?php // krumo($node);	?>	
<?php if ($page == 0){ ?>
<div id="node-<?php print $node->nid; ?>" class="node node-teaser <?php print $classes ?> clearfix">

	<?php if($node->title){	?>	
    <h2 class="title"><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
	<?php } ?>

	<div class="node-meta clearfix">
	  	<?php if ($node->picture) { ;?>
			<span class="user-picture blockElm">
          <?php //print theme('imagecache', 'preset_namespace', $node->picture, $alt, $title, $attributes); ?>
			</span>
		<?php } ?>

		<span class="user-name blockElm">
			<?php print theme('username', $node); ?>
		</span>	

		<span class="date">
			<?php print format_date($node->created, 'custom', "j F Y") ?> 
		</span>	

	</div>

	<div class="content clearfix">
		<?php  print $content;?>	
		<a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print t('read more') ?> - </a>
	</div>

  <?php if ($links){ ?>
    <div class="links">
      <?php print $links; ?>
    </div>
  <?php }; ?>
	  
</div>
	
<?php }else{ 
//Content
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $classes ?> clearfix">

	<h1 class="title"><?php print $title;?></h1>
		
	<div class="node-meta clearfix">
		<?php if ($submitted){ ?>

		  	<?php if ($picture) { ;?>
				<span class="user-picture blockElm">
			  		<?php print $picture; ?>  
				</span>
			<?php } ?>

			<span class="user-name blockElm">
				<?php print theme('username', $node); ?>
			</span>	

			<span class="date">
				<?php print format_date($node->created, 'custom', "j F Y") ?> 
			</span>	

		<?php } ?>


		<?php if (count($taxonomy)){ ?>
			<div class="taxonomy">
			   	<?php print $terms ?> 
			</div>
		<?php } ?>
	</div>

	<div class="content clearfix">

		<?php print $node_top;?>	

		<?php print $content ?>

		<?php print $node_bottom;?>
	</div>
		
	<?php if ($links){ ?>
	    <div class="links">
	      <?php  print $links; ?>
	    </div>
	<?php } ?>

</div>

<?php } ?>