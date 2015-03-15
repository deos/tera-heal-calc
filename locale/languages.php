<?php
//language files
$languages = array(
	'en_US' => 'English',
	'de_DE' => 'Deutsch',
	'pt_BR' => 'Português'
);

//alternative language shortcuts for client lang detection (must have the same values as the corresponding language file entry above!)
$languages += array(
	'en' => $languages['en_US'],
	'de' => $languages['de_DE'],
	'pt' => $languages['pt_BR']
);