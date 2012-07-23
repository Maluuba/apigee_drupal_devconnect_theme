<?php

/*
 * Implements hook_preprocess_html().
 */
function apigee_devconnect_preprocess_html(&$variables) {
  $header_bg_color         = theme_get_setting('header_bg_color');
  $header_txt_color        = theme_get_setting('header_txt_color');
  $header_hover_bg_color   = theme_get_setting('header_hover_bg_color');
  $header_hover_txt_color  = theme_get_setting('header_hover_txt_color');
  $link_color              = theme_get_setting('link_color');
  $link_hover_color        = theme_get_setting('link_hover_color');
  $footer_bg_color         = theme_get_setting('footer_bg_color');
  $footer_link_color       = theme_get_setting('footer_link_color');
  $footer_link_hover_color = theme_get_setting('footer_link_hover_color');

  drupal_add_css(".navbar-inner {background-color: $header_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a {color: $header_txt_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a:hover, .navbar .nav > li > a.active {background-color: $header_hover_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".navbar .nav > li > a:hover {color: $header_hover_txt_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css("a {color: $link_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css("a:hover {color: $link_hover_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner {background-color: $footer_bg_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner .navbar ul.footer-links > li > a {color: $footer_link_color}", array('group' => CSS_THEME, 'type' => 'inline'));
  drupal_add_css(".footer .footer-inner .navbar ul.footer-links > li > a:hover {color: $footer_link_hover_color}", array('group' => CSS_THEME, 'type' => 'inline'));

}

/**
 * Preprocessor for theme('page').
 */
function apigee_devconnect_preprocess_page(&$variables) {
  module_load_include('inc', 'user', 'user.admin');
  $user_reg_setting = drupal_get_form('user_admin_settings');
  $variables['user_reg_setting'] = $user_reg_setting['registration_cancellation']['user_register']['#value'];

  if (module_exists('apachesolr')) {
    // todo: $searchTerm is undefined, so this parameter will always be empty
    $search = drupal_get_form('search_form', NULL, (isset($searchTerm) ? $searchTerm : ''));
    $search['basic']['keys']['#size'] = 20;
    $search['basic']['keys']['#title'] = '';
    unset($search['#attributes']);
    //$search['#action'] = base_path() . 'search/site'; // breaks apachesolr searching
    $search_form = drupal_render($search);
    $find = array('type="submit"', 'type="text"');
    $replace = array('type="hidden"', 'type="search" placeholder="search" autocapitalize="off" autocorrect="off"');
    $vars['search_form'] = str_replace($find, $replace, $search_form);
  }

  // Add information about the number of sidebars.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['columns'] = 3;
  }
  elseif (!empty($variables['page']['sidebar_first'])) {
    $variables['columns'] = 2;
  }
  elseif (!empty($variables['page']['sidebar_second'])) {
    $variables['columns'] = 2;
  }
  else {
    $variables['columns'] = 1;
  }

  // Custom Search
  $variables['search'] = FALSE;
  if(theme_get_setting('toggle_search') && module_exists('search'))
    $variables['search'] = drupal_get_form('_apigee_base_search_form');

  // Primary nav
  $variables['primary_nav'] = FALSE;
  if($variables['main_menu']) {
    // Build links
    $tree = menu_tree_page_data(variable_get('menu_main_links_source', 'main-menu'));
    $variables['main_menu'] = apigee_base_menu_navigation_links($tree);

    // Build list
    $variables['primary_nav'] = theme('apigee_base_links', array(
      'links' => $variables['main_menu'],
      'attributes' => array(
        'id' => 'main-menu',
        'class' => array('nav'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),
    ));
  }

  // Make sure the menu module is in use before setting menu vars.
  if (module_exists('menu')) {
    // Primary nav
    $variables['primary_nav'] = FALSE;
    if ($variables['main_menu']) {
      // Build links
      $tree = menu_tree_page_data(variable_get('menu_main_links_source', 'main-menu'));
      $variables['main_menu'] = apigee_base_menu_navigation_links($tree);

      // Build list
      $variables['primary_nav'] = theme('apigee_base_links', array(
        'links' => $variables['main_menu'],
        'attributes' => array(
          'id' => 'main-menu',
          'class' => array('nav'),
        ),
        'heading' => array(
          'text' => t('Main menu'),
          'level' => 'h2',
          'class' => array('element-invisible'),
        ),
      ));
    }

    // Secondary nav
    $variables['secondary_nav'] = FALSE;
    if ($variables['secondary_menu']) {
      $secondary_menu = menu_load(variable_get('menu_secondary_links_source', 'user-menu'));

      // Build links
      $tree = menu_tree_page_data($secondary_menu['menu_name']);
      $variables['secondary_menu'] = apigee_base_menu_navigation_links($tree);

      // Build list
      $variables['secondary_nav'] = theme('apigee_base_btn_dropdown', array(
        'links' => $variables['secondary_menu'],
        'label' => $secondary_menu['title'],
        'type' => 'success',
        'attributes' => array(
          'id' => 'user-menu',
          'class' => array('pull-right'),
        ),
        'heading' => array(
          'text' => t('Secondary menu'),
          'level' => 'h2',
          'class' => array('element-invisible'),
        ),
      ));
    }

    // Replace tabs with dropw down version
    $variables['tabs']['#primary'] = _apigee_base_local_tasks($variables['tabs']['#primary']);
  }
}

/**
 * Preprocessor for theme('node').
 */
function apigee_devconnect_preprocess_node(&$variables) {
}

/**
 * Preprocessor for theme('region').
 */
function apigee_devconnect_preprocess_region(&$variables, $hook) {
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__no_wrapper';
  }

  if($variables['region'] == "sidebar_first")
    $variables['classes_array'][] = 'well';
}

/**
 * hook_comment_form_alter
 */
function apigee_devconnect_form_comment_form_alter(&$form, &$form_state) {
  hide($form['subject']);
  hide($form['author']);
  hide($form['actions']['preview']);
  $form['actions']['submit']['#value'] = 'Add comment';
}
