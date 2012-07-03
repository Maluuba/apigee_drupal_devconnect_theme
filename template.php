<?php

/**
 * Preprocess variables for page.tpl.php
 *
 * @see page.tpl.php
 */
function apigee_devconnect_preprocess_page(&$variables) {
  // if ($variables['is_front'] == TRUE) {
  //
  // }
  // else {
  //
  // }

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
 * Preprocess variables for region.tpl.php
 *
 * @see region.tpl.php
 */
function apigee_devconnect_preprocess_region(&$variables, $hook) {
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__no_wrapper';
  }

  if($variables['region'] == "sidebar_first")
    $variables['classes_array'][] = 'well';
}

/**
 * Preprocess variables for node.tpl.php
 *
 * @see node.tpl.php
 */
function apigee_devconnect_preprocess_node(&$variables) {
  $author = $variables['name'];
  $time_ago_short = format_interval((time() - $variables['created']) , 1) . t(' ago');
  $time_ago_long = format_interval((time() - $variables['created']) , 2) . t(' ago');

  // Add some date variables
  if ($variables['type'] = 'blog') {
    $variables['posted'] = 'Posted by ' . $author . '&nbsp;|&nbsp;about&nbsp;' . $time_ago_short;
    $variables['submitted_day'] = format_date($variables['node']->created, 'custom', 'j');
    $variables['submitted_month'] = format_date($variables['node']->created, 'custom', 'M');
  }

  if ($variables['type'] = 'forum') {
    $variables['submitted'] = 'Topic created by: ' . $author . '&nbsp;&nbsp;' . $time_ago_long;
  }
}

/**
 * Preprocess variables for comment.tpl.php
 *
 * @see node.tpl.php
 */
function apigee_devconnect_preprocess_comment(&$variables) {

  // Comment Submitted Variables
  $variables['comment_author'] = $variables['elements']['#comment']->uid;
  $author_details = user_load(array('uid'=>$variables['comment_author']));
  $variables['author_first_name'] = $author_details->field_first_name['und'][0]['safe_value'];
  $variables['author_last_name'] = $author_details->field_last_name['und'][0]['safe_value'];
  $variables['author_email'] = $author_details->mail;
  $variables['submitted'] = $variables['author_first_name'] . '&nbsp;' . $variables['author_last_name'] . '&nbsp;|&nbsp;' . '<a href="mailto:' . $variables['author_email'] . '">' . $variables['author_email'] . '</a>';
}
