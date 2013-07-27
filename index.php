<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Tera Heilungsrechner</title>

		<?php require('constants.php'); ?>
		<?php require('functions.php'); ?>

		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>
		<script src="ui.js"></script>
	</head>
	<body>

		<header>
			<h1>Tera Heilungsrechner</h1>
		</header>

		<?php
		//get data
		$data = new stdClass();
		getData($data, $typeFields, $numberFields);

		//calculate
		if(array_key_exists('submit', $_REQUEST)){
			$skillBase = $data->skillBase;
			$weaponBase = $data->weaponBase;
			$weaponHealBonus = sumHealBonusWeapon($data);
			$glovesHealBonus = sumHealBonusGloves($data);
			$jewelsHealBonus = sumHealBonusJewels($data);
			$crystalHealBonus = sumHealBonusCrystals($data);
			$healBonus = $weaponHealBonus + $glovesHealBonus + $jewelsHealBonus + $crystalHealBonus;
			$targetHealBonus = sumTargetHealBonus($data);

			$healing = calc($skillBase, $weaponBase, $healBonus, $targetHealBonus);
			?>
			<fieldset class="result">
				<legend>Ergebnis</legend>

				<?php echo createInfo('weaponHeal', 'heilbonus waffe:', f($weaponHealBonus, 1).' %', null, true); ?>
				<?php echo createInfo('glovesHeal', 'heilbonus handschuhen:', f($glovesHealBonus, 1).' %', null, true); ?>
				<?php echo createInfo('jewelsHeal', 'heilbonus schmuck:', f($jewelsHealBonus, 1).' %', null, true); ?>
				<?php echo createInfo('crystalsHeal', 'heilbonus kristalle:', f($crystalHealBonus, 1).' %', null, true); ?>
				<?php echo createSpacing(); ?>

				<?php if($data->includeTargetBonus): ?>
					<?php echo createInfo('targetHeal', 'heilbonus des ziels:', f($targetHealBonus, 1).' %', null, true); ?>
					<?php echo createSpacing(); ?>
				<?php endif; ?>

				<?php echo createInfo('healOutput', 'geheilte HP:', f($healing), null, true); ?>
			</fieldset>
			<?php
		}
		?>

		<form action="" method="post">
			<fieldset>
				<legend>basiswerte</legend>

				<?php echo createInput('weaponBase', 'basisheilung der waffe', $data->weaponBase); ?>
				<?php echo createInput('skillBase', 'basisheilung des skills', $data->skillBase); ?>
			</fieldset>

			<fieldset>
				<legend>waffe</legend>

				<?php echo createSelect('weaponType', 'typ', $data->weaponType, array(
					//TYPE_NONE		=> 'keine',
					TYPE_OLD 		=> 'alt (mit power als mw bonus)',
					TYPE_CURRENT 	=> 'aktuell (mit heilung als mw bonus)',
					TYPE_NEW 		=> 'neu (mit angr.geschw. als mw bonus)'
				)); ?>
				<?php echo createSelect('weaponBonusBase', 'mit basis heilbonus', $data->weaponBonusBase); ?>
				<?php echo createSelect('weaponBonusZero', 'mit heilbonus bei +0', $data->weaponBonusZero); ?>
				<?php echo createSelect('weaponBonusPlus', 'mit heilbonus auf plusboni', $data->weaponBonusPlus); ?>
				<?php echo createInfo('weaponBonusFix', 'mit heilbonus auf +2/+4', 'ja', $data->weaponBonusFix); ?>
				<?php echo createInfo('weaponBonusMw', 'mit heilbonus auf mw boni', 'ja', $data->weaponBonusMw); ?>
			</fieldset>

			<fieldset>
				<legend>handschuhe</legend>

				<?php echo createSelect('glovesType', 'typ', $data->glovesType, array(
					//TYPE_NONE		=> 'keine',
					TYPE_OLD 		=> 'alt (mit kraft als mw bonus)',
					TYPE_CURRENT 	=> 'aktuell (mit rollbarem mw bonus)',
					TYPE_NEW 		=> 'neu (mit heilung als mw bonus)'
				)); ?>
				<?php echo createInfo('glovesBonusBase', 'mit basis heilbonus', 'ja', $data->glovesBonusBase); ?>
				<?php echo createSelect('glovesBonusZero', 'mit heilbonus bei +0', $data->glovesBonusZero); ?>
				<?php echo createSelect('glovesBonusPlus', 'mit heilbonus auf plusboni', $data->glovesBonusPlus); ?>
				<?php echo createSelect('glovesBonusMw', 'mit heilbonus auf mw boni', $data->glovesBonusMw, array(0, 1, 2, 3)); ?>
			</fieldset>

			<fieldset>
				<legend>schmuck</legend>

				<?php echo createSelect('oldJewels', 'anzahl alter ringe/halsketten mit 4,5%', $data->oldJewels, array(0, 1, 2, 3)); ?>
				<?php echo createSelect('newJewels', 'anzahl neuer ringe/halsketten mit 2%', $data->newJewels, array(0, 1, 2, 3)); ?>
				<?php echo createSelect('specialRings', 'anzahl ringe mit 5% bonus', $data->specialRings, array(0, 1, 2)); ?>
			</fieldset>

			<fieldset>
				<legend>kristalle</legend>

				<?php echo createSelect('zyrks', 'anzahl 1% heilzirkone', $data->zyrks, array(0, 1, 2, 3, 4)); ?>
				<?php echo createSelect('pristineZyrks', 'anzahl 2% heilzirkone', $data->pristineZyrks, array(0, 1, 2, 3, 4)); ?>
			</fieldset>

			<fieldset>
				<legend>heilboni des ziels</legend>

				<?php echo createCheck('includeTargetBonus', 'heilboni des ziels mit einrechnen', $data->includeTargetBonus); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('chestType', 'oberteil des ziels', $data->chestType, array(
					TYPE_CURRENT 	=> 'aktuell',
					TYPE_NEW 		=> 'neu'
				)); ?>
				<?php echo createSelect('chestBonusBase', 'mit basis heilbonus', $data->chestBonusBase); ?>
				<?php echo createSelect('chestBonusZero', 'mit heilbonus bei +0', $data->chestBonusZero); ?>
				<?php echo createSelect('chestBonusPlus', 'mit heilbonus auf plusboni', $data->chestBonusPlus); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('oldEarrings', 'anzahl alter ohrringe des ziels mit 4,5%', $data->oldEarrings, array(0, 1, 2)); ?>
				<?php echo createSelect('newEarrings', 'anzahl neuer ohrringe des ziels mit 2%', $data->newEarrings, array(0, 1, 2)); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('heartPotion', 'ziel nutzt herztrank III', $data->heartPotion); ?>
			</fieldset>

			<fieldset>
				<legend>Hinweise</legend>
				<ul>
					<li>ergebnisse sind gerundet, geringe abweichungen sind normal</li>
					<li>es wird immer von meisterwerk +12 items ausgegangen</li>
					<li>die werte der neuen items sind noch nicht endgültig und können sich noch ändern, was wirklich ist wird sich erst zeigen wenn das patch im westen angekommen ist</li>
					<li>dank für die berechnungsformel geht an <a href="http://tera-forums.enmasse.com/forums/mystic/topics/Guide-Karyudos-Mystic-Guide">Karyudo</a> und alle die sonst beteiligt waren!</li>
				</ul>
			</fieldset>

			<input type="submit" name="submit" value="berechnen"/>

			<footer>
				Rechner &copy; deos.dev@gmail.com 2013
			</footer>
		</form>
	</body>
</html>
