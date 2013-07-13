<?php

//define constants
define('TYPE_OLD', '-1');
define('TYPE_CURRENT', '0');
define('TYPE_NEW', '1');

define('BONUS_WEAPON_OLD_BASE', 7.5); //7.5% on old weapons at base and +0
define('BONUS_WEAPON_OLD', 8);        //8% on old weapons
define('BONUS_WEAPON_OLD_MW', 4.5);   //3*1.5% on old weapon mw
define('BONUS_WEAPON_NEW', 6);        //6% on new weapons
define('BONUS_WEAPON_FIX', 6);        //2+4% at 2/4 on weapons, current and new

define('BONUS_GLOVES_OLD_BASE', 5.1); //5.1% on old gloves at +0
define('BONUS_GLOVES_OLD', 5.7);      //5.7%% on old gloves
define('BONUS_GLOVES_OLD_MW', 4.5);   //3*1.5% on old gloves mw
define('BONUS_GLOVES_NEW', 3);        //3% on new gloves
define('BONUS_GLOVES_NEW_MW', 6);     //3*2% at on new globes mw

define('BONUS_JEWELS_OLD', 4.5);      //4.5% healing on old rings and nackless
define('BONUS_JEWELS_NEW', 2);        //2% healing on new rings and nackless
define('BONUS_SPECIAL_RING', 5);      //5% bonus on special rings

define('BONUS_CHEST_OLD_BASE', 9.5);  //9.5% recieved bonus with old chest at +0
define('BONUS_CHEST_OLD', 10.4);      //10.4% recieved bonus with old chest
define('BONUS_CHEST_NEW', 6.9);       //6.9% recieved bonus with new chest

define('BONUS_EARRING_OLD', 4.5);     //4.5% recieved bonus with old earrings
define('BONUS_EARRING_NEW', 2);       //2% recieved bonus with new earrings

define('BONUS_HEART_POTION', 17);     //17% recieved bonus with heart potion 3


//fields
$numberFields = array(
	'weaponBase' => 0, 'skillBase' => 0,
	'weaponBonusBase' => 1, 'weaponBonusZero' => 0, 'weaponBonusPlus' => 1,
	'weaponBonusFix' => 1, 'weaponBonusMw' => 1,
	'glovesBonusBase' => 0, 'glovesBonusZero' => 1, 'glovesBonusPlus' => 1,
	'glovesBonusMw' => 3,
	'oldJewels' => 3, 'newJewels' => 0, 'specialRings' => 2,
	'includeTargetBonus' => 0,
	'chestBonusBase' => 1, 'chestBonusZero' => 0, 'chestBonusPlus' => 1,
	'oldEarrings' => 0, 'newEarrings' => 0, 'heartPotion' => 0
);
$typeFields = array('weaponType', 'glovesType', 'chestType');


//set helper functions
function e($text){
	echo r($text);
}

function r($text){
	return htmlspecialchars($text);
}

function f($number, $comma = 0){
	return number_format($number, $comma, ',', '.');
}

function createLabel($id, $description){
	return '<label for="'.r($id).'">'.r($description).'</label>';
}

function createInput($id, $description, $value, $type='number'){
	$html = createLabel($id, $description);
	$html .= '<input type="'.r($type).'" id="'.r($id).'" name="'.r($id).'" value="'.r($value).'"/>';
	return $html;
}

function createSelect($id, $description, $current, array $values = array(1 => 'ja', 0 => 'nein')){
	$html = createLabel($id, $description);
	$html .= '<select size="1" name="'.r($id).'" id="'.r($id).'">';
	foreach($values as $k=>$v){
		$html .= '<option value="'.r($k).'" '.($current==$k ? 'selected="selected"' : '').'>'.r($v).'</option>';
	}
	$html .= '</select>';
	return $html;
}

function createInfo($id, $description, $info, $value = null){
	$html = createLabel($id, $description);
	$html .= '<input type="button" disabled="disabled" value="'.r($info).'" id="info_'.r($id).'"/>';
	if($value!==null){
		$html .= '<input type="hidden" name="'.r($id).'" id="'.r($id).'" value="'.r($value).'"/>';
	}
	return $html;
}

