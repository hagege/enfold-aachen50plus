<?php
/**
 * Event Submission Form
 * The wrapper template for the event submission form.
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/edit-event.php
 *
 * @since    3.1
 * @version  4.5
 *
 * @var int|string $tribe_event_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! isset( $tribe_event_id ) ) {
	$tribe_event_id = null;
}

?>

<?php tribe_get_template_part( 'community/modules/header-links' ); ?>

<?php do_action( 'tribe_events_community_form_before_template', $tribe_event_id ); ?>

<form method="post" enctype="multipart/form-data" data-datepicker_format="<?php echo esc_attr( tribe_get_option( 'datepickerFormat', 0 ) ); ?>">
	<input type="hidden" name="post_ID" id="post_ID" value="<?php echo absint( $tribe_event_id ); ?>"/>
	<?php wp_nonce_field( 'ecp_event_submission' ); ?>
  
  <!-- aachenerkinder.de: ergänzt um Infos für Veranstalter -->
  <h5>Erfassung von Veranstaltungen</h5>
  <p>Bitte die Veranstaltung <strong>möglichst umfassend</strong> mit allen nötigen Informationen beschreiben. <br>
  Eigene Bilder (Fotos oder Grafiken), Verlinkung auf eigene Seiten, etc. werten die Veranstaltung deutlich auf. 
  Je umfassender die Veranstaltung beschrieben wird, desto eher wird sie z. B. über google auf aachen50plus.de gefunden. </p>
	<!-- Event Title -->

	<?php tribe_get_template_part( 'community/modules/title' ); ?>

	<?php tribe_get_template_part( 'community/modules/description' ); ?>

  <br>
  <!-- aachenerkinder.de: ergänzt um Infos für Serientermine -->
  <h5>Erfassung von Einzelterminen</h5>
  <p>Bei allen "Einzelterminen" braucht nur das Datum sowie Anfangs- und Endzeit des Veranstaltungstages angegeben werden.</p><br>
  <h5>Erfassung von Serienterminen (Ständige Termine)</h5>
  <ol>
    <li>Bei ständigen Terminen (Serienterminen) den ersten Termin mit Datum, Anfangs- und Endzeit eintragen.</li>
    <li>"Mehrere Veranstaltungen planen" anklicken und auswählen, ob der Termin z. B. "wöchentlich" stattfindet.</li>
    <li>Danach z. B. das Enddatum angeben oder die Anzahl der Termine (z. B. 5 für 5 Termine).</li>
    <li>"Füge Ausnahmen hinzu". Hier bitte Termine angeben, an denen die Veranstaltung nicht stattfindet.</li>
  </ol>
 
  <strong>Achten Sie bitte darauf, das richtige Datum für die Veranstaltung anzugeben bzw. auszuwählen.</strong><br>
  <span class="klein">(Leider kommt es immer mal vor, dass das aktuelle Datum statt das Veranstaltungsdatum ausgewählt wird.)</span></p> 
	<?php tribe_get_template_part( 'community/modules/datepickers' ); ?>

  <br><br><br>
		<strong>Bei Verwendung eines Fotos oder eines Bildes bestätigen Sie durch Übermittlung der Veranstaltung, dass Sie die Rechte an dem Foto oder Bild haben.<br> 
      Bitte nur Bilder oder Fotos mit maximal 800 KB hochladen</strong>
	<?php tribe_get_template_part( 'community/modules/image' ); ?>

	<?php tribe_get_template_part( 'community/modules/taxonomy', null, array( 'taxonomy' => Tribe__Events__Main::TAXONOMY ) ); ?>

	<?php tribe_get_template_part( 'community/modules/taxonomy', null, array( 'taxonomy' => 'post_tag' ) ); ?>

	<!-- aachenerkinder.de: hier Veranstaltungsort und Veranstalter rausgenommen -->

	<p>Bitte geben Sie hier die Veranstaltungs - Webseite (URL) an.</p>
	<?php tribe_get_template_part( 'community/modules/website' ); ?>
		<!-- Ergänzung aachen50plus.de -->
    <br>
		<p class="fett">Der Veranstaltungsort und der Hinweis auf das Copyright beim Foto wird veröffentlicht. <br>Alle anderen Daten werden lediglich benötigt, um ggfs. Kontakt aufzunehmen und werden natürlich nicht veröffentlicht.</p>
		<strong>Wichtig: 
    <ol>
      <li>Bitte den Veranstaltungsort immer mit Straße, PLZ und Ort eingeben.</li>
      <li>Wenn Sie ein Bild oder Foto hochladen, müssen Sie zwingend den Namen des Urhebers bzw. Fotografen im Feld "Copyright Foto (Name)" weiter unten eingeben. 
      Ansonsten kann das Bild oder Foto nicht veröffentlicht werden!<br>
      Bei Verwendung eines Fotos oder eines Bildes bestätigen Sie durch Übermittlung der Veranstaltung, dass Sie die Rechte an dem Foto oder Bild haben.
      </li> 
      <li>Bitte nur Bilder oder Fotos mit maximal 800 KB hochladen</li>
    </ol>
    </strong>

	<?php tribe_get_template_part( 'community/modules/custom' ); ?>
  <!-- Premiumeinträge sind in aachen50plus deaktiviert -->
  <!--
  <p class="premium-description">Bei einem kostenpflichtigen Premiumeintrag erscheint ihr Veranstaltungstermin wie im <a href="https://aachenerkinder.de/wp-content/uploads/2016/10/screenshot_premiumveranstaltung.jpg">Beispiel</a>. Außerdem erscheint ihre Veranstaltung auf jeder Seite rechts unter "Premium-Veranstaltungen". Dort werden immer die 5 Veranstaltungen gezeigt, die als nächstes stattfinden. Premiumveranstaltungen können für jede Veranstaltung gebucht werden, die nicht länger als drei Tage dauert.
  Mit der Buchung der Premiumveranstaltung erklären Sie sich mit den <a href="https://aachenerkinder.de/wp-content/uploads/2016/10/AGB_aachenerkinder.de_.pdf" target="_blank">AGB</a> und der <a href="https://aachenerkinder.de/wp-content/uploads/2016/10/Widerrufsbelehrung_und_formular.pdf" target="_blank">Widerrufsbelehrung</a> einverstanden.<br>
  <a class="tribe-events-button" href="https://aachenerkinder.de/wp-content/uploads/2016/12/infos.jpg">Weitere Informationen zu Premium Veranstaltungen</a></p>
  -->

	<?php tribe_get_template_part( 'community/modules/cost' ); ?>

	<?php tribe_get_template_part( 'community/modules/spam-control' ); ?>

	<!-- Ergänzung aachen50plus.de -->
	<p class="fett" align="left">Die Veranstaltung wird von uns in der Regel innerhalb von wenigen Tagen überprüft und bei Fehlern ggfs. korrigiert. 
				Danach wird die Veranstaltung automatisch veröffentlicht. Eine separate Mail über die Veröffentlichung erfolgt nicht, daher empfehlen wir 
				nach einigen Tagen zu kontrollieren, ob sich die Veranstaltung im Terminkalender befindet.</p>
        <strong>Achtung: Bitte nur einmal auf den Button "Veranstaltung übermitteln" klicken, weil sonst der Spam-Schutz ungültig ist und Sie die Veranstaltung evtl. erneut erfassen müssen.</strong>
	<?php tribe_get_template_part( 'community/modules/submit' ); ?>
</form>

<?php do_action( 'tribe_events_community_form_after_template', $tribe_event_id ); ?>
