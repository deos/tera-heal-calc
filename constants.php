<?php

//version
define('VERSION', 'V1.3 PRE');

//types
define('TYPE_NONE', 0);					//no item
define('TYPE_OLD', 1);					//item pre patch QoA2
define('TYPE_CURRENT', 2);				//item past patch QoA2 (current items)
define('TYPE_NEW', 3);					//items past patch Fortress (upcoming items)

//enchantments
define('ENCHANT_NONE', 0);				//no enchant or non-enchantable item
define('ENCHANT_NINE', 1);				//enchant to +9
define('ENCHANT_MW_NINE', 2);			//enchant to +9 and masterwork
define('ENCHANT_MW_TWELVE', 3);			//enchant to +12 and masterwork (max)

//weapon
define('BONUS_WEAPON_OLD_PLAIN', 7);	//7% on old non-mw weapons on all stats
define('BONUS_WEAPON_OLD_BASE', 7.5);	//7.5% on old weapons at base and +0
define('BONUS_WEAPON_OLD', 8);			//8% on old weapons
define('BONUS_WEAPON_OLD_MW', 4.5);		//3*1.5% on old weapon mw
define('BONUS_WEAPON_NEW_PLAIN', 4.5);	//4.5% on new non-mw weapons
define('BONUS_WEAPON_NEW', 6);			//6% on new weapons
define('BONUS_WEAPON_FIX', 6);			//2+4% at 2/4 on weapons, current and new

//gloves
define('BONUS_GLOVES_OLD_PLAIN', 4.52);	//4.52% on old non-mw gloves on all stats
define('BONUS_GLOVES_OLD_BASE', 5.1);	//5.1% on old gloves at +0
define('BONUS_GLOVES_OLD', 5.68);		//5.68% on old gloves
define('BONUS_GLOVES_OLD_MW', 4.5);		//3*1.5% on old gloves mw
define('BONUS_GLOVES_NEW_PLAIN', 2.25);	//2.25% on old non-mw gloves
define('BONUS_GLOVES_NEW', 3);			//3% on new gloves
define('BONUS_GLOVES_NEW_MW', 4.5);		//4.5% at on new globes mw

//jewels
define('BONUS_JEWELS_OLD', 4.52);		//4.5% healing on old rings and necklace
define('BONUS_JEWELS_NEW', 2);			//2% healing on new rings and necklace
define('BONUS_JEWELS_SPECIAL_RING', 5);	//5% bonus on special rings
define('BONUS_JEWELS_SET_1', 3);		//3% set bonus on zenith jewels
define('BONUS_JEWELS_SET_2_1', 3);		//3% set bonus 1st on upcoming jewels
define('BONUS_JEWELS_SET_2_2', 2);		//2% set bonus 2nd on upcoming jewels

//necklace
define('BONUS_NECKLACE_1', 1);			//1% additional healing stat on necklace
define('BONUS_NECKLACE_2', 1.5);		//1.5% additional healing stat on necklace

//brooch
define('BONUS_BROOCH_1', 1);			//1% additional healing stat on brooch
define('BONUS_BROOCH_2', 1.5);			//1.5% additional healing stat on brooch

//zyrks
define('BONUS_ZYRK', 1);				//1% healing from healing zyrk
define('BONUS_ZYRK_PRISTINE', 2);		//2% healing from pristine healing zyrk
define('BONUS_ZYRK_PRISTINE_2', 2.5);	//2.5% healing from pristine healing zyrk 2

//chest
define('BONUS_CHEST_OLD_PLAIN', 8.6);	//8.6% recieved bonus with old non-mw chests on all stats
define('BONUS_CHEST_OLD_BASE', 9.54);	//9.54% recieved bonus with old chest at +0
define('BONUS_CHEST_OLD', 10.44);		//10.44% recieved bonus with old chest
define('BONUS_CHEST_NEW_PLAIN', 4.5);	//4.5% recieved bonus with new non-mw chest
define('BONUS_CHEST_NEW', 6);			//6% recieved bonus with new chest

//earrings
define('BONUS_EARRING_OLD', 4.32);		//4.32% recieved bonus with old earrings
define('BONUS_EARRING_NEW', 3.2);		//3.2% recieved bonus with new earrings

//earring fixed bonus on some sets
define('BONUS_EARRING_FIXED_1', 0.8);	//0.8% recieved bonus from low old earrings
define('BONUS_EARRING_FIXED_2', 1.2);	//1.2% recieved bonus from high old earrings
define('BONUS_EARRING_FIXED_3', 1.0);	//1.0% recieved bonus from low new earrings
define('BONUS_EARRING_FIXED_4', 1.5);	//1.5% recieved bonus from high new earrings

//etchings
define('ETCHING_VALUE_1', 150);			//150 base healing increase from temporary I etching
define('ETCHING_VALUE_2', 208);			//208 base healing increase from temporary II etching
define('ETCHING_VALUE_3', 259);			//259 base healing increase from permanent II etching
define('ETCHING_VALUE_4', 300);			//300 base healing increase from temporary III etching
define('ETCHING_VALUE_5', 370);			//370 base healing increase from permanent III etching

//potion
define('BONUS_HEART_POTION', 17);		//17% recieved bonus with heart potion 3

//glyphs
define('GLYPH_HEALINGCIRCLE', 10);		//10% glyph for priest healing circle
define('GLYPH_HEALINGIMMERSION', 20);	//20% glyph for priest healing immersion
define('GLYPH_HEALTHYSELF', 20);		//20% glyph for priest heal thyself

