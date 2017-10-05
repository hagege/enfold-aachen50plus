<?php
/**
 * Email Template
 * The template for the Event Submission Notification Email
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/email-template.php
 *
 * @package Tribe__Events__Community__Main
 * @since  3.6
 * @author Modern Tribe Inc.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();

?>
<html>
	<body>
		<h2><?php echo $post->post_title; ?></h2>
    		<h3><?php $premium = $post->_ecp_custom_7; 
			if ($premium == "ja") {
				echo " ------------------- Achtung: Premium Veranstaltung ------------------- ";
			}
		?></h3>

		<h4><?php echo tribe_get_start_date( $tribe_event_id ); ?> - <?php echo tribe_get_end_date( $tribe_event_id ); ?></h4>

		<hr />

		<p>
			<b><?php printf( __( '%s Venue', 'tribe-events-community' ), $events_label_singular ); ?>:</b>
			<?php echo $post->_ecp_custom_2; ?>
		</p>

		<p>
			<b><?php printf( __( '%s Organizer', 'tribe-events-community' ), $events_label_singular ); ?>:</b>
			<?php echo $post->_ecp_custom_3; ?>
		</p>

		<p>
			<b><?php esc_html_e( 'Email', 'tribe-events-community' ); ?>:</b>
			<?php echo $post->_ecp_custom_5; ?>
		</p>

		<br /><br />

		<p>
			<b><?php esc_html_e( 'Description', 'tribe-events-community' ); ?>:</b>
			<br />
			<?php echo $post->post_content; ?>
		</p>

		<hr />

		<h4><?php
		echo $this->getEditButton( $post, sprintf( __( 'Review %s', 'tribe-events-community' ), $events_label_singular ) );
		if ( 'publish' == $post->post_status ) {
			?> | <a href="<?php echo esc_url( get_permalink( $tribe_event_id ) ); ?>"><?php printf( __( 'View %s', 'tribe-events-community' ), $events_label_singular ); ?></a><?php
		}
		?></h4>
	</body>
</html>
