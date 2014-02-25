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
		$enchants = Language::translateEnchants($enchants, $desc);
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

		<form action="<?php e($_SERVER['SCRIPT_NAME']); ?>" method="post">
			<?php
			//calculate
			if($data->doCalculation){
				Data::getResults($data);
				?>
				<fieldset class="result">
					<?php echo UI::createLegend($desc->result); ?>

					<?php echo UI::createInfo('weaponHeal', $desc->resultWeapon, f($data, 'weaponHealBonus', 2).' %', null, true); ?>
					<?php echo UI::createInfo('glovesHeal', $desc->resultGloves, f($data, 'glovesHealBonus', 2).' %', null, true); ?>
					<?php echo UI::createInfo('jewelsHeal', $desc->resultJewels, f($data, 'jewelsHealBonus', 2).' %', null, true); ?>

					<?php if($data->showCrystals OR $data->crystalHealBonus>0): ?>
						<?php echo UI::createInfo('crystalsHeal', $desc->resultCrystals, f($data, 'crystalHealBonus', 2).' %', null, true); ?>
					<?php endif; ?>
					<?php echo UI::createSpacing(); ?>

					<?php if($data->showTarget OR $data->includeTargetBonus): ?>
						<?php echo UI::createInfo('targetHeal', $desc->resultTarget, f($data, 'targetHealBonus', 2).' %', null, true); ?>
						<?php echo UI::createSpacing(); ?>
					<?php endif; ?>
					<?php echo UI::createSpacing(); ?>

					<?php if($data->multiplier AND $data->multiplier!==1): ?>
						<?php echo UI::createInfo('healMultiplier', $desc->resultMultiplier, '+'.f($data, 'multiplierPercentage', 1).' %', null, true); ?>
						<?php echo UI::createSpacing(); ?>
						<?php echo UI::createSpacing(); ?>
					<?php endif; ?>

					<?php echo UI::createInfo('healOutput', $desc->resultHeal, f($data, 'healing'), null, true); ?>
					<?php echo UI::createInfo('healOutput', $desc->resultHealCrit, f($data, 'critHealing'), null, true); ?>

					<?php echo UI::createCheck('showUrl', null, false); ?>
					<?php echo UI::createLabel('showUrl', $desc->generateUrl); ?>
					<section>
						<?php echo UI::createSpacing(); ?>
						<?php echo UI::createInfo('url', null, $data->url, null, true); ?>
					</section>
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

				<?php echo UI::createSelect('weaponType', $desc->type, $data->weaponType, array(
					TYPE_OLD 		=> $desc->weaponTypeOld,
					TYPE_CURRENT 	=> $desc->weaponTypeCurrent,
					TYPE_NEW 		=> $desc->weaponTypeNew
				)); ?>
				<?php echo UI::createSelect('weaponEnchant', $desc->enchant, $data->weaponEnchant, $enchants); ?>
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('weaponBonusBase', $desc->weaponBase, $data->weaponBonusBase, $desc->boolValues); ?>
				<?php echo UI::createSelect('weaponBonusZero', $desc->weaponZero, $data->weaponBonusZero, $desc->boolValues); ?>
				<?php echo UI::createSelect('weaponBonusPlus', $desc->weaponPlus, $data->weaponBonusPlus, $desc->boolValues); ?>
				<?php echo UI::createInfo('weaponBonusFix', $desc->weaponFix, $desc->yes, $data->weaponBonusFix); ?>
				<?php echo UI::createInfo('weaponBonusMw', $desc->weaponMw, $desc->yes, $data->weaponBonusMw); ?>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->gloves); ?>

				<?php echo UI::createSelect('glovesType', $desc->type, $data->glovesType, array(
					TYPE_NONE		=> $desc->glovesTypeNone,
					TYPE_OLD 		=> $desc->glovesTypeOld,
					TYPE_CURRENT 	=> $desc->glovesTypeCurrent,
					TYPE_NEW 		=> $desc->glovesTypeNew
				)); ?>
				<?php echo UI::createSelect('glovesEnchant', $desc->enchant, $data->glovesEnchant, $enchants); ?>
				<?php echo UI::createSpacing(); ?>

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
				<?php echo UI::createSpacing(); ?>

				<?php echo UI::createSelect('jewelSet2_1', $desc->jewelSet2_1, $data->jewelSet2_1, $desc->boolValues); ?>
				<?php echo UI::createSelect('jewelSet2_2', $desc->jewelSet2_2, $data->jewelSet2_2, $desc->boolValues); ?>
			</fieldset>

			<?php echo UI::createCheck('showCrystals', null, $data->showCrystals); ?>
			<fieldset>
				<?php echo UI::createLegend($desc->crystals, 'showCrystals'); ?>

				<section>
					<?php echo UI::createSelect('zyrks', $desc->crystalsZyrks, $data->zyrks, range(0, 4)); ?>
					<?php echo UI::createSelect('pristineZyrks', $desc->crystalsPristineZyrks, $data->pristineZyrks, range(0, 4)); ?>
				</section>
			</fieldset>

			<?php echo UI::createCheck('showTarget', null, $data->showTarget); ?>
			<fieldset>
				<?php echo UI::createLegend($desc->target, 'showTarget'); ?>

				<section>
					<?php echo UI::createCheck('includeTargetBonus', $desc->targetInclude, $data->includeTargetBonus); ?>
					<?php echo UI::createSpacing(); ?>

					<?php echo UI::createSelect('chestType', $desc->type, $data->chestType, array(
						TYPE_NONE		=> $desc->chestTypeNone,
						TYPE_CURRENT 	=> $desc->chestTypeCurrent,
						TYPE_NEW 		=> $desc->chestTypeNew
					)); ?>
					<?php echo UI::createSelect('chestEnchant', $desc->enchant, $data->chestEnchant, $enchants); ?>
					<?php echo UI::createSelect('chestBonusBase', $desc->chestBase, $data->chestBonusBase, $desc->boolValues); ?>
					<?php echo UI::createSelect('chestBonusZero', $desc->chestZero, $data->chestBonusZero, $desc->boolValues); ?>
					<?php echo UI::createSelect('chestBonusPlus', $desc->chestPlus, $data->chestBonusPlus, $desc->boolValues); ?>
					<?php echo UI::createSpacing(); ?>

					<?php echo UI::createSelect('oldEarrings', $desc->earringsOld, $data->oldEarrings, range(0, 2)); ?>
					<?php echo UI::createSelect('newEarrings', $desc->earringsNew, $data->newEarrings, range(0, 2)); ?>
					<?php echo UI::createSpacing(); ?>

					<?php echo UI::createSelect('heartPotion', $desc->targetHeartPotion, $data->heartPotion, $desc->boolValues); ?>
				</section>
			</fieldset>

			<?php echo UI::createCheck('showGlyphs', null, $data->showGlyphs); ?>
			<fieldset>
				<?php echo UI::createLegend($desc->glyphs, 'showGlyphs'); ?>

				<section>
					<fieldset>
						<?php echo UI::createLegend($desc->priest); ?>

						<?php echo UI::createCheck('glyphPriestHealingCircle', $desc->skillNames['healingCircle'].' +'.GLYPH_HEALINGCIRCLE.'%', $data->glyphPriestHealingCircle); ?>
						<?php echo UI::createCheck('glyphPriestHealingImmersion', $desc->skillNames['healingImmersion'].' +'.GLYPH_HEALINGIMMERSION.'%', $data->glyphPriestHealingImmersion); ?>
						<?php echo UI::createCheck('glyphPriestHealThyself', $desc->skillNames['healThyself'].' +'.GLYPH_HEALTHYSELF.'%', $data->glyphPriestHealThyself); ?>
					</fieldset>
				</section>
			</fieldset>

			<?php echo UI::createCheck('showNoctenium', null, $data->showNoctenium); ?>
			<fieldset>
				<?php echo UI::createLegend($desc->noctenium, 'showNoctenium'); ?>

				<section>
					<fieldset>
						<?php echo UI::createLegend($desc->priest); ?>

						<?php echo UI::createCheck('nocteniumPriestFocusHeal', $desc->skillNames['focusHeal'].' +'.NOCTENIUM_FOCUSHEAL.'%', $data->nocteniumPriestFocusHeal); ?>
						<?php echo UI::createCheck('nocteniumPriestHealingCircle', $desc->skillNames['healingCircle'].' +'.NOCTENIUM_HEALINGCIRCLE.'%', $data->nocteniumPriestHealingCircle); ?>
						<?php echo UI::createCheck('nocteniumPriestHealThyself', $desc->skillNames['healThyself'].' +'.NOCTENIUM_HEALTHYSELF.'%', $data->nocteniumPriestHealThyself); ?>
					</fieldset>
					<fieldset>
						<?php echo UI::createLegend($desc->mystic); ?>

						<?php echo UI::createCheck('nocteniumMysticTitanicFavor', $desc->skillNames['titanicFavor'].' +'.NOCTENIUM_TITANICFAVOR.'%', $data->nocteniumMysticTitanicFavor); ?>
					</fieldset>
				</section>
			</fieldset>

			<?php echo UI::createCheck('showClassEquipStats', null, $data->showClassEquipStats); ?>
			<fieldset>
				<?php echo UI::createLegend($desc->classEquipStats, 'showClassEquipStats'); ?>

				<section>
					<fieldset>
						<?php echo UI::createLegend($desc->priest); ?>

						<?php echo UI::createCheck('classEquipStatPriestFocusHeal', $desc->skillNames['focusHeal'].' +'.CLASSEQUIP_FOCUSHEAL.'%', $data->classEquipStatPriestFocusHeal); ?>
						<?php echo UI::createCheck('classEquipStatPriestHealingCircle', $desc->skillNames['healingCircle'].' +'.CLASSEQUIP_HEALINGCIRCLE.'%', $data->classEquipStatPriestHealingCircle); ?>
					</fieldset>
				</section>
			</fieldset>

			<fieldset>
				<?php echo UI::createLegend($desc->info); ?>
				<ul>
					<?php foreach($desc->infoTexts as $text): ?>
						<li><?php echo str_replace('Karyudo', '<a href="http://tera-forums.enmasse.com/forums/mystic/topics/Guide-Karyudos-Mystic-Guide">Karyudo</a>', $text); ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>

			<input type="submit" name="doCalculation" value="<?php e($desc->calculate); ?>"/>
		</form>

		<footer>
			&copy; deos.dev@gmail.com 2013 (<a href="https://github.com/deos/tera-heal-calc">github</a>)
		</footer>
	</body>
</html>
