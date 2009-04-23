  <div id="biblo-left" class="">
  
    <?php if (!empty($content['top'])): ?>
      <div class="">
        <?php print $content['top']; ?>
      </div>
    <?php endif; ?>
  

    <?php if (!empty($content['left'])): ?>
    <div id="biblo-content">
      <?php print $content['left']; ?>      
    </div>
    <?php endif; ?>

    <?php if (!empty($content['middle'])): ?>
      <div id="biblo-events">
      <?php print $content['middle']; ?>        
      </div>
    <?php endif; ?>
  
  </div>


  <div id="biblo-right" class="">

    <?php if (!empty($content['right'])): ?>
      <?php print $content['right']; ?>
    <?php endif; ?>

  </div>  

  <?php if (!empty($content['bottom'])): ?>
    <div id="bottom">
    <?php print $content['bottom']; ?>        
    </div>
  <?php endif; ?>

