<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Willkommen bei <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<p><?php echo $this->renderPartial('_version'); ?></p>

<?php

if(Yii::app()->params['users.testmode']) {

?>
<h2>Test-Benutzer</h2>
<ul>
	<li>Admin: admin/admin (als Admin darf man nicht abstimmen)</li>
	<li>weitere User (im Moment 1-4): user1/user1, user2/user2, usw.</li>
</ul>
<p>Anmeldung mit diesen Benutzern ist jederzeit möglich. <i>Diese Benutzer können im Testsystem nicht geändert oder gelöscht werden.</i></p>

<?php

} else {

?>
<h2>Anmeldung</h2>
<p>Für einen Testbenutzer bitte eine E-Mail an <a href="http://www.demokratieforschung.at/arbeitskreise/demokratiesimulation/">Reinhard Hainisch</a> senden.</p>

<?php

}

?>

<p>Willkommen bei Civicracy! Dies ist ein Testsystem.</p>


<!--
<h2>Bekannte Bugs</h2>

<ul>
	<li>Kategorie löschen -&gt; constraint exception</li>
	<li>vermutlich auch: Benutzer löschen -&gt; constraint exception</li>
	<li>user1 -&gt; user3 -&gt; user1 loop: user1 weight falsch</li>
</ul>

<h2>Unvollständige TODO-List</h2>

<ul>
	<li>"Admin-User erstellen" für Setup</li>
	<li>Kategorie-Beschreibung</li>
	<li>CSV-Import von Benutzern über die Admin-Oberfläche</li>
	<li>Anzeigen der Stimmen aller Leute, oder zumindest Top-Ranking (wer wird zum Rat?)</li>
	<li>change credits (im Moment fehlt dazu ein Konzept)</li>
	<li>Historisierung der Wahlen (d.h. meine Stimme im Zeitverlauf), zumindest auf der Datenbank</li>
	<li>Admin sollte nicht gelöscht werden können ;-)</li>
	<li>Stimme ändern: Benutzer, für den vorher abgestimmt wurde, anzeigen (default value)</li>
	<li>Marketingtext für Startseite</li>
</ul>
-->

<p>Viel Spaß mit Civi! -- David Madl</p>