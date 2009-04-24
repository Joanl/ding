<?php
// $Id: comment.tpl.php,v 1.4.2.1 2008/03/21 21:58:28 goba Exp $

/**
 * @file comment.tpl.php
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: Body of the post.
 * - $date: Date and time of posting.
 * - $links: Various operational links.
 * - $new: New comment marker.
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $submitted: By line with date and time.
 * - $title: Linked title.
 *
 * These two variables are provided for context.
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * @see template_preprocess_comment()
 * @see theme_comment()
 */

/*
<?php if($comment->homepage){ ?>
  homepage <?php print $comment->homepage; ?>
<?php } ?>  

<?php if($comment->mail){ ?>
  mail <?php print $comment->mail; ?>
<?php } ?>  

<?php if($comment->name){ ?>
  <?php print $comment->name; ?>        
<?php } ?>  
    dsm($comment);
*/
?>

<div class="comment<?php print ' '. $status ?>">
	<blockquote>
    <?php if ($comment->new){ ?>
      <h4 class="new"><?php print $title ?></h4>
    <?php }else{ ?>
      <h4><?php print $title ?></h4>
    <?php } ?>

	  <?php print $content ?>
    <?php print $links ?>    
	</blockquote>

  <div class="meta">
    <?php
      if($comment->picture){
        $image = theme('imagecache', 'user-thumbnail', $comment->picture); 
        print l($image, 'user/'.$comment->uid, $options= array('html'=>TRUE));
      }
    ?>
    <span class="author"><?php print $author ?></span> 
	  <span class="date"><?php print $date ?></span>
    <?php if ($signature){ ?>
      <?php print $signature ?>
    <?php } ?>		  
  </div>	
</div>