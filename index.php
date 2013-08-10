<!DOCTYPE HTML>
<html>
	<head>
		<?php require('constants.php'); ?>
		<?php require('functions.php'); ?>
		<?php require('locale/languages.php'); ?>

		<?php
		//get data
		$data = Data::init($fields, $languages);

		//load language
		$desc = Language::init($data);
		$weaponNames = Language::translateWeaponNames($weaponNames, $desc);
		$skills = Language::translateSkills($skills, $desc);
		?>

		<meta charset="utf-8" />
		<title><?php e($desc->title); ?></title>

		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>
		<script src="ui.js"></script>
	</head>
	<body>

		<header>
			<h1>
				<?php e($desc->title); ?>
				<span><?php e(VERSION); ?></span>
			</h1>
		</header>

		<form action="" method="post">
			<?php
			//calculate
			if(array_key_exists('submitButton', $_REQUEST)){
				Data::getResults($data);
				?>
				<fieldset class="result">
					<?php echo UI::createLegend($desc->result); ?>

					<?php echo UI::createInfo('weaponHeal', $desc->resultWeapon, f($data->weaponHealBonus, 1).' %', null, true); ?>
					<?php echo UI::createInfo('glovesHeal', $desc->resultGloves, f($data->glovesHealBonus, 1).' %', null, true); ?>
					<?php echo UI::createInfo('jewelsHeal', $desc->resultJewels, f($data->jewelsHealBonus, 1).' %', null, true); ?>
					<?php echo UI::createInfo('crystalsHeal', $desc->resultCrystals, f($data->crystalHealBonus, 1).' %', null, true); ?>
					<?php echo UI::createSpacing(); ?>

					<?php if($data->includeTargetBonus): ?>
						<?php echo UI::createInfo('targetHeal', $desc->resultTarget, f($data->targetHealBonus, 1).' %', null, true); ?>
						<?php echo UI::createSpacing(); ?>
					<?php endif; ?>

					<?php echo UI::createInfo('healOutput', $desc->resultHeal, f($data->healing), null, true); ?>
					<?php echo UI::createInfo('healOutput', $desc->resultHealCrit, f($data->critHealing), null, true); ?>
				</fieldset>
				<?php
			}
			?>

			<?php echo UI::createSelect('language', null, $data->language, array_unique($languages)); ?>

			<fieldset>
				<?php echo UI::createLegend($desc->base); ?>

				<?php echo UI::createInput('weaponBase', $desc->baseWeapon, $data->weaponBase); ?>
				<?php echo UI::createInfoList('weaponBaseMystic', $desc->mysticWeapons, array_combine($weapons->mystic, $weaponNames), 'weaponBase'); ?>
				<?php echo UI::createInfoList('weaponBasePriest', $desc->priestWeapons, array_combine($weapons->priest, $weaponNames), 'weaponBase'); ?>

				<?php echo UI::createInput('skillBase', $desc->baseSkill, $data->skillBase); ?>
				<?php echo UI::createInfoList('skillBaseMystic', $desc->mysticSkills, $skills->mystic, 'skillBase'); ?>
				<?php echo UI::createInfoList('skillBasePriest', $desc->priestSkills, $skills->priest, 'skillBase'); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->weapon); ?>

				<?php echo UI::createSelect('weaponType', $desc->weaponType, $data->weaponType, array(
					//TYPE_NONE		=> $desc->weaponTypeNone,
					TYPE_OLD 		=> $desc->weaponTypeOld,
					TYPE_CURRENT 	=> $desc->weaponTypeCurrent,
					TYPE_NEW 		=> $desc->weaponTypeNew
				)); ?>
				<?php echo UI::createSelect('weaponBonusBase', $desc->weaponBase, $data->weaponBonusBase, $desc->boolValues); ?>
				<?php echo UI::createSelect('weaponBonusZero', $desc->weaponZero, $data->weaponBonusZero, $desc->boolValues); ?>
				<?php echo UI::createSelect('weaponBonusPlus', $desc->weaponPlus, $data->weaponBonusPlus, $desc->boolValues); ?>
				<?php echo UI::createInfo('weaponBonusFix', $desc->weaponFix, $desc->yes, $data->weaponBonusFix); ?>
				<?php echo UI::createInfo('weaponBonusMw', $desc->weaponMw, $desc->yes, $data->weaponBonusMw); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->gloves); ?>

				<?php echo UI::createSelect('glovesType', $desc->glovesType, $data->glovesType, array(
					//TYPE_NONE		=> $desc->glovesTypeNone,
					TYPE_OLD 		=> $desc->glovesTypeOld,
					TYPE_CURRENT 	=> $desc->glovesTypeCurrent,
					TYPE_NEW 		=> $desc->glovesTypeNew
				)); ?>
				<?php echo UI::createInfo('glovesBonusBase', $desc->glovesBase, $desc->yes, $data->glovesBonusBase); ?>
				<?php echo UI::createSelect('glovesBonusZero', $desc->glovesZero, $data->glovesBonusZero, $desc->boolValues); ?>
				<?php echo UI::createSelect('glovesBonusPlus', $desc->glovesPlus, $data->glovesBonusPlus, $desc->boolValues); ?>
				<?php echo UI::createSelect('glovesBonusMw', $desc->glovesMw, $data->glovesBonusMw, range(0, 3)); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->jewels); ?>

				<?php echo UI::createSelect('oldJewels', $desc->jewelsOld, $data->oldJewels, range(0, 3)); ?>
				<?php echo UI::createSelect('newJewels', $desc->jewelsNew, $data->newJewels, range(0, 3)); ?>
				<?php echo UI::createSelect('specialRings', $desc->jewelsSpecial, $data->specialRings, range(0, 2)); ?>
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('jewelSet1', $desc->jewelSet1, $data->jewelSet1, $desc->boolValues); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->crystals); ?>

				<?php echo UI::createSelect('zyrks', $desc->crystalsZyrks, $data->zyrks, range(0, 4)); ?>
				<?php echo UI::createSelect('pristineZyrks', $desc->crystalsPristineZyrks, $data->pristineZyrks, range(0, 4)); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->target); ?>

				<?php echo UI::createCheck('includeTargetBonus', $desc->targetInclude, $data->includeTargetBonus); ?>
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('chestType', $desc->chestType, $data->chestType, array(
					TYPE_CURRENT 	=> $desc->chestTypeCurrent,
					TYPE_NEW 		=> $desc->chestTypeNew
				)); ?>
				<?php echo UI::createSelect('chestBonusBase', $desc->chestBase, $data->chestBonusBase, $desc->boolValues); ?>
				<?php echo UI::createSelect('chestBonusZero', $desc->chestZero, $data->chestBonusZero, $desc->boolValues); ?>
				<?php echo UI::createSelect('chestBonusPlus', $desc->chestPlus, $data->chestBonusPlus, $desc->boolValues); ?>
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('oldEarrings', $desc->earringsOld, $data->oldEarrings, range(0, 2)); ?>
				<?php echo UI::createSelect('newEarrings', $desc->earringsNew, $data->newEarrings, range(0, 2)); ?>
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('heartPotion', $desc->targetHeartPotion, $data->heartPotion, $desc->boolValues); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->info); ?>
				<ul>
					<?php foreach($desc->infoTexts as $text): ?>
						<li><?php echo $text; ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>

			<input type="submit" name="submitButton" value="berechnen"/>

			<footer>
				&copy; deos.dev@gmail.com 2013
			</footer>
		</form>
	</body>
</html>
