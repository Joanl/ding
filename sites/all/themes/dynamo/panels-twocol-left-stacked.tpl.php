<?php
// $Id$

/**
 * @file panels_threecol_left_stacked.tpl.php
 * Template for a 3 column panel where the left column is stacked with 
 * top and bottom rows.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['top']: Content in the top row.
 *   - $content['left']: Content in the left column.
 *   - $content['right']: Content in the right column.
 *   - $content['bottom']: Content in the bottom row.
 */
?>
<div class="panel-display panel-2col-left-stacked clear-block" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
<?php if (!empty($content['right'])): ?>
  <div class="panel-col right">
    <div class="inside"><?php print $content['right']; ?></div>
  </div>
<?php endif; ?>

<?php if (!empty($content['top']) || !empty($content['left']) || !empty($content['bottom'])): ?>
  <div class="left-wrapper">

  <?php if (!empty($content['top'])): ?>
    <div class="panel-col top">
      <div class="inside"><?php print $content['top']; ?></div>
    </div>
  <?php endif; ?>

  <?php if (!empty($content['left'])): ?>
    <div class="panel-col left">
      <div class="inside"><?php print $content['left']; ?></div>
    </div>
  <?php endif; ?>

  <?php if (!empty($content['bottom'])): ?>
    <div class="panel-col bottom">
      <div class="inside"><?php print $content['bottom']; ?></div>
    </div>
  <?php endif; ?>
  </div>
</div>
<?php endif; ?>

