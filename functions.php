<?php


/* Problem mit Enfold: */





  /* -- LOAD TEXT DOMAINS FOR CHILDTHEME -- */
  load_theme_textdomain('vbegy',dirname(__FILE__).'/languages');


	// Add Meta Referrer Tag in Header without Plugin
  // Mit diesem Eintrag im Header des themes sollen die Zugriffe auf http - Seiten
  // nicht mehr als direkte Zugriffe gezählt werden, sondern aachenerkinder zugezählt werden (wie es auch sein soll)
  // 18.9.2016

	function add_meta_tags() {
	?>
		<meta name="referrer" content="always"/>
	<?php }
	add_action('wp_head', 'add_meta_tags');

	//Add Meta Referrer Tag in Header without Plugin


  /* -- REGISTER OWN JS FILE -- */

  function add_pix_js_file(){
    wp_enqueue_script( 'pix-logger-childtheme-js', get_stylesheet_directory_uri().'/js/pix-custom.js', array('jquery'), true );
  }
  add_action('wp_enqueue_scripts','add_pix_js_file');


  /* -- SHORTCODE FUNCTIONALITY IN TEXWIDGET -- ADDED TO REMOVE "ENHANCED TEXT WIDGET" PLUGIN -- */

  add_filter('widget_text', 'do_shortcode');





  /* -- ADD ACF OPTIONS PAGE

  if( function_exists('acf_add_options_page') ) {

  	$page = acf_add_options_page(array(
  		'page_title' 	=> 'Theme Standards',
  		'menu_title' 	=> 'Theme Standards',
  		'menu_slug' 	=> 'theme-default-settings',
  		'capability' 	=> 'edit_posts',
  		'redirect' 	=> false,
  		'icon_url' => 'dashicons-desktop',
  	));

  } -- */


  /* -- ADD NEW IMAGE SIZE FOR HEADER -- */
/*
  add_image_size('image_header', 1140, 250, true);
*/

  /* -- CHANGE EVENT LISTING -- */
/*
  function exclude_category( $query ) {
    if(!is_admin()){
      if ( $query->is_main_query() && $query->query_vars['post_type'] == TribeEvents::POSTTYPE && !is_tax(TribeEvents::TAXONOMY) && empty( $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'tax_query',
          array(
            array(
              'taxonomy' => TribeEvents::TAXONOMY,
              'field' => 'slug',
              'terms' => array('laufend'),
              'operator' => 'NOT IN'
            )
          )
        );
      }
    }

  }
  add_action( 'pre_get_posts', 'exclude_category' );
*/

  /* -- Google Fonts deaktivieren -- */
add_action( 'init', 'enfold_customization_switch_fonts' );
function enfold_customization_switch_fonts() {
    global $avia;
    $avia->style->print_extra_output = false;
}



