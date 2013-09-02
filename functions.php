<?php

/**
 * echo escaped text
 *
 * @param string $text Text to escape and echo
 *
 * @return void
 */
function e($text){
	echo r($text);
}

/**
 * return escaped text
 *
 * @param string $text Text to escape
 *
 * @return string
 */
function r($text){
	return htmlspecialchars($text);
}

/**
 * format number
 *
 * @param integer $number The number being formatted
 * @param integer $comma  [optional] Sets the number of decimal points (default 0)
 *
 * @return string
 */
function f($number, $comma = 0){
	return number_format($number, $comma, ',', '.');
}

/**
 * create url
 *
 * @param string $path Path to file. may be empty for current url or only param part beginning with ? to add to current url
 *
 * @return string
 */
function createUrl($path = null){
	$url = ((isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] AND !in_array(strtolower($_SERVER['HTTPS']), array('off','no'))) ? 'https' : 'http').'://';
	$url .= $_SERVER['HTTP_HOST'];
	$url .= ($path ? ((string)$path[0]=='?' ? str_replace('index.php', '', $_SERVER['SCRIPT_NAME']).$path : $path) : str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

	return $url;
}


/**
 * Class for creating UI elements
 */
abstract class UI {

	/**
	 * Create legend element
	 *
	 * @param string      $description Description text
	 * @param string|null $labelId     [optional] Label element ID (default null)
	 *
	 * @return string
	 */
	public static function createLegend($description, $labelId = null){
		$html = '<legend>';
		if($labelId){
			$html .= self::createLabel($labelId, '<span>[ + ]</span><span>[ - ]</span> '.r($description), true);
		}
		else{
			$html .= r($description);
		}
		$html .= '</legend>';

		return $html;
	}

	/**
	 * Create label element
	 *
	 * @param string $id          Element ID
	 * @param string $description Description text
	 * @param bool   $allowHtml   [optional] Show description direct without escaping to allow html (default false)
	 * @param string $dataId      [optional] ID stored in data-id attribute (default null)
	 *
	 * @return null|string
	 */
	public static function createLabel($id, $description, $allowHtml = false, $dataId = null){
		if(!$description){
			return null;
		}
		return '<label'.($id ? ' for="'.r($id).'"' : '').($dataId ? ' data-id="'.r($dataId).'"' : '').'>'.($allowHtml ? $description : r($description)).'</label>';
	}

	/**
	 * Create input
	 *
	 * @param string $id          Element ID
	 * @param string $description Description text
	 * @param string $value       Current value
	 * @param string $type        [optional] Input type (default 'number')
	 *
	 * @return string
	 */
	public static function createInput($id, $description, $value, $type='number'){
		$html = self::createLabel($id, $description);

		$html .= '<input type="'.r($type).'" id="'.r($id).'" name="'.r($id).'" value="'.r($value).'" '.($type=='number' ? 'min="0"' : '').'/>';

		return $html;
	}

	/**
	 * Create select
	 *
	 * @param string $id          Element ID
	 * @param string $description Description text
	 * @param string $current     Current value
	 * @param array  $values      List of values (value=>description)
	 *
	 * @return string
	 */
	public static function createSelect($id, $description, $current, array $values){
		$html = self::createLabel($id, $description);

		$html .= '<select size="1" name="'.r($id).'" id="'.r($id).'">';
		foreach($values as $k=>$v){
			$html .= '<option value="'.r($k).'" '.($current==$k ? 'selected="selected"' : '').'>'.r($v).'</option>';
		}
		$html .= '</select>';

		return $html;
	}

	/**
	 * Create info field
	 *
	 * @param string      $id          Element ID
	 * @param string      $description Description text
	 * @param string      $info        Info text
	 * @param string|null $value       [optional] Hidden value (defualt null)
	 * @param bool        $selectable  [optional] Changes html element type so text is selectable (default false)
	 *
	 * @return string
	 */
	public static function createInfo($id, $description, $info, $value = null, $selectable = false){
		$html = self::createLabel(null, $description, false, $id);

		$html .= '<input '.($selectable ? 'type="text" readonly="readonly"' : 'type="button" disabled="disabled"').' value="'.r($info).'" id="info_'.r($id).'"/>';
		if($value!==null){
			$html .= '<input type="hidden" name="'.r($id).'" id="'.r($id).'" value="'.r($value).'"/>';
		}

		return $html;
	}