function createCheck($id, $description, $current){
	$html = createLabel($id, $description);
	$html .= '<input type="checkbox" value="1" id="'.r($id).'" name="'.r($id).'" '.($current ? 'checked="checked"' : '').'/>';
	return $html;
}

function createSpacing(){
	return '<hr/>';
}

function sumHealBonusWeapon($data){
	$bonus = 0;

	//base
	if($data->weaponType!=TYPE_NEW AND $data->weaponBonusBase){
		$bonus += BONUS_WEAPON_OLD_BASE;
	}
	elseif($data->weaponBonusBase){
		$bonus += BONUS_WEAPON_NEW;
	}

	//+0 (old and current only)
	if($data->weaponType!=TYPE_NEW AND $data->weaponBonusZero){
		$bonus += BONUS_WEAPON_OLD_BASE;
	}

	//plus
	if($data->weaponType!=TYPE_NEW AND $data->weaponBonusPlus){
		$bonus += BONUS_WEAPON_OLD;
	}
	elseif($data->weaponBonusPlus){
		$bonus += BONUS_WEAPON_NEW;
	}

	//fix (current and new only)
	if($data->weaponType!=TYPE_OLD AND $data->weaponBonusFix){
		$bonus += BONUS_WEAPON_FIX;
	}

	//mw (current only)
	if($data->weaponType==TYPE_CURRENT AND $data->weaponBonusMw){
		$bonus += BONUS_WEAPON_OLD_MW;
	}

	return $bonus;
}

function sumHealBonusGloves($data){
	$bonus = 0;

	//base (new only)
	if($data->glovesType==TYPE_NEW AND $data->glovesBonusBase){
		$bonus += BONUS_GLOVES_NEW;
	}

	//+0 (old and current only)
	if($data->glovesType!=TYPE_NEW AND $data->glovesBonusZero){
		$bonus += BONUS_GLOVES_OLD_BASE;
	}

	//plus
	if($data->glovesType==TYPE_NEW AND $data->glovesBonusPlus){
		$bonus += BONUS_GLOVES_NEW;
	}
	elseif($data->glovesBonusPlus){
		$bonus += BONUS_GLOVES_OLD;
	}

	//mw (current and new only)
	if($data->glovesType==TYPE_CURRENT AND $data->glovesBonusMw > 0){
		$bonus += BONUS_GLOVES_OLD_MW / 3 * $data->glovesBonusMw;
	}
	elseif($data->glovesType==TYPE_NEW AND $data->glovesBonusMw){
		$bonus += BONUS_GLOVES_NEW_MW;
	}

	return $bonus;
}

function sumHealBonusJewels($data){
	//limit max juwels to 3
	if($data->oldJewels + $data->newJewels > 3){
		$data->oldJewels = min(3, $data->oldJewels);
		$data->newJewels = 3 - $data->oldJewels;
	}

	$bonus = 0;

	$bonus += $data->oldJewels * BONUS_JEWELS_OLD;
	$bonus += $data->newJewels * BONUS_JEWELS_NEW;
	$bonus += $data->specialRings * BONUS_SPECIAL_RING;

	return $bonus;
}

function sumTargetHealBonus($data){
	if(!$data->includeTargetBonus){
		return 0;
	}

	//limit max earrings to 2
	if($data->oldEarrings + $data->newEarrings > 2){
		$data->oldEarrings = min(2, $data->oldEarrings);
		$data->newEarrings = 2 - $data->oldEarrings;
	}

	$bonus = 0;

	//base (current only)
	if($data->chestType==TYPE_CURRENT AND $data->chestBonusBase){
		$bonus += BONUS_CHEST_OLD_BASE;
	}

	//+0 (current only)
	if($data->chestType==TYPE_CURRENT AND $data->chestBonusZero){
		$bonus += BONUS_CHEST_OLD_BASE;
	}

	//plus
	if($data->chestType==TYPE_CURRENT AND $data->chestBonusPlus){
		$bonus += BONUS_CHEST_OLD;
	}
	elseif($data->chestBonusPlus){
		$bonus += BONUS_CHEST_NEW;
	}

	$bonus += $data->oldEarrings * BONUS_EARRING_OLD;
	$bonus += $data->newEarrings * BONUS_EARRING_NEW;

	if($data->heartPotion){
		$bonus += BONUS_HEART_POTION;
	}

	return $bonus;
}