/* https://theeventscalendar.com/support/forums/topic/counting-posts/ */
function tribe_count_by_cat ( $event_category_slug ) {

    if ( ! class_exists('Tribe__Events__Main') ) return false;


    $tax_query = array(    'taxonomy'    => Tribe__Events__Main::TAXONOMY,
                        'field'        => 'slug',
                        'terms'        => $event_category_slug );

      $args = array( 'post_type' => Tribe__Events__Main::POSTTYPE, 'post_status' => 'publish', 'tax_query' => array( $tax_query ), 'posts_per_page' => -1);

    $query = new WP_Query( $args );

    return $query->found_posts;
}


  /* -- ADD SHARING AFTER EVERY EVENT -- */
  /* Änderung von aachenerkinder auf aachen50plus bei den Grafiken, 25.10.2017, hgg */

  function add_tribe_event_sharing(){
    ?>

    <div class="share">
      Teilen auf:
      <?php /* FACEBOOK */ ?>
      <a target="_blank" class="sharebutton facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode(get_permalink()); ?>" title="<?php _e('Diesen Beitrag auf Facebook teilen'); ?>">
        <img src="https://www.aachen50plus.de/grafiken/facebook.png" alt="facebook" title="facebook" width=16px hight=16px border="0">
      </a>

      <!-- wird z. Zt. nicht in aachen50plus.de genutzt:
      <?php /* TWITTER */ ?>
      <a target="_blank" class="sharebutton twitter" href="https://twitter.com/home?status=<?php echo rawurlencode(get_the_title().' '.get_permalink()); ?>" title="<?php _e('Diesen Beitrag twittern'); ?>">
        <img src="https://www.aachen50plus.de/grafiken/twitter.png" alt="twitter" title="twitter" width=16px hight=16px border="0">
      </a>

      <?php /* GOOGLE PLUS */ ?>
      <a target="_blank" class="sharebutton googleplus" href="https://plus.google.com/share?url=<?php echo rawurlencode(get_permalink()); ?>" title="<?php _e('Diesen Beitrag auf Google+ teilen'); ?>">
        <img src="https://www.aachen50plus.de/grafiken/google_plus.png" alt="Google +" title="Google +" width=16px hight=16px border="0">
      </a>
      -->
      <?php /* Mail */ ?>
      <a class="sharebutton mail" href="mailto:?subject=interessanter Link auf aachen50plus.de&body=Hallo, hier ist ein interessanter Link auf aachen50plus.de:<?php echo rawurlencode(get_permalink()); ?> Viele Grüße" title="<?php _e('Diesen Beitrag per Mail teilen'); ?>">
        <img src="https://www.aachen50plus.de/grafiken/mail.png" alt="Mail" title="Mail" width=16px hight=16px border="0">
      </a>

    </div>

    <?php
  }
  add_action('tribe_events_after_the_content','add_tribe_event_sharing');


/* Dies wurde bis TEC 4.2.4 so eingesetzt, Änderung ab 31.8.2016
	add_action('tribe_events_template', 'avia_events_tempalte_paths', 10, 2);

	function avia_events_tempalte_paths($file, $template)
	{
		$redirect = array('default-template.php' , 'single-event.php' , 'pro/map.php' );

		if(in_array($template, $redirect))
		{
			$file = AVIA_EVENT_PATH . "views/".$template;
		}

		return $file;
	}

*/

/* Das wird ab TEC 4.2.5 ausgeführt: */

add_action('after_setup_theme', function() {
	if(is_child_theme()) remove_action('tribe_events_template', 'avia_events_tempalte_paths', 10, 2);
});

add_action('tribe_events_template', 'avia_events_template_paths_mod', 10, 2);
function avia_events_template_paths_mod($file, $template)
{
	$redirect = array('default-template.php');
	if(in_array($template, $redirect))
	{
		$file = get_stylesheet_directory() . "/tribe-events/views/".$template;
	}

	return $file;
}


if(!function_exists('avia_events_register_assets'))
{
	if(!is_admin()){ add_action('wp_enqueue_scripts', 'avia_events_register_assets',15); }

	function avia_events_register_assets($styleUrl)
	{
		wp_enqueue_style( 'avia-events-cal', AVIA_BASE_URL.'config-events-calendar/event-mod.css');
	}
}

// DatumsCheck() hat datum_bereich() wegen der besseren Handhabung abgelöst
// wichtig für die Werbung
function DatumsCheck($Datum, $ZeitspanneBeginn, $ZeitspanneEnde) {
	$ZeitspanneBeginn = substr($ZeitspanneBeginn, 0, 4)*10000 + substr($ZeitspanneBeginn, 5, 2)*100 + substr($ZeitspanneBeginn, 8, 2);
	$ZeitspanneEnde = substr($ZeitspanneEnde, 0, 4)*10000 + substr($ZeitspanneEnde, 5, 2)*100 + substr($ZeitspanneEnde, 8, 2);
	$UmgewandeltesDatum = substr($Datum, 0, 4)*10000 + substr($Datum, 5, 2)*100 + substr($Datum, 8, 2);

	if($UmgewandeltesDatum >= $ZeitspanneBeginn && $UmgewandeltesDatum <= $ZeitspanneEnde)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}