	/**
	 * Create checkbox
	 *
	 * @param string $id          Element ID
	 * @param string $description Description text
	 * @param bool   $checked     Checked state
	 *
	 * @return string
	 */
	public static function createCheck($id, $description, $checked){
		$html = self::createLabel($id, $description);

		$html .= '<input type="checkbox" value="1" id="'.r($id).'" name="'.r($id).'" '.($checked ? 'checked="checked"' : '').'/>';

		return $html;
	}

	/**
	 * Create info list
	 *
	 * @param string      $id          Element ID
	 * @param string      $description Description text
	 * @param array       $items       Item list (value=>description)
	 * @param string|null $target      [optional] String for data-target attribute of parent (default: null)
	 *
	 * @return string
	 */
	public static function createInfoList($id, $description, array $items, $target=null){
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

	/**
	 * Create spacing
	 *
	 * @return string
	 */
	public static function createSpacing(){
		return '<hr/>';
	}

}


/**
 * Class for data management
 */
abstract class Data {

	/**
	 * Key for storing data in url
	 *
	 * @var string
	 */
	const URL_KEY = 'd';

	/**
	 * Separator for storing data in url
	 *
	 * @var string
	 */
	const URL_SEPARATOR = '-';

	/**
	 * Init data object
	 *
	 * @param stdClass $fields    Field data
	 * @param array    $languages Language list
	 *
	 * @return stdClass
	 */
	public static function init(stdClass $fields, array $languages){
		$data = new stdClass();
		$data->fields = $fields;

		$loadData = self::parseUrl($data);

		self::getData($data, ($loadData ? : $_POST));

		$data->language = Language::getLanguage($languages);

		return $data;
	}

	/**
	 * Fill data object
	 *
	 * @param stdClass $data          Data object
	 * @param array    $source        Data source array, most likely $_POST
	 *
	 * @return void
	 */
	private static function getData(stdClass $data, array $source){
		//type fields (default to TYPE_CURRENT)
		foreach($data->fields->type as $field){
			if(array_key_exists($field, $source) AND in_array($source[$field], array(TYPE_NONE, TYPE_OLD, TYPE_CURRENT, TYPE_NEW))){
				$data->$field = (int)$source[$field];
			}
			else{
				$data->$field = TYPE_CURRENT;
			}
		}

		//echant fields (default to MW+12)
		foreach($data->fields->enchant as $field){
			if(array_key_exists($field, $source) AND in_array($source[$field], array(ENCHANT_NONE, ENCHANT_NINE, ENCHANT_MW_NINE, ENCHANT_MW_TWELVE))){
				$data->$field = (int)$source[$field];
			}
			else{
				$data->$field = ENCHANT_MW_TWELVE;
			}
		}

		//number fields
		foreach($data->fields->number as $field=>$default){
			if(array_key_exists($field, $source)){
				$data->$field = max(0, (int)$source[$field]);
			}
			else{
				$data->$field = $default;
			}
		}

		//bool fields
		foreach($data->fields->bool as $field=>$default){
			if(array_key_exists($field, $source)){
				$data->$field = (bool)$source[$field];
			}
			elseif(count($source)>0){
				$data->$field = false;
			}
			else{
				$data->$field = $default;
			}
		}

		//calculate or not
		$data->doCalculation = isset($source['doCalculation']);
	}

