<?php
// $Id: template.php,v 1.17.2.1 2009/02/13 06:47:44 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to awene_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: awene_breadcrumb()
 *
 *   where awene is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.
 */
/* -- Delete this line if you want to use and modify this code
// Example: optionally add a fixed width CSS file.
if (theme_get_setting('awene_fixed')) {
  drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
}
// */


/**
 * Implementation of HOOK_theme().
 */
function awene_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function awene_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function awene_preprocess_page(&$vars, $hook) {
  //$vars['head'] = "<!-- 2010 - ontwerp door Total Active Media - www.totalactivemedia.nl -->\n" . $vars['head'];
  $vars['body_classes'] .= ' '. $vars['language']->dir;

  if (!empty($vars['bannerblock_left']) && !empty($vars['bannerblock_right'])) {
    $vars['body_classes'] .= ' bannerblock-right bannerblock-left bannerblock-right-left';
  }
  else if (!empty($vars['bannerblock_left'])) {
    $vars['body_classes'] .= ' bannerblock-left';
  }
  else if (!empty($vars['bannerblock_right'])) {
    $vars['body_classes'] .= ' bannerblock-right';
  }
  if (!empty($vars['bannerblock_top'])) {
    $vars['body_classes'] .= ' bannerblock-top';
  }
  if (!empty($vars['bannerblock_bottom'])) {
    $vars['body_classes'] .= ' bannerblock-bottom';
  }

  if (isset($vars['node']) && $vars['node']->type) {
    $vars['body_classes'] .= ' node-type-'. $vars['node']->type .'-'. $vars['language']->dir;
  }
  
  switch( $vars['language']->language ) {
    case 'ku':
      //$vars['logo'] = '';
      break;
    case 'ar':
      $vars['logo'] = str_replace('.png', '_'.$vars['language']->language.'.png', $vars['logo']);
      $vars['head'] = "<!-- overridden logo path - ". $vars['logo'] ." -->\n" . $vars['head'];
      break;
    case 'en':
    default:
      $vars['logo'] = str_replace('.png', '_'.$vars['language']->language.'.png', $vars['logo']);
      $vars['head'] = "<!-- overridden logo path - ". $vars['logo'] ." -->\n" . $vars['head'];
  }
  
  switch($vars['language']->language) {
    case 'ku':
      $titletranslations = array(
        'news' => 'هه‌واڵ',
          'kurdistani' => 'كوردستانی‌',
          'iraqi' => 'عێراقی',
          'global' => 'جیهانی‌',
        'editorial' => 'ئیدیتۆریاڵ',
          'Story' => 'راپۆرتە ھەواڵ',
          'interview' => 'چاوپێکەوتن',
          'features' => 'ریپۆرتاژ',
        'articles' => 'بیرو ڕا',
        'story' => 'راپۆرت',
        'contributed articles' => 'بیرو ڕا',
        'sport' => 'ئاوێنه‌ سپۆرت',
        'magazine articles' => 'مه‌گه‌زین',
        'magazine' => 'مه‌گه‌زین'
      );
      break;
    case 'ar':
      /* translate these labels to the correct arab label for the live version */
      $titletranslations = array(
        'news' => '[arab news label] أحداث',
          'kurdistani' => '[arab kurdistani label] الكردستاني',
          'iraqi' => '[arab iraqi label] عراقي',
          'global' => '[arab global label] عالمي النطاق',
        'editorial' => '[arab editorial label] الافتتاحية',
          'Story' => '[arab Story label]',
          'interview' => '[arab interview label]',
          'features' => '[arab features label]',
        'articles' => '[arab articles label]',
        'story' => '[arab story label]',
        'contributed articles' => '[arab contributed articles label]',
        'sport' => 'رياضة',
        'magazine articles' => 'مقالات المجلات',
        'magazine' => 'مجلة'
      );
      break;
    case 'en':
    default:
      $titletranslations = array(
        'news' => 'news',
          'kurdistani' => 'kurdistani',
          'iraqi' => 'iraqi',
          'global' => 'global',
        'editorial' => 'editorial',
          'Story' => 'Story',
          'interview' => 'interview',
          'features' => 'features',
        'articles' => 'articles',
        'story' => 'story',
        'contributed articles' => 'contributed articles',
        'sport' => 'sport',
        'magazine articles' => 'magazine articles',
        'magazine' => 'magazine'
      );
      break;
  }
  
  if(array_key_exists(strtolower($vars['title']), $titletranslations)) {
    $vars['title'] = $titletranslations[strtolower($vars['title'])];
  }

  if($vars['node'] && $vars['node']->field_gallery) {
    foreach($vars['node']->field_gallery as $ikey => $iimg) {
	
//      $vars['head'] = '<!-- '.print_r($iimg, true).' -->'. $meta . $vars['head'];
      $imgpath = imagecache_create_url('t300x200', $iimg['filepath']);
      $meta = '<meta property="og:image" content="'.$imgpath.'" />'."\n";
      $vars['head'] = $meta . $vars['head'];
      //drupal_set_header($meta);
    }
  }
  
  $css = drupal_add_css();
  // remove all superfluous css files
  foreach($css['all']['module'] as $key => $value) {
    if(preg_match('/^modules.*/i', $key)) {
      unset($css['all']['module'][$key]);
    }
  }
  unset($css['all']['module']['sites/all/modules/plus1/plus1.css']);
  
  $vars['styles'] = drupal_get_css($css);
  $vars['styles'] .= $vars['conditional_styles'] = variable_get('conditional_styles_' . $GLOBALS['theme'], '');

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function awene_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function awene_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function awene_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

function awene_preprocess_search_results(&$vars) {
  $perPage = 10;
  $currentPage = $_GET['page'] + 1;
  $total = $GLOBALS['pager_total_items'][0];
  $start = 10 * $currentPage - 9;
  $end = $perPage * $currentPage;
  if ($end > $total) {
    $end = $total;
  }
  $vars['search_totals'] = t("Showing @start - @end of @total results", array('@start' => $start, '@end' => $end, '@total' => $total));
}

// SB: Theming of search results, added image and date fields.
function awene_preprocess_search_result(&$variables) {
  $result = $variables['result'];
  // SB: Add image
  $variables['image'] = "";
  if($result['node']->field_teaser_image[0]['filepath']) {
    $variables['image'] = theme('imagecache', 't075x050', $result['node']->field_teaser_image[0]['filepath']);
  }
  //SB: Add date
  $variables['date'] = date('F j, Y',$result['node']->created);
  if($result['node']->field_date[0]['value']) $variables['date'] = date('F j, Y',strtotime($result['node']->field_date[0]['value']));
}
/*
function awene_simplenews_newsletter_text_alternative($node, $tid, $plain_field) {
  // Hier de gewenste inhoud van de plain-text-alternative plaatsen.
  $text  = $node->title . "\n\n";
  $text .= $node->field_plain_text[0]['value'] . "\n\n";
  return $text;
}
*/

/**
 * Themed slideshow controls.
 */
function awene_views_slideshow_singleframe_controls($id, $view, $options) {
  $output = '<div class="views_slideshow_singleframe_controls" id="views_slideshow_singleframe_controls_' . $id . '">' . "\n";
  if(count($view->result) > 1) {
    $output .= theme('views_slideshow_singleframe_control_previous', $id, $view, $options);
    $output .= theme('views_slideshow_singleframe_control_next', $id, $view, $options);
  }
  $output .= "</div>\n";
  return $output;
}

function awene_views_slideshow_singleframe_image_count($id, $view, $options) {
  if(count($view->result) > 1) {
    $output = '<div class="views_slideshow_singleframe_image_count" id="views_slideshow_singleframe_image_count_' . $id . '"><span class="num"></span> ' . t('of') .' <span class="total"></span></div>';
    return $output;
  }
}

function awene_blocks($region) {
  $output = '';
  $demo = variable_get('is_site_in_demo', 0);
  $map = $_GET['map'];
  if ($list = block_list($region)) {
    if (!empty($demo) && drupal_is_front_page()) {
      if ($map) {
        unset($list['views_header_image-block_1']);
        unset($list['views_banners-block_1']);
        unset($list['pressnow_feedsblock_pressnow_feedsblock']);
      }
      else {
        unset($list['make_map_gmap_block']);
        unset($list['pressnow_customblock_pressnow_customblock']);
        unset($list['pressnow_socialmedia_mobypicture2']);
        unset($list['pressnow_socialmedia_facebook2']);
        unset($list['pressnow_socialmedia_twitter2']);
      }
    }

    foreach ($list as $key => $block) {
      $output .= theme('block', $block);
    }
  }

  // Add any content assigned to this region through drupal_set_content() calls.
  $output .= drupal_get_content($region);

  return $output;
}

/**
 * Return a themed ad of type ad_html.
 *
 * @param @ad
 *  The ad object.
 * @return
 *  A string containing the ad markup.
 */
function awene_ad_html_ad($ad) {
  if (isset($ad->aid)) {
    $output  = '<div class="html-advertisement" id="ad-'. $ad->aid .'">';
    if (isset($ad->html) && isset($ad->format)) {
      $output .= $ad->html;
    }
    $output .= '</div>';
    return $output;
  }
}

function awene_nice_menus_build($menu, $depth = -1, $trail = NULL) {
  $output = '';
  $i = 1;
  foreach ($menu as $menu_item) {
    $mlid = $menu_item['link']['mlid'];
    // Check to see if it is a visible menu item.
    if ($menu_item['link']['hidden'] == 0) {
      // Build class name based on menu path
      // e.g. to give each menu item individual style.
      // Strip funny symbols.
      $clean_path = str_replace(array('http://', 'www', '<', '>', '&', '=', '?', ':'), '', $menu_item['link']['href']);
      // Convert slashes to dashes.
      $clean_path = str_replace('/', '-', $clean_path);
      $class = 'menu-path-'. $clean_path;
      if ($trail && in_array($mlid, $trail)) {
        $class .= ' active-trail';
      }
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == count($menu)) {
        $class .= ' last';
      }
      // If it has children build a nice little tree under it.
      if ((!empty($menu_item['link']['has_children'])) && (!empty($menu_item['below'])) && $depth != 0) {
        // Keep passing children into the function 'til we get them all.
        $children = theme('nice_menus_build', $menu_item['below'], $depth, $trail);
        // Set the class to parent only of children are displayed.
        $parent_class = $children ? 'menuparent ' : '';
        $output .= '<li id="menu-'. $mlid .'" class="'. $parent_class . $class .'">'. theme('menu_item_link', $menu_item['link']);
        // Check our depth parameters.
        if ($menu_item['link']['depth'] <= $depth || $depth == -1) {
          // Build the child UL only if children are displayed for the user.
          if ($children) {
            $output .= '<ul>';
            $output .= $children;
            $output .= "</ul>\n";
          }
        }
        $output .= "</li>\n";
      }
      else {
        $output .= '<li id="menu-'. $mlid .'" class="'. $class .'">'. theme('menu_item_link', $menu_item['link']) .'</li>'."\n";
      }
    }
    $i++;
  }
  return $output;
}