add_filter('widget_display_callback', 'increase_event_widget_limit', 10, 2);

/**
 * Test if the current widget is an Advanced List Widget and fix the event limit if it is.
 */
function increase_event_widget_limit(array $instance, $widget) {
    if (is_a($widget, 'Tribe__Events__Pro__Advanced_List_Widget'))
        $instance['limit'] = 30;

    return $instance;
}
add_filter('avf_title_args', 'fix_blog_page_title', 10, 2);
function fix_blog_page_title($args, $id)
{
    if(is_page($id))
    {
        $parents = get_post_ancestors($id);
        if(!empty($parents))
        {
            $id = $parents[count($parents)-1];
            $args['title'] = get_the_title($id);
        }
    }
    return $args;
}


/*
 * Alters event's archive titles
 */

function tribe_alter_event_archive_titles ( $original_recipe_title, $depth ) {
  // Modify the titles here
  // Some of these include %1$s and %2$s, these will be replaced with relevant dates
  /* $title_upcoming =   'Upcoming Events'; // List View: Upcoming events */
  /* $title_past =       'Past Events'; // List view: Past events */
  $title_upcoming =   'Anstehende Veranstaltungen'; // List View: Upcoming events */
  $title_past =       'Vergangene Veranstaltungen'; // List view: Past events */
  $title_range =      'Veranstaltungen am %1$s - %2$s'; // List view: range of dates being viewed
  /* $title_month =      'Events for %1$s'; // Month View, %1$s = the name of the month */
  $title_month =      'Veranstaltungen im %1$s'; // Month View, %1$s = the name of the month */
  $title_day =        'Veranstaltungen am %1$s'; // Day View, %1$s = the day
  $title_all =        'Alle Veranstaltungen für %s'; // showing all recurrences of an event, %s = event title
  $title_week =       'Veranstaltungen in der Woche %s'; // Week view
  /*
  $title_all =        'All events for %s'; // showing all recurrences of an event, %s = event title
  $title_week =       'Events for week of %s'; // Week view
  */
  // Don't modify anything below this unless you know what it does
  global $wp_query;
  $tribe_ecp = Tribe__Events__Main::instance();
  $date_format = apply_filters( 'tribe_events_pro_page_title_date_format', tribe_get_date_format( true ) );
  // Default Title
  $title = $title_upcoming;
  // If there's a date selected in the tribe bar, show the date range of the currently showing events
  if ( isset( $_REQUEST['tribe-bar-date'] ) && $wp_query->have_posts() ) {
    if ( $wp_query->get( 'paged' ) > 1 ) {
      // if we're on page 1, show the selected tribe-bar-date as the first date in the range
      $first_event_date = tribe_get_start_date( $wp_query->posts[0], false );
    } else {
      //otherwise show the start date of the first event in the results
      $first_event_date = tribe_format_date( $_REQUEST['tribe-bar-date'], false );
    }
    $last_event_date = tribe_get_end_date( $wp_query->posts[ count( $wp_query->posts ) - 1 ], false );
    $title = sprintf( $title_range, $first_event_date, $last_event_date );
  } elseif ( tribe_is_past() ) {
    $title = $title_past;
  }
  // Month view title
  if ( tribe_is_month() ) {
    $title = sprintf(
      $title_month,
      date_i18n( tribe_get_option( 'monthAndYearFormat', 'F Y' ), strtotime( tribe_get_month_view_date() ) )
    );
  }
  // Day view title
  if ( tribe_is_day() ) {
    $title = sprintf(
      $title_day,
      date_i18n( tribe_get_date_format( true ), strtotime( $wp_query->get( 'start_date' ) ) )
    );
  }
  // All recurrences of an event
  if ( function_exists('tribe_is_showing_all') && tribe_is_showing_all() ) {
    $title = sprintf( $title_all, get_the_title() );
  }
  // Week view title
  if ( function_exists('tribe_is_week') && tribe_is_week() ) {
    $title = sprintf(
      $title_week,
      date_i18n( $date_format, strtotime( tribe_get_first_week_day( $wp_query->get( 'start_date' ) ) ) )
    );
  }
  if ( is_tax( $tribe_ecp->get_event_taxonomy() ) && $depth ) {
    $cat = get_queried_object();
    $title = '<a href="' . esc_url( tribe_get_events_link() ) . '">' . $title . '</a>';
    $title .= ' &#8250; ' . $cat->name;
  }
  return $title;
}
add_filter( 'tribe_get_events_title', 'tribe_alter_event_archive_titles', 11, 2 );

