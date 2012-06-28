<header id="navbar" role="banner" class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </a>
      
      <?php if ($logo): ?>
        <a class="brand" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>
      
      <div class="nav-collapse">
        <nav role="navigation">
          <?php if ($primary_nav): ?>
            <?php print $primary_nav; ?>
          <?php endif; ?>

          <?php if ($secondary_nav): ?>
            <?php print $secondary_nav; ?>
          <?php endif; ?>

          <div id='login-buttons' class="span6 pull-right">
            <ul class="nav pull-right">
            <?php if ($user->uid == 0) { ?>
            <!-- show/hide login and register links depending on site registration settings -->
            <?php if (($user_reg_setting != 0) || ($user->uid == 1)): ?>
              <li class="<?php echo (($current_path == "user/register")?"active":""); ?>"><?php echo l(t("register"), "user/register"); ?></li>
              <li class="<?php echo (($current_path == "user/login")?"active":""); ?>"><?php echo l(t("login"), "user/login"); ?></li>
            <?php endif; ?>
            <?php } else { 
              $user_url =  "user/".$user->uid."/edit"; ?>
              <li class="<?php echo (($current_path == $user_url)?"active":""); ?>"><?php echo l($user->mail, $user_url); ?></li>
              <li><?php echo l(t("logout"), "user/logout"); ?></li>
            <?php } ?>
            </ul>
          </div>
        </nav>
      </div>

    </div>
  </div>
</header>

<div class="master-container">
  <!-- Header -->
  <header role="banner" id="page-header">
    <?php print render($page['header']); ?>
  </header>
    
  <!-- Breadcrumbs -->    
  <div class="container" id="breadcrumb-navbar">
    <div class="row">
      <div class="span19">
      <?php if ($breadcrumb): print $breadcrumb; endif;?>
      </div>
      <div class="span5 pull-right">
      <?php if ($search): ?>
        <?php if ($search): print render($search); endif; ?>
      <?php endif; ?>
      </div>
    </div>
  </div>
  
  <!-- Title -->
  <?php if (drupal_is_front_page()): ?>
    <?php if ($title): ?>
        <section class="page-header">
            <div class="container">
              <div class="row">
                <div class="span9">
                  <div class="title">
                    <span class="welcome">Welcome</span><br />
                    <!-- ***Uncomment the $site_name after fixing the issue with the width*** -->
                    to the <?php print /*$site_name*/ 'to the Apigee Developer Portal'; ?>
                  </div>
                </div>
              </div>
              <div class="page-header-content">
                <div class="get">GET</div>
                <div class="buttons">
                  <div class="home-header-btn document">
                    <a href="#"><div class="first-word">Started</div>with documentation<span class="iconbtn document"></span></a>
                  </div>
                  <div class="home-header-btn key">
                    <a href="#"><div class="first-word">Building</div>with access to a key<span class="iconbtn key"></span></a>
                  </div>
                </div>
                <div class="home-img">
                  <img src="/sites/all/themes/apigee_devconnect/images/homepage-image.png" alt="">
                </div>
              </div>
            </div>
        </section>
    <?php endif; ?>
  <?php else: ?>
    <?php if ($title): ?>
        <section class="page-header">
            <div class="container">
              <?php print render($title_prefix); ?>
              <h1><?php print $title; ?></h1>
              <?php print render($title_suffix); ?>
            </div>
        </section>
    <?php endif; ?>
  <?php endif; ?>

  <div class="container page-content">
    <!-- Admin Stuff-->
    <?php print $messages; ?>
    <?php if ($page['help']): ?> 
      <div class="well"><?php print render($page['help']); ?></div>
    <?php endif; ?>
    <?php if ($action_links): ?>
      <ul class="action-links"><?php print render($action_links); ?></ul>
    <?php endif; ?>

    <div class="row">
      <!-- Left Sidebar  -->
      <?php if ($page['sidebar_first']): ?>
        <aside class="span6" role="complementary">
          <?php print render($page['sidebar_first']); ?>
        </aside>
      <?php endif; ?>  
  
      <!-- Main Body  -->
      <section class="<?php print _apigee_base_content_span($columns); ?>">  
        <?php if ($page['highlighted']): ?>
          <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
        <?php endif; ?>
        <?php if (($tabs) && (!$is_front)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <a id="main-content"></a>
        <?php print render($page['content']); ?>
      </section>

      <!-- Right Sidebar  -->
      <?php if ($page['sidebar_second']): ?>
        <aside class="span6" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside>  <!-- /#sidebar-second -->
      <?php endif; ?>
  
    </div>
  </div>
</div>

<!-- Footer  -->
<footer class="footer">
  <div class="footer-inner">
    <div class="container">
      <?php print render($page['footer']); ?>
    </div>
  </div>
</footer>


  

