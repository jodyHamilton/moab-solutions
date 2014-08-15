<?php

/**
 * Implements template_preprocess_html().
 * Adds path variables.
 */
function bear_skin_preprocess_html(&$variables, $hook) {
  // Add variables and paths needed for HTML5 and responsive support.
  $variables['base_path'] = base_path();
  $variables['path_to_bear_skin'] = drupal_get_path('theme', 'bear_skin');
}

/**
 * Implements theme_links().
 * Enables sub-menu item display for main menu.
 */
function bear_skin_links($variables) {
  if (array_key_exists('id', $variables['attributes']) && $variables['attributes']['id'] == 'nav') {
    $pid = variable_get('menu_main_links_source', 'nav');
    $tree = menu_tree($pid);
    return drupal_render($tree);
  }
  return theme_links($variables);
}

/**
 * Implements template_preprocess_page().
 */
function bear_skin_preprocess_page(&$vars) {
  $vars['user_menu'] =  theme('links', array('links' => menu_navigation_links('user-menu'), 'attributes' => array('class '=> array('links', 'site-menu'))));
  $vars['header_image'] = '';
  $vars['footer'] = '';
  if (isset($vars['node'])) {
    $wrapper = entity_metadata_wrapper('node', $vars['node']);
    if (isset($wrapper->field_header_image)) {
      if ($image = $wrapper->field_header_image->value()) {
        $vars['header_image'] = theme('image_style', array('style_name' => 'header_image', 'path' => $image['uri']));
      }
    }
    if (isset($wrapper->field_footer_notes)) {
      if ($footer = $wrapper->field_footer_notes->value()) {
        $vars['footer'] = $footer['safe_value'];
      }
    }
    else if (isset($wrapper->field_page_choice)) {
      $page = $wrapper->field_page_choice->value();
      $wrapper = entity_metadata_wrapper('node', $page);
      if (isset($wrapper->field_header_image)) {
        if ($image = $wrapper->field_header_image->value()) {
          $vars['header_image'] = theme('image_style', array('style_name' => 'header_image', 'path' => $image['uri']));
        }
      }
      if (isset($wrapper->field_footer_notes)) {
        if ($footer = $wrapper->field_footer_notes->value()) {
          $vars['footer'] = $footer['safe_value'];
        }
      }
    }
  }
}

/***********************
Let's load some CSS on specific targets - uncomment to use
************************/

// function bear_skin_preprocess_node(&$vars) {
//   // Add JS & CSS by node type
//   if( $vars['type'] == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }

//   // Add JS & CSS to the front page
//   if ($vars['is_front']) {
//     drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }

//   // Add JS & CSS by node ID
//   if (drupal_get_path_alias("node/{$vars['#node']->nid}") == 'your-node-id') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
// }
// function bear_skin_preprocess_page(&$vars) {
//   // Add JS & CSS by node type
//   if (isset($vars['node']) && $vars['node']->type == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
//   // Add JS & CSS by node ID
//   if (isset($vars['node']) && $vars['node']->nid == '1') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
// }
