<!DOCTYPE HTML>
<html>
	<head>
		<?php require('constants.php'); ?>
		<?php require('functions.php'); ?>
		<?php require('locale/languages.php'); ?>

		<?php
		//get data
		$data = new stdClass();
		getData($data, $typeFields, $numberFields, $languages);

		//load language
		require('locale/'.$data->language.'.php');
		$desc = (object)$descriptions;

		//translation preperations
		$boolValues = array(1 => $desc->yes, 0 => $desc->no);
		$weaponNames = array_map(function($step) use ($desc){
			return $desc->weaponNames[$step];
		}, $weaponNames);
		$skills->mystic = array_map(function($skill) use ($desc){
			return $desc->skillNames[$skill];
		}, array_flip($skills->mystic));
		$skills->priest = array_map(function($skill) use ($desc){
			return $desc->skillNames[$skill];
		}, array_flip($skills->priest));
		?>

		<meta charset="utf-8" />
		<title><?php e($desc->title); ?></title>

		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>
		<script src="ui.js"></script>
	</head>
	<body>

		<header>
			<h1><?php e($desc->title); ?></h1>
		</header>

		<form action="" method="post">
			<?php
			//calculate
			if(array_key_exists('submitButton', $_REQUEST)){
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
					<legend><?php e($desc->result); ?></legend>

					<?php echo createInfo('weaponHeal', $desc->resultWeapon, f($weaponHealBonus, 1).' %', null, true); ?>
					<?php echo createInfo('glovesHeal', $desc->resultGloves, f($glovesHealBonus, 1).' %', null, true); ?>
					<?php echo createInfo('jewelsHeal', $desc->resultJewels, f($jewelsHealBonus, 1).' %', null, true); ?>
					<?php echo createInfo('crystalsHeal', $desc->resultCrystals, f($crystalHealBonus, 1).' %', null, true); ?>
					<?php echo createSpacing(); ?>

					<?php if($data->includeTargetBonus): ?>
						<?php echo createInfo('targetHeal', $desc->resultTarget, f($targetHealBonus, 1).' %', null, true); ?>
						<?php echo createSpacing(); ?>
					<?php endif; ?>

					<?php echo createInfo('healOutput', $desc->resultHeal, f($healing), null, true); ?>
				</fieldset>
				<?php
			}
			?>

			<?php echo createSelect('language', null, $data->language, array_unique($languages)); ?>

			<fieldset>
				<legend><?php e($desc->base); ?></legend>

				<?php echo createInput('weaponBase', $desc->baseWeapon, $data->weaponBase); ?>
				<?php echo createInfoList('weaponBaseMystic', $desc->mysticWeapons, array_combine($weapons->mystic, $weaponNames), 'weaponBase'); ?>
				<?php echo createInfoList('weaponBasePriest', $desc->priestWeapons, array_combine($weapons->priest, $weaponNames), 'weaponBase'); ?>

				<?php echo createInput('skillBase', $desc->baseSkill, $data->skillBase); ?>
				<?php echo createInfoList('skillBaseMystic', $desc->mysticSkills, $skills->mystic, 'skillBase'); ?>
				<?php echo createInfoList('skillBasePriest', $desc->priestSkills, $skills->priest, 'skillBase'); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->weapon); ?></legend>

				<?php echo createSelect('weaponType', $desc->weaponType, $data->weaponType, array(
					//TYPE_NONE		=> $desc->weaponTypeNone,
					TYPE_OLD 		=> $desc->weaponTypeOld,
					TYPE_CURRENT 	=> $desc->weaponTypeCurrent,
					TYPE_NEW 		=> $desc->weaponTypeNew
				)); ?>
				<?php echo createSelect('weaponBonusBase', $desc->weaponBase, $data->weaponBonusBase, $boolValues); ?>
				<?php echo createSelect('weaponBonusZero', $desc->weaponZero, $data->weaponBonusZero, $boolValues); ?>
				<?php echo createSelect('weaponBonusPlus', $desc->weaponPlus, $data->weaponBonusPlus, $boolValues); ?>
				<?php echo createInfo('weaponBonusFix', $desc->weaponFix, $desc->yes, $data->weaponBonusFix); ?>
				<?php echo createInfo('weaponBonusMw', $desc->weaponMw, $desc->yes, $data->weaponBonusMw); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->gloves); ?></legend>

				<?php echo createSelect('glovesType', $desc->glovesType, $data->glovesType, array(
					//TYPE_NONE		=> $desc->glovesTypeNone,
					TYPE_OLD 		=> $desc->glovesTypeOld,
					TYPE_CURRENT 	=> $desc->glovesTypeCurrent,
					TYPE_NEW 		=> $desc->glovesTypeNew
				)); ?>
				<?php echo createInfo('glovesBonusBase', $desc->glovesBase, $desc->yes, $data->glovesBonusBase); ?>
				<?php echo createSelect('glovesBonusZero', $desc->glovesZero, $data->glovesBonusZero, $boolValues); ?>
				<?php echo createSelect('glovesBonusPlus', $desc->glovesPlus, $data->glovesBonusPlus, $boolValues); ?>
				<?php echo createSelect('glovesBonusMw', $desc->glovesMw, $data->glovesBonusMw, range(0, 3)); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->jewels); ?></legend>

				<?php echo createSelect('oldJewels', $desc->jewelsOld, $data->oldJewels, range(0, 3)); ?>
				<?php echo createSelect('newJewels', $desc->jewelsNew, $data->newJewels, range(0, 3)); ?>
				<?php echo createSelect('specialRings', $desc->jewelsSpecial, $data->specialRings, range(0, 2)); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->crystals); ?></legend>

				<?php echo createSelect('zyrks', $desc->crystalsZyrks, $data->zyrks, range(0, 4)); ?>
				<?php echo createSelect('pristineZyrks', $desc->crystalsPristineZyrks, $data->pristineZyrks, range(0, 4)); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->target); ?></legend>

				<?php echo createCheck('includeTargetBonus', $desc->targetInclude, $data->includeTargetBonus); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('chestType', $desc->chestType, $data->chestType, array(
					TYPE_CURRENT 	=> $desc->chestTypeCurrent,
					TYPE_NEW 		=> $desc->chestTypeNew
				)); ?>
				<?php echo createSelect('chestBonusBase', $desc->chestBase, $data->chestBonusBase, $boolValues); ?>
				<?php echo createSelect('chestBonusZero', $desc->chestZero, $data->chestBonusZero, $boolValues); ?>
				<?php echo createSelect('chestBonusPlus', $desc->chestPlus, $data->chestBonusPlus, $boolValues); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('oldEarrings', $desc->earringsOld, $data->oldEarrings, range(0, 2)); ?>
				<?php echo createSelect('newEarrings', $desc->earringsNew, $data->newEarrings, range(0, 2)); ?>
				<?php echo createSpacing(); ?>

				<?php echo createSelect('heartPotion', $desc->targetHeartPotion, $data->heartPotion, $boolValues); ?>
			</fieldset>

			<fieldset>
				<legend><?php e($desc->info); ?></legend>
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
