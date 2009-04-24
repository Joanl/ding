<?php // dsm(get_defined_vars()) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<!--
  Dynamo!
-->
<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
</head>
<body class="<?php print $body_classes; ?>">

<div id="container" class="clearfix">


    <div id="page" class="minheight">
      <div id="page-inner" class="clearfix">

        <<?php print $site_name_element; ?> id="site-name">
          <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home">
            <?php print $site_name; ?>
          </a>
        </<?php print $site_name_element; ?>>


        <div id="pageheader" class="">
          <div id="pageheader-inner">
            
            <div id="top" class="clearfix">

              <div id="search" class="left">
                <?php print $search ?>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
              </div>

              <div id="account" class="left">
                <?php print $account ?>
              </div>  
            </div>

        		<div id="navigation" class="">
        			<div id="navigation-inner">
                <?php if ($primary_links){ ?>
                  <?php print theme('links', $primary_links); ?>
                <?php } ?>
              </div>
            </div>

            <?php if ($breadcrumb){ ?>
          		<div id="path">
          		  Her er du: <?php print $breadcrumb; ?> 
              </div>
            <?php } ?>

          </div>
        </div>
        
        <div id="pagebody" class="clearfix">
          <div id="pagebody-inner" class="clearfix">

            <?php if ($left) { ?>
              <div id="content-left">
                <?php print $left; ?>
              </div>
            <?php } ?>

          	<div id="content">
              <div id="content-inner">

            		<?php if ($help OR $messages OR $tabs) { ?>
            			<div id="drupal-messages">
            			  <div id="drupal-messages-inner">
                  	  <?php print $help ?>
                  	  <?php print $messages ?>
                    </div>
            			</div>
            		<?php } ?>

                <?php if ($content_top) { ?>
                  <?php print $content_top; ?>
                <?php } ?>

                <?php if ($title){ ?>
                  <h1><?php print $title; ?></h1>
                <?php } ?>
                
                <?php print $content; ?>

                <?php if ($content_bottom) { ?>
                  <?php print $content_bottom; ?>
                <?php } ?>

                <?php if ($tabs){ ?>
                  <div class="tabs"><?php print $tabs; ?></div>
                <?php }; ?>

             
              </div>
          	</div>

            <?php if ($right) { ?>
              <div id="content-right">
                <?php print $right; ?>
              </div>
            <?php } ?>

          </div>
        </div>

        <div id="pagefooter" class="">
          <div id="pagefooter-inner" class="clearfix">

            <div class="left first">
              <?php print $footer_one; ?>
              footer Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.  
            </div>

            <div class="left">
              <?php print $footer_two; ?>
              footer Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.    
            </div>

            <div class="left">
              <?php print $footer_three; ?>              
              footer Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.    
            </div>

            <div class="left">
              <?php print $footer_four; ?>              
              footer Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.  
            </div>

          	<?php if ($footer_message) { ?>
          	  <?php print $footer_message; ?>
          	<?php } ?>
  
            <?php print $footer; ?>
  
      
          </div>
        </div>

      </div>
    </div>
  

</div>


<?php print $scripts; ?>
<?php print $closure; ?>
</body>
</html>