//noctenium
define('NOCTENIUM_FOCUSHEAL', 5);		//5% noctenium bonus for priest focus heal
define('NOCTENIUM_HEALINGCIRCLE', 5);	//5% noctenium bonus for priest healing circle
define('NOCTENIUM_HEALTHYSELF', 5);		//5% noctenium bonus for priest heal thyself
define('NOCTENIUM_TITANICFAVOR', 5);	//5% noctenium bonus for mystic titanic favor

//class equip
define('CLASSEQUIP_FOCUSHEAL', 15);		//15% equip bonus for priest focus heal
define('CLASSEQUIP_HEALINGCIRCLE', 10);	//10% equip bonus for priest healing circle

//crit heal multiplier
define('CRIT_HEAL_MULTIPLIER', 1.5);	//+50% heal done on crits


//fields
$fields = new stdClass();
$fields->type = array('weaponType', 'glovesType', 'chestType');
$fields->enchant = array('weaponEnchant', 'glovesEnchant', 'chestEnchant');
$fields->number = array(
	'weaponBase' => 0, 'skillBase' => 0,
	'weaponBonusBase' => 0, 'weaponBonusZero' => 0, 'weaponBonusPlus' => 1,
	'weaponBonusFix' => 1, 'weaponBonusMw' => 0,
	'glovesBonusBase' => 1, 'glovesBonusZero' => 0, 'glovesBonusPlus' => 1,
	'glovesBonusMw' => 3,
	'oldJewels' => 0, 'newJewels' => 3, 'specialRings' => 0,
	'zyrks' => 0, 'pristineZyrks' => 0,
	'chestBonusBase' => 0, 'chestBonusZero' => 0, 'chestBonusPlus' => 0,
	'oldEarrings' => 0, 'newEarrings' => 0,
	'heartPotion' => 0,
	'jewelSet1' => 1,
	'jewelSet2_1' => 0, 'jewelSet2_2' => 1,
	'necklaceBonus' => 1,
	'weaponEtching' => 0, 'glovesEtching' => 0,
	'earringBonusLeft' => 0, 'earringBonusRight' => 0,
	'pristineZyrks2' => 0
);
$fields->bool = array(
	'includeTargetBonus' => false,
	'showCrystals' => true, 'showTarget' => false,
	'showGlyphs' => false, 'showNoctenium' => false, 'showClassEquipStats' => false,
	'glyphPriestHealThyself' => false, 'glyphPriestHealingCircle' => false,
	'glyphPriestHealingImmersion' => false,
	'classEquipStatPriestFocusHeal' => false, 'classEquipStatPriestHealingCircle' => false,
	'nocteniumPriestHealThyself' => false, 'nocteniumPriestHealingCircle' => false,
	'nocteniumPriestFocusHeal' => false, 'nocteniumMysticTitanicFavor' => false,
	'broochBonus1' => false, 'broochBonus2' => false
);


//weapon base stat list for shortcuts
$weapons = new stdClass();
$weapons->mystic = array(
	60 => array(5442, 5823, 6231, 6667, 7133, 7299),
	65 => array(7299, 7466, 7633)
);
$weapons->priest = array(
	60 => array(5852, 6261, 6700, 7169, 7670, 7849),
	65 => array(7849, 8028, 8207)
);
$weaponNames = array(
	60 => array(
		'abyss',
		'nexus/conjunct',
		'queen/mayhem/steadfast',
		'visionmaker/bloodrave/wonderholme/strikeforce/patron/opportune',
		'nightforge/devastator/favored',
		'archetype/advantaged',
	),
	65 => array(
		'normal mode set',
		'hard mode set',
		'VM4'
	)
);

//skill base stat list for shortcuts //lvl 65 updates to be enabled
$skills = new stdClass();
$skills->mystic = array(
	'titanicFavor' => 2536 //2547,
	//'vampiricPulse' => 2439
);
$skills->priest = array(
	'focusHeal' => 2360, //2438
	'healingCircle' => 4227, //3981
	'healingImmersion' => 3543, //3937
	'restorativeBurst' => 575, //588
	'regenerationCircle' => 214, //220
	'blessingOfBalder' => 73,
	'healThyself' => 2437 //2447
);

//enchant levels
$enchants = array(
	ENCHANT_NONE => 'none',
	ENCHANT_NINE => 'nine',
	ENCHANT_MW_NINE => 'mw_nine',
	ENCHANT_MW_TWELVE => 'mw_twelve'
);

//etchings
$etchings = array(
	'none',
	'etching_1_tmp',
	'etching_2_tmp',
	'etching_2',
	'etching_3_tmp',
	'etching_3'
);

//etchings to exclude from gloves (using key for method array_diff_key)
$etchingGlovesExclude = array(
	1 => null
);

//necklace bonuses (uses translation noNecklaceBonus for null value, other values are just numbers)
$necklaceBonuses = array(
	null,
	BONUS_NECKLACE_1,
	BONUS_NECKLACE_2
);

//earring fixed bonuses (uses translation noEarringBonus for null value, other values are just numbers)
$earringBonuses = array(
	null,
	BONUS_EARRING_FIXED_1,
	BONUS_EARRING_FIXED_2,
	BONUS_EARRING_FIXED_3,
	BONUS_EARRING_FIXED_4
);


//type constants for js
?>
<script type="text/javascript">
	window.types = {
		'none': <?php echo TYPE_NONE; ?>,
		'old': <?php echo TYPE_OLD; ?>,
		'current': <?php echo TYPE_CURRENT; ?>,
		'new': <?php echo TYPE_NEW; ?>
	};
	window.enchants = {
		'none': <?php echo ENCHANT_NONE; ?>,
		'nine': <?php echo ENCHANT_NINE; ?>,
		'mw' :{
			'nine': <?php echo ENCHANT_MW_NINE; ?>,
			'twelve': <?php echo ENCHANT_MW_TWELVE; ?>
		}
	};
</script>