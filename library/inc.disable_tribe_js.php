<?php

//  add_action('init','dequeue_tec_scripts');

  function dequeue_tec_scripts() {
    wp_dequeue_script('tribe-events-calendar');
    wp_dequeue_script('tribe-events-calendar-script');
    wp_dequeue_script('tribe-events-bootstrap-datepicker');
    wp_dequeue_script('tribe-events-admin');
    wp_dequeue_script('tribe-events-settings');
    wp_dequeue_script('tribe-events-ecp-plugins');
    wp_dequeue_script('tribe-events-bar');
    wp_dequeue_script('tribe-events-calendar');
    wp_dequeue_script('tribe-events-list');
    wp_dequeue_script('tribe-events-ajax-day');
    wp_dequeue_script('tribe-mini-calendar');
    wp_dequeue_script('tribe-events-pro-slimscroll');
    wp_dequeue_script('tribe-events-pro-week');
    wp_dequeue_script('tribe-events-pro-isotope');
    wp_dequeue_script('tribe-events-pro-photo');
    wp_dequeue_script('tribe-events-pro-geoloc');
    wp_dequeue_script('tribe-meta-box');
    wp_dequeue_script('tribe-jquery-ui');
    wp_dequeue_script('tribe-jquery-ui');
    wp_dequeue_script('tribe-timepicker');
    wp_dequeue_script('tribe-fac');
    wp_dequeue_script('tribe-events-pro');
  }
