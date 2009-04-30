<?php // $Id$

/**
 * @file draggable_checkboxes_element.tpl.php
 * Default theme implementation for draggable checkboxes.
 *
 * Available variables:
 * - $table_id: The id of the table tag, used by tabledrag.js
 * - $checkboxes: An array of the rendered checkboxes keyed by nid.
 * - $element: The full form API element array.
 *
 * Each $node_listing[$region] contains an array of blocks for that region.
 */
?>
<table id="<?php print $table_id; ?>" class="draggable-checkboxes">
  <tbody>
<?php foreach($checkboxes as $nid => $checkbox): ?>
    <tr class="draggable node-<?php print $nid; ?>">
      <?php print $checkbox; ?>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>

