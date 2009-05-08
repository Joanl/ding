<?php
/*
  TODO ja det er så ren dummy data...
*/
?>
<!--panels-threecol-33-34-33-stacked.tpl.php-->
<div id="front-top">
  <ul id="frontpagecarousel" class="jcarousel-skin-biblo">
    <li><img src="<?php print path_to_theme();?>/images/test-carousel-1.jpg" width="895" height="183" alt="Test Carousel 1" /></li>
    <li><img src="<?php print path_to_theme();?>/images/test-carousel-2.jpg" width="895" height="183" alt="Test Carousel 1" /></li>
    <li><img src="<?php print path_to_theme();?>/images/test-carousel-3.jpg" width="895" height="183" alt="Test Carousel 1" /></li>
    <li><img src="<?php print path_to_theme();?>/images/test-carousel-4.jpg" width="895" height="183" alt="Test Carousel 1" /></li>    
  </ul>

  <ul id="frontpagecarousel-controller">
    <li class="active">Alle</li>
    <li><a href="#">Romaner</a></li>
    <li><a href="#">Fagbøger</a></li>
    <li><a href="#">Musik</a></li>
    <li><a href="#">Film</a></li>
  </ul>

  <?php // print $content['top']; ?>  
</div>
<div id="front-left">
    <?php print $content['left']; ?>  
</div>
<div id="front-middle">
    <?php print $content['middle']; ?>  
</div>
      
<div id="front-right">
    <?php print $content['right']; ?>  
</div>

<div id="front-bottom">
    <?php print $content['bottom']; ?>  
</div>
<!-- / panels-threecol-33-34-33-stacked.tpl.php-->