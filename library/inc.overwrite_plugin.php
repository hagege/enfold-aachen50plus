<?php

  /****
    OVERWRITE WP GOOGLE MAPS PRO FUNCTION TO ENABLE ICON OUTPUT.
    IT MUST BE OVERWRITTEN BECAUSE THE PLUGIN DOESNT OFFER ANY FILTERS OR HOOKS. SORRY.

    AFTER THE PLUGIN UPDATE, GO TO THE FILE "plugins/wp-google-maps-pro/wp-google-maps-pro_categories.php"
    AND DELETE THE COMPLETE FUNCTION "wpgmza_pro_return_category_checkbox_list".

    NOW GO TO "plugins/wp-google-maps-pro/wp-google-maps-pro.php" AND SEARCH FOR "400px".
    YOU'LL FIND SEVERAL RESULTS. ON RESULT WILL LOOK LIKE THIS (env. on line 2256):

    $wpgmza_marker_filter_output .= "<div style=\"display:block; float:left; width:400px;\">    ";

    REPLACE THIS LINE WITH:

    $wpgmza_marker_filter_output .= "<div style=\"display:block; float:left;\">    ";

    YAY! THAT'S ALL. :-)

  *****/

  if(!function_exists('wpgmza_pro_return_category_checkbox_list')):

    function wpgmza_pro_return_category_checkbox_list($map_id,$show_all = true,$array = false) {
      global $wpdb;
      global $wpgmza_tblname_categories;
      global $wpgmza_tblname_category_maps;
      if ($array) { $array_suffix = "[]"; } else { $array_suffix = ""; }
      $sql = "SELECT * FROM `$wpgmza_tblname_category_maps` WHERE `map_id` = '$map_id' OR `map_id` = '0'";
          $ret_msg = "<div style='display:block; overflow:hidden;'>";
          $ret_msg .= "<div style='display:block; float:left;'>";
          //if ($show_all) { $ret_msg .= "<input type='checkbox' class='wpgmza_checkbox' id='wpgmza_cat_checkbox_0' name='wpgmza_cat_checkbox$array_suffix' mid=\"".$map_id."\" value=\"0\" />".__("All","wp-google-maps"); }
          $ret_msg .= "</div>";

      $results = $wpdb->get_results($sql);
      if (!$results) { return __("<em><small>No categories found</small></em>","wp-google-maps"); }
      foreach ( $results as $result ) {

          $cat_id = $result->cat_id;

          $results = $wpdb->get_results("
              SELECT *
              FROM `$wpgmza_tblname_categories`
              WHERE `active` = 0
              AND `id` = '$cat_id'
              ORDER BY `id` DESC
              ");
          foreach ( $results as $result ) {

              $ret_msg .= "<div class='category_filter'>";
                // geändert für aachen50plus:
                $ret_msg .= "<img src=\"". $result->category_icon ."\" />";
                // $ret_msg .= "<img src=\"". str_replace('http://', 'https://', $result->category_icon) ."\" />";
                $ret_msg .= "<input type='checkbox' class='wpgmza_checkbox checkbox-".sanitize_title($result->category_name)."' data-name='".sanitize_title($result->category_name)."' id='wpgmza_cat_checkbox_".$result->id."' name='wpgmza_cat_checkbox$array_suffix' mid=\"".$map_id."\" value=\"".$result->id."\" />";
                $ret_msg .= $result->category_name;
              $ret_msg .= "</div>";
          }

      }
          $ret_msg .= "</div>";

      return $ret_msg;
    }



  endif;