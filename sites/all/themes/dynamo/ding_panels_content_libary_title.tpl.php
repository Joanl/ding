  <div class="picture">
    <?php if($node->field_image['0']['filepath']){ ?>
      <div class="picture-inner">
      <?php print theme('imagecache', '680_200_crop', $node->field_image['0']['filepath']); ?>      
      </div>
    <?php } ?>
  </div>
  <h1><?php print $library_title; ?></h1>
  <?php  print $library_navigation; ?>
