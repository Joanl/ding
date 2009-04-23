  <div id="three-col-left">
  
    <?php if (!empty($content['top'])): ?>
      <div class="top">
        <?php print $content['top']; ?>
      </div>
    <?php endif; ?>

    <div id="left">
      <?php print $content['left']; ?>      
    </div>

    <div id="middle">
      <h3>arrangementer</h3>
      <?php print $content['middle']; ?>        
    </div>
  
  </div>


  <div id="three-col-right">

    <?php if (!empty($content['right'])): ?>
      <?php print $content['right']; ?>
    <?php endif; ?>

    <?php if (!empty($content['bottom'])): ?>
      <div id="bottom">
      <?php print $content['bottom']; ?>        
      </div>
    <?php endif; ?>

  </div>  