	/**
	 * parse url and get loading data from it
	 *
	 * @param stdClass $data Data object
	 *
	 * @return string|null
	 */
	private static function parseUrl(stdClass $data){
		if(!isset($_GET[self::URL_KEY])){
			return null;
		}

		$urlData = (string)$_GET[self::URL_KEY];

		//check url
		if(!preg_match('/^((\d+)'.self::URL_SEPARATOR.'){5}(\d+)$/', $urlData)){
			return null;
		}

		$split = explode(self::URL_SEPARATOR, $urlData);
		$loadData = array();

		if(count($split)!=6){
			return null;
		}

		//part 1: weaponBase
		$loadData['weaponBase'] = $split[0];

		//part 2: skillBase
		$loadData['skillBase'] = $split[1];

		//part 3: types
		foreach($data->fields->type as $i=>$field){
			if(isset($split[2][$i])){
				$loadData[$field] = $split[2][$i];
			}
		}

		//part 4: enchants
		foreach($data->fields->enchant as $i=>$field){
			if(isset($split[3][$i])){
				$loadData[$field] = $split[3][$i];
			}
		}

		//part 5: number keys (remove the first 2 parts since those are the two base values we got above)
		$numberFieldKeys = array_keys($data->fields->number);
		array_shift($numberFieldKeys);
		array_shift($numberFieldKeys);
		foreach($numberFieldKeys as $i=>$field){
			if(isset($split[4][$i])){
				$loadData[$field] = $split[4][$i];
			}
		}

		//part 6: bool keys
		$boolFieldKeys = array_keys($data->fields->bool);
		$split[5] = strrev(decbin($split[5]));
		foreach($boolFieldKeys as $i=>$field){
			if(isset($split[5][$i])){
				$loadData[$field] = $split[5][$i];
			}
		}

		if(count($loadData)<1){
			return null;
		}

		//force submit mode to show results when loading
		$loadData['doCalculation'] = true;

		return $loadData;
	}

	/**
	 * Create url
	 *
	 * @param stdClass $data Data object
	 *
	 * @return string
	 */
	private static function createUrl($data){
		$urlData = array();

		//part 1: weaponBase
		$urlData[] = $data->weaponBase;

		//part 2: skillBase
		$urlData[] = $data->skillBase;

		//part 3: types
		$tmp = '';
		foreach($data->fields->type as $field){
			$tmp .= (int)$data->$field;
		}
		$urlData[] = $tmp;

		//part 4: enchants
		$tmp = '';
		foreach($data->fields->enchant as $field){
			$tmp .= (int)$data->$field;
		}
		$urlData[] = $tmp;

		//part 5: number keys (remove the first 2 parts since those are the two base values we got above)
		$numberFieldKeys = array_keys($data->fields->number);
		array_shift($numberFieldKeys);
		array_shift($numberFieldKeys);
		$tmp = '';
		foreach($numberFieldKeys as $field){
			$tmp .= (int)$data->$field;
		}
		$urlData[] = $tmp;

		//part 6: bool keys
		$boolFieldKeys = array_keys($data->fields->bool);
		$tmp = '';
		foreach($boolFieldKeys as $field){
			$tmp .= (int)$data->$field;
		}
		$urlData[] = bindec(strrev($tmp));

		//create url from data
		return createUrl('?'.self::URL_KEY.'='.implode(self::URL_SEPARATOR, $urlData));
	}

	/**
	 * Get result data
	 *
	 * @param stdClass $data
	 *
	 * @return void
	 */
	public static function getResults(stdClass $data){
		$data->weaponHealBonus = self::sumHealBonusWeapon($data);
		$data->glovesHealBonus = self::sumHealBonusGloves($data);
		$data->jewelsHealBonus = self::sumHealBonusJewels($data);
		$data->crystalHealBonus = self::sumHealBonusCrystals($data);
		$data->healBonus = $data->weaponHealBonus + $data->glovesHealBonus + $data->jewelsHealBonus + $data->crystalHealBonus;

		$data->targetHealBonus = self::sumTargetHealBonus($data);

		$data->healing = self::calcHeal($data->skillBase, $data->weaponBase, $data->healBonus, $data->targetHealBonus);
		self::multiplyHealing($data);
		$data->critHealing = self::calcCritHeal($data->healing);

		$data->url = self::createUrl($data);
	}

