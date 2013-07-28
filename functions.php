<?php

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
	if(!$id OR !$description){
		return false;
	}
	return '<label for="'.r($id).'">'.r($description).'</label>';
}

function createInput($id, $description, $value, $type='number'){
	$html = createLabel($id, $description);

	$html .= '<input type="'.r($type).'" id="'.r($id).'" name="'.r($id).'" value="'.r($value).'"/>';

	return $html;
}

function createSelect($id, $description, $current, array $values){
	$html = createLabel($id, $description);

	$html .= '<select size="1" name="'.r($id).'" id="'.r($id).'">';
	foreach($values as $k=>$v){
		$html .= '<option value="'.r($k).'" '.($current==$k ? 'selected="selected"' : '').'>'.r($v).'</option>';
	}
	$html .= '</select>';

	return $html;
}

function createInfo($id, $description, $info, $value = null, $selectable = false){
	$html = createLabel($id, $description);

	$html .= '<input '.($selectable ? 'type="text" readonly="readonly"' : 'type="button" disabled="disabled"').' value="'.r($info).'" id="info_'.r($id).'"/>';
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

function createInfoList($id, $description, array $items, $target=null){
	$html = '<div id="'.r($id).'" '.($target ? 'data-target="'.r($target).'"' : '').'>';
	$html .= '<span>'.r($description).'</span>';
	$html .= '<ul>';
	foreach($items as $itemId=>$itemText){
		$html .= '<li data-value='.r($itemId).'>'.r($itemText).'</li>';
	}
	$html .= '</ul>';
	$html .= '</div>';

	return $html;
}

function createSpacing(){
	return '<hr/>';
}

function sumHealBonusWeapon($data){
	if($data->weaponType==TYPE_NONE){
		return 0;
	}

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
	if($data->glovesType==TYPE_NONE){
		return 0;
	}

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

function sumHealBonusCrystals($data){
	//limit max crystals to 4
	if($data->zyrks + $data->pristineZyrks > 4){
		$data->zyrks = min(4, $data->zyrks);
		$data->pristineZyrks = 4 - $data->zyrks;
	}

	$bonus = 0;

	$bonus += $data->zyrks * BONUS_ZYRK;
	$bonus += $data->pristineZyrks * BONUS_ZYRK_PRISTINE;

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


function getData(stdClass $data, $typeFields, $numberFields, array $languages){
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
		if(array_key_exists($field, $_REQUEST) AND in_array($_REQUEST[$field], array(TYPE_NONE, TYPE_OLD, TYPE_CURRENT, TYPE_NEW))){
			$data->$field = $_REQUEST[$field];
		}
		else{
			$data->$field = TYPE_CURRENT;
		}
	}

	$data->language = ((array_key_exists('language', $_REQUEST) AND array_key_exists($_REQUEST['language'], $languages)) ? $_REQUEST['language'] : getDefaultLanguage($languages));
};

function getDefaultLanguage(array $languages){
	$clientLangs = parseClientLang();
	$languageFiles = array_unique($languages);

	//check client languages for what i can get you
	foreach($clientLangs as $key=>$relevance){
		$key = str_replace('-', '_', $key);
		if(array_key_exists($key, $languages)){
			return array_search($languages[$key], $languageFiles);
		}
	}

	//use first lang (en) as fallback
	$keys = array_keys($languages);
	return $keys[0];
}

function parseClientLang(){
	//code from http://www.thefutureoftheweb.com/blog/use-accept-language-header

	$langs = array();

	if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
		// break up string into pieces (languages and q factors)
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

		if(count($lang_parse[1])){
			// create a list like "en" => 0.8
			$langs = array_combine($lang_parse[1], $lang_parse[4]);

			// set default to 1 for any without q factor
			foreach($langs as $lang => $val){
				if($val === ''){
					$langs[$lang] = 1;
				}
			}

			// sort list based on value
			arsort($langs, SORT_NUMERIC);
		}
	}

	return $langs;
}