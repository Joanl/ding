<div class="panel-display panel-3col-left-stacked-right clear-block" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
<?php if (!empty($content['right'])): ?>
  <div class="panel-col right">
    <div class="inside"><?php print $content['right']; ?></div>
  </div>
<?php endif; ?>

<?php if (!empty($content['top']) || !empty($content['left']) || !empty($content['middle']) || !empty($content['bottom'])): ?>
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


  <?php if (!empty($content['middle'])): ?>
    <div class="panel-col middle">
      <div class="inside"><?php print $content['middle']; ?></div>
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

