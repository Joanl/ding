<?php
// $Id: box.tpl.php,v 1.2 2008/09/14 11:56:34 johnalbin Exp $

/**
 * @file box.tpl.php
 *
 * Theme implementation to display a box.
 *
 * Available variables:
 * - $title: Box title.
 * - $content: Box content.
 *
 * @see template_preprocess()
 *
*<?php if ($title){ ?>
*   <h3><?php print $title; ?></h2>
*<?php } ?>
 */
?>

<?php print $content; ?>