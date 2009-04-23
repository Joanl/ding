<?php
// $Id$

/**
 * @file ding_panels_content_libary_location.tpl.php
 * Library location, map, etc.
 */

/** 
 * The address, etc. are marked up to conform to the hCard microformat.
 * http://microformats.org/wiki/hcard for more information.
 */
?>
foooo
<div class="vcard">
  <span class="fn org"><?php print $node->title; ?></span>
  <div class="adr">
    <div class="street-address"><?php print $node->location['street']; ?></div>
    <span class="postal-code"><?php print $node->location['postal_code']; ?></span>
    <span class="locality"><?php print $node->location['city']; ?></span>
    <div class="country-name"><?php print $node->location['country_name']; ?></div>
  </div>
  <div class="tel">
    <span class="type"><?php print t('Phone'); ?></span> <?php print $node->location['phone']; ?>
  </div>
  <div class="tel">
    <span class="type"><?php print t('Fax'); ?></span> <?php print $node->location['fax']; ?>
  </div>
</div>

<hr/>
<?php print $library_map; ?>
fooo