/* eingefügt am 8.3.2017: */
function wpb_remove_version() {
return '';
}
add_filter('the_generator', 'wpb_remove_version');

  require_once 'library/inc.kundenfunktionen.php';
  require_once 'library/inc.overwrite_plugin.php';
  require_once 'library/inc.disable_tribe_js.php';


/* --------------------------------------------------------- */
/* WPRocket Bot ausgeschaltet, weil es evtl. Probleme beim   */
/* Speichern von Veranstaltungen gibt, 5.9.2017              */
/* --------------------------------------------------------- */
add_filter( 'do_run_rocket_bot', '__return_false');

/*----------------------------------------------------------------*/
/* Start: Ausschließen recaptcha bei lazyload WP Rocket, siehe Antwort von Lucy
/* Datum: 29.12.2017
/* Autor: hgg
/*----------------------------------------------------------------*/
function rocket_lazyload_exclude_src( $src ) {
$src[] = '?cp_contactformtoemail_captcha=captcha';

return $src;
}
add_filter( 'rocket_lazyload_excluded_src', 'rocket_lazyload_exclude_src' );
/*----------------------------------------------------------------*/
/* Ende: Ausschließen recaptcha bei lazyload WP Rocket
/* Datum: 29.12.2017
/* Autor: hgg
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
/* Start: Balken links in der Überschrift der Events fehlte
/* Datum: 12.10.2018
/* Autor: hgg
/* https://wordpress.org/support/topic/category-colors-not-showing-after-update-to-5-2-2/page/2/#post-10757393
/*----------------------------------------------------------------*/
add_filter( 'teccc_fix_category_background_color', function( $null, $category ) {
	return "#top .main_color {$category} .tribe-events-list-event-title,";
}, 10, 2 );
/*----------------------------------------------------------------*/
/* Ende: Balken links in der Überschrift der Events fehlte
/* Datum: 12.10.2018
/* Autor: hgg
/* https://wordpress.org/support/topic/category-colors-not-showing-after-update-to-5-2-2/page/2/#post-10757393
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
/* Start: shortcodes für Anzahl Veranstaltungen und Beiträge
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

// Display the total number of published posts using the shortcode [published-posts-count]
function customprefix_total_number_published_posts($atts) {
    return wp_count_posts('post')->publish;
}
add_shortcode('published-posts-count', 'customprefix_total_number_published_posts');


// Display the total number of published events using the shortcode [published-events-count]
function customprefix_total_number_published_events($atts) {
    return wp_count_posts('tribe_events')->publish;
}
add_shortcode('published-events-count', 'customprefix_total_number_published_events');



// Zeigt bei einer Veranstaltung oder einem Beitrag automatisch den Text aus "Beschriftung" in kursiv
// Aufruf-Beispiele:
// [fuss link="https://aachen50plus.de" fm="ja" vl="ja"] --> zeigt immer Bildnachweis, dann Mehr Infos mit dem Link und bei fm="ja" den Link zu "Weitere Flohmärkte" und bei vl="ja" den Link zu "Weitere Veranstaltungen"
// [fuss vl="ja"] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und bei vl="ja" den Link zu "Weitere Veranstaltungen"
// vl = Veranstaltungsliste
// [fuss] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und keinen Link zu "Weitere Veranstaltungen"
// hgg, 23.2.2019
// erweitert: hgg, 29.3.2019: zusätzlich kann bei vl die Kategorie angeben werden, so dass bei Klick auf den Link sofort die Veranstaltungen der jeweiligen Kategorie angezeigt werden, z. B.
// [fuss link="http://www.melan.de/go/standort-detail/1-flohmarkt-troedelmarkt-in-aachen-altstadt.html" kfm="ja" vl="Feiern und Feste"]

function beitrags_fuss($atts) {
  	$werte = shortcode_atts( array(
  	  'link' => '',
      'fm' => 'nein',
      'vl' => 'nein',
      'il' => '',
  	  ), $atts);
    $ausgabe = '<br><strong>keine Webseite angegeben</strong>';
    $veranstaltungen = 'https://aachen50plus.de/veranstaltungen/kategorie/';
    $kategorien = cliff_get_events_taxonomies();

    if ( trim($werte['link']) != '') {
      $ausgabe = '<br><a href=' . $werte['link'] . ' target="_blank">Mehr Infos</a>';
    }
    $ausgabe = $ausgabe . '<br><br><em>' . get_post(get_post_thumbnail_id())->post_excerpt . '</em>';
    if ( $werte['fm'] != 'nein' ) {
      $ausgabe = $ausgabe . '<br><br><p class="button-absatz"><a class="tribe-events-button-beitrag" href="https://aachen50plus.de/veranstaltungen/kategorie/flohmarkt/">Weitere Flohmärkte</a></p>';
    }
    if ( $werte['vl'] != 'nein' ) {
      if ( trim($werte['vl']) != '') {
        /* Leerzeichen werden ggfs. durch "-" ersetzt (Sicherheitsmaßnahme bei Eingabe von Kategorien, die Leerzeichen enthalten, z. B. "Feiern und Feste") */
        $vergleichswert = $werte['vl'];
        /* wenn der Vergleichswert im Array der Kategorien enthalten ist: */
        if (in_array($vergleichswert, $kategorien )){
          $veranstaltungen = $veranstaltungen . str_replace(" ", "-", $werte['vl']);
          $vergleichswert = ': ' . $vergleichswert . '';
          }
        else {
          $vergleichswert = '';
          }
      $ausgabe = $ausgabe . '<br><br><p class="button-absatz"><a class="tribe-events-button-beitrag" href=' . $veranstaltungen . ' target="_blank">Weitere Veranstaltungen</a></p>';
    }
    if ( trim($werte['il']) != '') {
       $ausgabe = $ausgabe . '<p class="button-absatz"><a class="tribe-events-button-beitrag" href=' . $werte['il'] . ' target="_blank">Mehr Infos auf dieser Seite</a></p><hr>';
    }
    $ausgabe = $ausgabe . '<hr>';
	return $ausgabe;
}
add_shortcode('fuss', 'beitrags_fuss');