	/**
	 * Sum heal bonuses from weapon
	 *
	 * @param stdClass $data Data object
	 *
	 * @return float
	 */
	public static function sumHealBonusWeapon(stdClass $data){
		if($data->weaponType==TYPE_NONE){
			return 0;
		}

		$bonus = 0;
		$isMw = ($data->weaponEnchant==ENCHANT_MW_NINE OR $data->weaponEnchant==ENCHANT_MW_TWELVE);

		//base
		if($data->weaponType!=TYPE_NEW AND $data->weaponBonusBase){
			$bonus += ($isMw ? BONUS_WEAPON_OLD_BASE : BONUS_WEAPON_OLD_PLAIN);
		}
		elseif($data->weaponBonusBase){
			$bonus += ($isMw ? BONUS_WEAPON_NEW : BONUS_WEAPON_NEW_PLAIN);
		}

		//+0 (old and current only)
		if($data->weaponType!=TYPE_NEW AND $data->weaponBonusZero){
			$bonus += ($isMw ? BONUS_WEAPON_OLD_BASE : BONUS_WEAPON_OLD_PLAIN);
		}

		//plus
		if($data->weaponType!=TYPE_NEW AND $data->weaponBonusPlus AND $data->weaponEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_WEAPON_OLD : BONUS_WEAPON_OLD_PLAIN);
		}
		elseif($data->weaponBonusPlus AND $data->weaponEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_WEAPON_NEW : BONUS_WEAPON_NEW_PLAIN);
		}

		//fix (current and new only)
		if($data->weaponType!=TYPE_OLD AND $data->weaponBonusFix AND $data->weaponEnchant!=ENCHANT_NONE){
			$bonus += BONUS_WEAPON_FIX;
		}

		//mw (current only)
		if($data->weaponType==TYPE_CURRENT AND $data->weaponBonusMw AND $data->weaponEnchant==ENCHANT_MW_TWELVE){
			$bonus += BONUS_WEAPON_OLD_MW;
		}

