  <div id="threecol-left">

    <?php if (!empty($content['top'])): ?>
      <div id="threecol-left-top">
        <?php print $content['top']; ?>
      </div>
    <?php endif; ?>

    <div id="threecol-left-left">
      <?php print $content['left']; ?>      
    </div>

    <div id="threecol-left-middle">
      <?php print $content['middle']; ?>        
    </div>
  
  </div>

  <div id="threecol-right">

    <?php if (!empty($content['right'])): ?>
      <?php print $content['right']; ?>
    <?php endif; ?>

    <?php if (!empty($content['bottom'])): ?>
      <div id="threecol-right-bottom">
      <?php print $content['bottom']; ?>        
      </div>
    <?php endif; ?>

  </div>  

