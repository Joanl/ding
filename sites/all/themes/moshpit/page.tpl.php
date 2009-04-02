<?php // krumo(get_defined_vars()) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<!--
  moshpit theme
	Geek Röyale http://geekroyale.com
	webstuff to the people
-->
<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
</head>
<body class="<?php print $body_classes; ?>">

<div id="container" class="clearfix">
  <div id="container-inner" class="">

    <div id="page" class="pageWidth clearfix">
      <div id="page-inner">

        <div id="pageBody" class="left pageWidth clearfix">
          <div id="pageBody-inner">

          	<div id="content" class="col">
              <div id="content-inner">

            		<?php if ($help OR $messages OR $tabs) { ?>
            			<div id="drupal-messages">
            			  <div id="drupal-messages-inner">
                  	  <?php print $help ?>
                  	  <?php print $messages ?>
                    </div>
            			</div>
            		<?php } ?>

                <?php if ($tabs){ ?>
                  <div class="tabs"><?php print $tabs; ?></div>
                <?php }; ?>

                <?php if ($content_top) { ?>
                  <?php print $content_top; ?>
                <?php } ?>

                <?php if ($title AND (arg(0)=="node" AND is_numeric(arg(1)) AND arg(2)!="")) { /*TODO: moved out to the template.php*/ ?>
                  <h1 class="title"><?php print $title; ?></h1>
                <?php } ?>
                
                <?php print $content; ?>

                <?php if ($content_bottom) { ?>
                  <?php print $content_bottom; ?>
                <?php } ?>
             
              </div>
          	</div>

          	<div id="content2" class="col">
              <div id="content-2-inner">

              	<?php if ($left) { ?>
              	  <?php print $left; ?>
              	<?php } ?>

                <?php if ($search_box){ ?>
                  <div id="searchBox">
                    <div id="searchBox-inner">
                      <?php print $search_box; ?>
                    </div>
                  </div>
                <?php }; ?>

              </div>
          	</div>

          	<div id="content3" class="col">
              <div id="content-3-inner">

              	<?php if ($right) { ?>
              	  <?php print $right; ?>
              	<?php } ?>
        	  
          	  </div>
            </div>


          </div>
        </div>

        <div id="pageHeader" class="left pageWidth clearfix">
          <div id="pageHeader-inner">

            <<?php print $site_name_element; ?> id="site-name" class="grid12-3">
              <a href="<?php print $base_path; ?>" title="<?php print t('Home'); ?>" rel="home">
                <?php print $site_name; ?>
              </a>
            </<?php print $site_name_element; ?>>



        		<div id="navigation">
        			<div id="navigation-primary">
                <?php if ($primary_links){ ?>
                  <?php print theme('links', $primary_links); ?>
                <?php } ?>
        				<?php // print theme('menu_icon', $primary_links); ?>  
            	  <?php
            	  //get a menu & print the sucka
                //    $menu = menu_navigation_links("menu-top");
                //    print theme('links', $menu, array('class' =>'links', 'id' => 'utilities'));
                ?>
              </div>
            </div>

          </div>
        </div>

        <div id="pageHeaderSub" class="left pageWidth clearfix">
          <div id="pageHeaderSub-inner">
        
            <?php if ($breadcrumb){ ?>
        		<div id="path" class="row">
              <div id="path-inner">
                <?php print $breadcrumb; ?> 
              </div>
            </div>
            <?php } ?>
        
          </div>
        </div>

        <div id="pageFooter" class="left pageWidth">
          <div id="pageFooter-inner">

          	<?php if ($footer_message) { ?>
          	  <?php print $footer_message; ?>
          	<?php } ?>
  
            <?php print $footer; ?>
  
            <?php
                $menu = menu_navigation_links("menu-footermenu");
                print theme('links', $menu, array('class' =>'links', 'id' => 'footerNavigation'));
            ?>
      
          </div>
        </div>

      </div>
    </div>
  
  </div>
</div>


<?php print $scripts; ?>
<?php print $closure; ?>
</body>
</html>