		return $bonus;
	}

	/**
	 * Sum heal bonuses from gloves
	 *
	 * @param stdClass $data Data object
	 *
	 * @return float
	 */
	public static function sumHealBonusGloves(stdClass $data){
		if($data->glovesType==TYPE_NONE){
			return 0;
		}

		$bonus = 0;
		$isMw = ($data->glovesEnchant==ENCHANT_MW_NINE OR $data->glovesEnchant==ENCHANT_MW_TWELVE);

		//base (new only)
		if($data->glovesType==TYPE_NEW AND $data->glovesBonusBase){
			$bonus += ($isMw ? BONUS_GLOVES_NEW : BONUS_GLOVES_NEW_PLAIN);
		}

		//+0 (old and current only)
		if($data->glovesType!=TYPE_NEW AND $data->glovesBonusZero){
			$bonus += ($isMw ? BONUS_GLOVES_OLD_BASE : BONUS_GLOVES_OLD_PLAIN);
		}

		//plus
		if($data->glovesType==TYPE_NEW AND $data->glovesBonusPlus AND $data->glovesEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_GLOVES_NEW : BONUS_GLOVES_NEW_PLAIN);
		}
		elseif($data->glovesBonusPlus AND $data->glovesEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_GLOVES_OLD : BONUS_GLOVES_OLD_PLAIN);
		}

		//mw (current and new only)
		if($data->glovesType==TYPE_CURRENT AND $data->glovesBonusMw > 0 AND $data->glovesEnchant==ENCHANT_MW_TWELVE){
			$bonus += BONUS_GLOVES_OLD_MW / 3 * $data->glovesBonusMw;
		}
		elseif($data->glovesType==TYPE_NEW AND $data->glovesBonusMw AND $data->glovesEnchant==ENCHANT_MW_TWELVE){
			$bonus += BONUS_GLOVES_NEW_MW;
		}

		return $bonus;
	}

	/**
	 * Sum heal bonuses from jewels
	 *
	 * @param stdClass $data Data object
	 *
	 * @return float
	 */
	public static function sumHealBonusJewels(stdClass $data){
		//limit max juwels to 3
		self::limit($data, array('oldJewels', 'newJewels'), 3);

		$bonus = 0;

		$bonus += $data->oldJewels * BONUS_JEWELS_OLD;
		$bonus += $data->newJewels * BONUS_JEWELS_NEW;
		$bonus += $data->specialRings * BONUS_JEWELS_SPECIAL_RING;

		if($data->jewelSet1){
			$bonus += BONUS_JEWELS_SET_1;
		}

		return $bonus;
	}

	/**
	 * Sum heal bonuses from crystals
	 *
	 * @param stdClass $data Data object
	 *
	 * @return float
	 */
	public static function sumHealBonusCrystals(stdClass $data){
		//limit max crystals to 4
		self::limit($data, array('zyrks', 'pristineZyrks'), 4);

		$bonus = 0;

		$bonus += $data->zyrks * BONUS_ZYRK;
		$bonus += $data->pristineZyrks * BONUS_ZYRK_PRISTINE;

		return $bonus;
	}

	/**
	 * Sum heal bonuses from target (jewels, chest and potion)
	 *
	 * @param stdClass $data Data object
	 *
	 * @return float
	 */
	public static function sumTargetHealBonus(stdClass $data){
		//limit max earrings to 2
		self::limit($data, array('oldEarrings', 'newEarrings'), 2);

		if(!$data->includeTargetBonus){
			return 0;
		}

		$bonus = 0;
		$isMw = ($data->chestEnchant==ENCHANT_MW_NINE OR $data->chestEnchant==ENCHANT_MW_TWELVE);

		//earrings
		$bonus += $data->oldEarrings * BONUS_EARRING_OLD;
		$bonus += $data->newEarrings * BONUS_EARRING_NEW;

		//heart potion
		if($data->heartPotion){
			$bonus += BONUS_HEART_POTION;
		}

		//if chest is disabled, stop here
		if($data->chestType==TYPE_NONE){
			return $bonus;
		}

		//base (current only)
		if($data->chestType==TYPE_CURRENT AND $data->chestBonusBase){
			$bonus += ($isMw ? BONUS_CHEST_OLD_BASE : BONUS_CHEST_OLD_PLAIN);
		}

		//+0 (current only)
		if($data->chestType==TYPE_CURRENT AND $data->chestBonusZero){
			$bonus += ($isMw ? BONUS_CHEST_OLD_BASE : BONUS_CHEST_OLD_PLAIN);
		}

		//plus
		if($data->chestType==TYPE_CURRENT AND $data->chestBonusPlus AND $data->chestEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_CHEST_OLD : BONUS_CHEST_OLD_PLAIN);
		}
		elseif($data->chestBonusPlus AND $data->chestEnchant!=ENCHANT_NONE){
			$bonus += ($isMw ? BONUS_CHEST_NEW : BONUS_CHEST_NEW_PLAIN);
		}

		return $bonus;
	}

	/**
	 * Calculate healing
	 *
	 * @param int $skillBase        Skill base heal
	 * @param int $weaponBase       Weapon base heal
	 * @param int $healBonus        [optional] Equip heal bonus (default 0)
	 * @param int $targetHealBonus  [optional] Target heal bonus (default 0)
	 *
	 * @return int
	 */
	public static function calcHeal($skillBase, $weaponBase, $healBonus = 0, $targetHealBonus = 0){
		//Healing done = HealSpellBase * (1 + HPOnWeapon * (1 + BonusHealingDone) / 1000) * (1 + HealingReceivedOnTarget)
		return floor($skillBase * (1 + $weaponBase * (1 + $healBonus/100) / 1000) * (1 + $targetHealBonus/100));
	}

	/**
	 * Calculate crit healing based on normal one
	 *
	 * @param int $heal Normal heal
	 *
	 * @return int
	 */
	public static function calcCritHeal($heal){
		return floor($heal * 1.5);
	}

	/**
	 * Add scaling bonuses to heal output from glyphs, noctenium and class equip bonuses
	 *
	 * @param stdClass $data Data object
	 *
	 * @return void
	 */
	public static function multiplyHealing(stdClass $data){
		$multiplier = 1;

		//glyphs
		if($data->glyphPriestHealingCircle){
			$multiplier += (GLYPH_HEALINGCIRCLE/100);
		}
		elseif($data->glyphPriestHealingImmersion){
			$multiplier += (GLYPH_HEALINGIMMERSION/100);
		}
		elseif($data->glyphPriestHealThyself){
			$multiplier += (GLYPH_HEALTHYSELF/100);
		}

		//class equip
		if($data->classEquipStatPriestFocusHeal){
			$multiplier += (CLASSEQUIP_FOCUSHEAL/100);
		}
		elseif($data->classEquipStatPriestHealingCircle){
			$multiplier += (CLASSEQUIP_HEALINGCIRCLE/100);
		}

		//noctenium (this works on top of the previous bonuses!)
		if($data->nocteniumPriestFocusHeal){
			$multiplier *= (1 + NOCTENIUM_FOCUSHEAL/100);
		}
		elseif($data->nocteniumPriestHealingCircle){
			$multiplier *= (1 + NOCTENIUM_HEALINGCIRCLE/100);
		}
		elseif($data->nocteniumPriestHealThyself){
			$multiplier *= (1 + NOCTENIUM_HEALTHYSELF/100);
		}
		elseif($data->nocteniumMysticTitanicFavor){
			$multiplier *= (1 + NOCTENIUM_TITANICFAVOR/100);
		}

		$data->multiplier = $multiplier;

		$data->healing = floor($data->healing * $multiplier);
	}

	/**
	 * Limit data fields to a total max
	 *
	 * @param stdClass $data   Data object
	 * @param array    $fields Field names
	 * @param int      $limit  Limit max
	 *
	 * @return void
	 */
	private static function limit(stdClass $data, array $fields, $limit){
		$sum = 0;
		foreach($fields as $field){
			$data->$field = min($data->$field, $limit - $sum);
			$sum += $data->$field;
		}
	}

}