/*----------------------------------------------------------------*/
/* Ende: shortcodes für Anzahl Veranstaltungen und Beiträge
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/**
  * The Events Calendar: See all Events Categories - var_dump at top of Events archive page
  * Screenshot: https://cl.ly/0Q0B1D0g2a43
  *
  * for https://theeventscalendar.com/support/forums/topic/getting-list-of-event-categories/
  *
  * From https://gist.github.com/cliffordp/36d2b1f5b4f03fc0c8484ef0d4e0bbbb
  */
add_action( 'tribe_events_before_template', 'cliff_get_events_taxonomies' );
function cliff_get_events_taxonomies(){
	if( ! class_exists( 'Tribe__Events__Main' ) ) {
		return false;
	}

	$tecmain = Tribe__Events__Main::instance();

	// https://developer.wordpress.org/reference/functions/get_terms/
	$cat_args = array(
		'hide_empty' => true,
	);
	$events_cats = get_terms( $tecmain::TAXONOMY, $cat_args );

	if( ! is_wp_error( $events_cats ) && ! empty( $events_cats ) && is_array( $events_cats) ) {
		$events_cats_names = array();
		foreach( $events_cats as $key => $value ) {
			$events_cats_names[] = $value->name;
		}

	   /* var_dump( $events_cats_names );  Anzeige der Kategorien */
	}
  return $events_cats_names;
}