function calc($skillBase, $weaponBase, $healBonus = 0, $targetHealBonus = 0){
	//Healing done = HealSpellBase * (1 + HPOnWeapon * (1 + BonusHealingDone) / 1000) * (1 + HealingReceivedOnTarget)
	return floor($skillBase * (1 + $weaponBase * (1 + $healBonus/100) / 1000) * (1 + $targetHealBonus/100));
}

?><!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Tera Heilrechner</title>

		<script src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>

		<style type="text/css">
			html {
				padding: 0px;
				margin: 0px;
			}
			body {
				margin: 0px;
				padding: 20px;
				background-color: #CCC;
				color: #000;
				font-size: 12pt;
			}
			h1 {
				margin: 0px 0px 10px 0px;
			}
			fieldset{
				margin: 0px 0px 10px;
				padding: 0px 10px 10px 10px;
				border: 1px solid black;
				background-color: #FFF;
				line-height: 24px;
				-webkit-border-radius: 5px;
				border-radius: 5px;
			}
			legend, label {
				font-weight: bold;
				text-transform: capitalize;
			}
			legend {
				padding: 2px 7px;
				border: 1px solid black;
				border-bottom-style: none;
				-webkit-border-radius: 5px 5px 0px 0px;
				border-radius: 5px 5px 0px 0px;
				background-color: inherit;
			}
			label, input:not([type="hidden"]):not([type="submit"]), select {
				float: left;
			}
			input[type="button"]{
				border-style: none;
				color: #000;
				background-color: #FFF;
				-webkit-border-radius: 5px;
				border-radius: 5px;
			}
			input[type="submit"]{
				display: block;
				margin: 15px auto 0px;
				font-size: 120%;
			}
			label {
				clear: left;
				display: inline-block;
				width: 300px;
			}
			hr {
				clear: left;
				margin: 0px -10px 10px;
				padding: 10px 0px 0px;
				border-style: none;
				border-bottom: 1px solid black;
			}
			.result {
				background-color: rgba(255, 150, 0, 0.9);
			}
			ul, li {
				margin: 0px;
				padding: 0px;
				list-style: none;
			}
			footer {
				float: right;
				margin: 20px 0px 10px 0px;
				text-align: right;
			}
		</style>

		<script type="text/javascript">
			window.addEvent('domready', function(){
				//helper functions
				var toggleSelect = function(el, enabled, value){
					el.set('disabled', !enabled);
					if(!enabled){
						el.set('value', value || 0);
					}
				};
				var toggleInfo = function(el, enabled){
					el.set('value', (enabled ? 1 : 0));
					document.getElements('label[for="'+el.get('id')+'"], #info_'+el.get('id')).setStyle('display', (enabled ? null : 'none'));
				};
				var limitFields = function(elements, limit){
					var doLimit = function(){
						if(this.get('value').toInt()>limit){
							this.set('value', limit);
						}
						var total = elements.get('value').reduce(function(pv, cv) { return pv.toInt() + cv.toInt(); });
						if(total>limit){
							var remaining = limit - this.get('value').toInt();
							elements.each(function(el){
								if(el==this){
									return;
								}
								if(el.get('tag')=='select'){
									var values = el.getElements('option').get('value'),
										max = Math.max.apply(null, values),
										set = Math.min(max, remaining);

									el.set('value', set);
									remaining -= set;
								}
								else{
									el.set('value', ramaining);
									remaining = 0;
								}
							}, this);
						}
					};
					elements.addEvent('change', doLimit);
					doLimit.apply(elements[0]);
				};

				//hide some weapon stats on specific types
				var changeWeaponFields = function(){
					var type = this.get('value');

					toggleSelect(document.id('weaponBonusZero'), type!=<?php echo TYPE_NEW; ?>);
					toggleInfo(document.id('weaponBonusFix'), type>=<?php echo TYPE_CURRENT; ?>);
					toggleInfo(document.id('weaponBonusMw'), type==<?php echo TYPE_CURRENT; ?>);
				}.bind(document.id('weaponType'));
				document.id('weaponType').addEvent('change', changeWeaponFields);
				changeWeaponFields();

				//hide some gloves stats on specific types
				var changeGlovesFields = function(){
					var type = this.get('value');

					toggleInfo(document.id('glovesBonusBase'), type==<?php echo TYPE_NEW; ?>);
					toggleSelect(document.id('glovesBonusZero'), type!=<?php echo TYPE_NEW; ?>);
					toggleSelect(document.id('glovesBonusMw'), type==<?php echo TYPE_CURRENT; ?>, (type==<?php echo TYPE_NEW; ?> ? 3 : 0));
				}.bind(document.id('glovesType'));
				document.id('glovesType').addEvent('change', changeGlovesFields);
				changeGlovesFields();

				//cant have more then 3 rings/nacklesses total
				limitFields(document.getElements('#oldJewels, #newJewels'), 3);

				//hide some chest stats on specific types
				var changeChestFields = function(){
					var type = this.get('value');

					toggleSelect(document.id('chestBonusBase'), type!=<?php echo TYPE_NEW; ?>);
					toggleSelect(document.id('chestBonusZero'), type!=<?php echo TYPE_NEW; ?>);
				}.bind(document.id('chestType'));
				document.id('chestType').addEvent('change', changeChestFields);
				changeChestFields();

				//cant have more then 2 earrings total
				limitFields(document.getElements('#oldEarrings, #newEarrings'), 2);

				//enable disabled selects on submit so we dont miss out values
				document.getElements('form').addEvent('submit', function(){
					this.getElements('select').set('disabled', false);
				});
			});
		</script>
	</head>
	<body>

		<header>
			<h1>Tera Heilrechner</h1>
		</header>

		<?php

		//get data
		$data = new stdClass();

		//get values
		foreach($numberFields as $field=>$default){
			if(array_key_exists($field, $_REQUEST)){
				$data->$field = (int)$_REQUEST[$field];
			}
			else{
				$data->$field = $default;
			}
		}
		foreach($typeFields as $field){
			if(array_key_exists($field, $_REQUEST) AND in_array($_REQUEST[$field], array(TYPE_OLD, TYPE_CURRENT, TYPE_NEW))){
				$data->$field = $_REQUEST[$field];
			}
			else{
				$data->$field = TYPE_CURRENT;
			}
		}

		//calculate
		if(array_key_exists('submit', $_REQUEST)){
			$skillBase = $data->skillBase;
			$weaponBase = $data->weaponBase;
			$weaponHealBonus = sumHealBonusWeapon($data);
			$glovesHealBonus = sumHealBonusGloves($data);
			$jewelsHealBonus = sumHealBonusJewels($data);
			$healBonus = $weaponHealBonus + $glovesHealBonus + $jewelsHealBonus;
			$targetHealBonus = sumTargetHealBonus($data);

			$healing = calc($skillBase, $weaponBase, $healBonus, $targetHealBonus);
			?>
			<fieldset class="result">
				<legend>Ergebnis</legend>

				<?php echo createInfo('weaponHeal', 'heilbonus waffe:', f($weaponHealBonus, 1).' %'); ?>
				<?php echo createInfo('glovesHeal', 'heilbonus handschuhen:', f($glovesHealBonus, 1).' %'); ?>
				<?php echo createInfo('jewelsHeal', 'heilbonus schmuck:', f($jewelsHealBonus, 1).' %'); ?>
				<?php if($data->includeTargetBonus): ?>
					<?php echo createInfo('targetHeal', 'heilbonus des ziels:', f($targetHealBonus, 1).' %'); ?>
				<?php endif; ?>
				<?php echo createInfo('healOutput', 'geheilte HP:', f($healing, 0, ',', '.')); ?>
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
				</ul>
			</fieldset>

			<input type="submit" name="submit" value="berechnen"/>

			<footer>
				Dank für die Berechnungsformel an <a href="http://tera-forums.enmasse.com/forums/mystic/topics/Guide-Karyudos-Mystic-Guide">Karyudo</a> und alle die sonst beteiligt waren!<br/>
				Rechner &copy; deos.dev@gmail.com 2013
			</footer>
		</form>
	</body>
</html>