/**
 * Class for language management
 */
abstract class Language {

	/**
	 * Init translation and get description object
	 *
	 * @param stdClass $data Data object
	 *
	 * @return stdClass
	 */
	public static function init(stdClass $data){
		$desc = self::loadLanguage($data->language);

		//create bool option array
		$desc->boolValues = array(1 => $desc->yes, 0 => $desc->no);

		return $desc;
	}

	/**
	 * Load translation data from file
	 *
	 * @param string $lang Locale name
	 *
	 * @return stdClass
	 */
	private static function loadLanguage($lang){
		$descriptions = array();

		$locale = 'locale/'.$lang.'.php';
		require($locale);

		return (object)$descriptions;
	}

	/**
	 * Get current language
	 *
	 * @param array $languages Language list
	 *
	 * @return string
	 */
	public static function getLanguage(array $languages){
		return ((array_key_exists('language', $_REQUEST) AND array_key_exists($_REQUEST['language'], $languages)) ? $_REQUEST['language'] : self::getDefaultLanguage($languages));
	}

	/**
	 * Get translated weapon names
	 *
	 * @param array    $weaponNames Weapon names
	 * @param stdClass $desc        Description object
	 *
	 * @return array
	 */
	public static function translateWeaponNames(array $weaponNames, stdClass $desc){
		return array_map(function($step) use ($desc){
			return $desc->weaponNames[$step];
		}, $weaponNames);
	}

	/**
	 * Get translated skills
	 *
	 * @param stdClass $skills Skills
	 * @param stdClass $desc   Description object
	 *
	 * @return stdClass
	 */
	public static function translateSkills(stdClass $skills, stdClass $desc){
		$skills->mystic = array_map(function($skill) use ($desc){
			return $desc->skillNames[$skill];
		}, array_flip($skills->mystic));

		$skills->priest = array_map(function($skill) use ($desc){
			return $desc->skillNames[$skill];
		}, array_flip($skills->priest));

		return $skills;
	}

	/**
	 * Get translated enchantments
	 *
	 * @param array    $enchants Enchantments
	 * @param stdClass $desc     Description object
	 *
	 * @return array
	 */
	public static function translateEnchants(array $enchants, stdClass $desc){
		return array_map(function($enchant) use ($desc){
			return $desc->enchants[$enchant];
		}, $enchants);
	}

	/**
	 * Getting default language specific for user
	 *
	 * @param array $languages Language array
	 *
	 * @return string
	 */
	public static function getDefaultLanguage(array $languages){
		$clientLangs = self::parseClientLang();
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

	/**
	 * Parse client language information
	 * code from http://www.thefutureoftheweb.com/blog/use-accept-language-header
	 *
	 * @return array
	 */
	private static function parseClientLang(){
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
}