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
			$html .= self::createLabel($labelId, '<span>+</span><span>-</span> '.r($description), true);
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
	 *
	 * @return null|string
	 */
	public static function createLabel($id, $description, $allowHtml = false){
		if(!$description){
			return null;
		}
		return '<label'.($id ? ' for="'.r($id).'"' : '').'>'.($allowHtml ? $description : r($description)).'</label>';
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

		$html .= '<input type="'.r($type).'" id="'.r($id).'" name="'.r($id).'" value="'.r($value).'"/>';

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
		$html = self::createLabel(null, $description);

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
	 * Init data object
	 *
	 * @param stdClass $fields    Field data
	 * @param array    $languages Language list
	 *
	 * @return stdClass
	 */
	public static function init(stdClass $fields, array $languages){
		$data = new stdClass();

		self::getData($data, $fields->type, $fields->number, $fields->bool);

		$data->language = Language::getLanguage($languages);

		return $data;
	}

	/**
	 * Fill data object
	 *
	 * @param stdClass $data         Data object
	 * @param array    $typeFields   List of "type" field IDs
	 * @param array    $numberFields List of "number" fields and their default value (id=>defaultValue)
	 * @param array    $boolFields   List of "bool" fields and their default value (id=>defaultValue)
	 *
	 * @return void
	 */
	private static function getData(stdClass $data, array $typeFields, array $numberFields, array $boolFields){
		//type fields (default to TYPE_CURRENT)
		foreach($typeFields as $field){
			if(array_key_exists($field, $_REQUEST) AND in_array($_REQUEST[$field], array(TYPE_NONE, TYPE_OLD, TYPE_CURRENT, TYPE_NEW))){
				$data->$field = $_REQUEST[$field];
			}
			else{
				$data->$field = TYPE_CURRENT;
			}
		}

		//number fields
		foreach($numberFields as $field=>$default){
			if(array_key_exists($field, $_REQUEST)){
				$data->$field = (int)$_REQUEST[$field];
			}
			else{
				$data->$field = $default;
			}
		}

		//bool fields
		foreach($boolFields as $field=>$default){
			if(array_key_exists($field, $_REQUEST)){
				$data->$field = (bool)$_REQUEST[$field];
			}
			elseif(count($_REQUEST)>0){
				$data->$field = false;
			}
			else{
				$data->$field = $default;
			}
		}
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
		$data->critHealing = self::calcCritHeal($data->healing);
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