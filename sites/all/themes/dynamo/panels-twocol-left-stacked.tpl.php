<!--panels-twocol-left-stacked.tpl.php-->
<div id="twocol-left">

  <?php if (!empty($content['top'])): ?>
    <div id="twocol-left-top">
      <?php print $content['top']; ?>
    </div>
  <?php endif; ?>

  <div id="twocol-left-left">
    <?php print $content['left']; ?>      
  </div>


  <?php if (!empty($content['bottom'])): ?>
    <div id="twocol-bottom">
    <?php print $content['bottom']; ?>        
    </div>
  <?php endif; ?>


</div>

<div id="twocol-right">
  <?php if (!empty($content['right'])): ?>
    <?php print $content['right']; ?>
  <?php endif; ?>
</div>  


<!--/panels-twocol-left-stacked.tpl.php-->