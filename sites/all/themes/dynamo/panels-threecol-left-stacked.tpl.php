<?php
// $Id$

/**
 * @file panels_threecol_left_stacked.tpl.php
 * Template for a 3 column panel where the left and middle columns are
 * stacked with top and bottom rows.
 *
 * This template provides a three column 50%-25%-25% panel display layout, with
 * additional areas for the top and the bottom.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['top']: Content in the top row.
 *   - $content['left']: Content in the left column.
 *   - $content['middle']: Content in the middle column.
 *   - $content['right']: Content in the right column.
 *   - $content['bottom']: Content in the bottom row.
 */
?>
<div class="" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="leftcontent left ">
  
    <?php if (!empty($content['top'])): ?>
      <div class="top test">
        <?php print $content['top']; ?>
      </div>
    <?php endif; ?>
  
    <?php if (!empty($content['left'])): ?>
    <div id="left">
      <?php print $content['left']; ?>      
    </div>
    <?php endif; ?>

    <?php if (!empty($content['middle'])): ?>
      <div id="middle">
      <?php print $content['middle']; ?>        
      </div>

    <?php endif; ?>

    <?php if (!empty($content['bottom'])): ?>
      <div id="bottom">
      <?php print $content['bottom']; ?>        
      </div>

    <?php endif; ?>

  
  </div>
  <div class="rightcontent left test">

    <?php if (!empty($content['right'])): ?>
      <?php print $content['right']; ?>
    <?php endif; ?>


  </div>  
</div>

