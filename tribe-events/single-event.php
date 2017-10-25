<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

// zeigt die nächste Seite - noch nicht ideal, aber schon besser als bisher:
// $vorherige_seite = tribe_get_listview_dir_link();
// Funktioniert nicht, Änderung am 22.10.2017:
// $vorherige_seite = wp_get_referer();
// START: 08.10.2017, Andrei: //
$vorherige_seite = $_SERVER['HTTP_REFERER']; 

?>

<div id="tribe-events-content" class="tribe-events-single ">

	<p class="tribe-events-back">
    <!-- Damit nicht auf alle Veranstaltungen, sondern auf Veranstaltungen der Kategorie "Terminanzeige" verlinkt wird: Link "Alle Veranstaltungen" -->
    <!-- Außerdem Korrektur von Alle statt All - noch mal prüfen>
    <!-- Änderung am 19.3.2017, HGG --> 
    <!-- <a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'tribe-events-calendar-pro' ), $events_label_plural ); ?></a> -->
    <a href="<?php echo esc_url( $vorherige_seite ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'Vorher angezeigte Seite', '%s Events plural label', 'tribe-events-calendar-pro' ), $events_label_plural ); ?></a>
	</p>
	<!-- Jens: Event Image Medium & open in lightbox -->
			
<?php 
if ( has_post_thumbnail() ) {
      $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
      echo '<a href="' . $large_image_url[0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
      echo get_the_post_thumbnail( $post->ID, 'entry_with_sidebar' ); 
      echo '</a>';
}
?>
	<!-- Notices -->
	<?php tribe_the_notices() ?>

		<h2 class="tribe-events-page-title"><?php echo tribe_get_events_title() ?></h2>


	<!-- Event header -->
	<div class="entry-content-wrapper clearfix standard-content">
	<div id="tribe-events-header" class="entry-content-header" <?php tribe_events_the_header_attributes() ?>>
	<?php the_title( '<h1 class="post-title entry-title">', '</h1>' ); ?>
	<div class="post-meta-infos">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2 class="date-container minor-meta updated">', '</h2>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-divider">|</span>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>


		<!-- Navigation 
		<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		 .tribe-events-sub-nav -->
	</div>
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>

      <!-- 	Erst mal in Listenansicht und in Einzelansicht:              -->		
			<!--  Social Media Icons Facebook, Twitter... 24.10.2017, Andrei; korrigiert 25.10.2017, hgg   -->
      <?php add_tribe_event_sharing(); ?>		
			<!-- Social Media Icons Facebook, Twitter ... Ende -->
			
			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
			

			<div class="hr hr-default  avia-builder-el-1  el_after_av_heading  el_before_av_textblock "><span class="hr-inner "><span class="hr-inner-style"></span></span></div>

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>             

			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
