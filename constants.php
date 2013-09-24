<?php

//version
define('VERSION', 'V1.1');

//types
define('TYPE_NONE', 0);                  //no item
define('TYPE_OLD', 1);                   //item pre patch QoA2
define('TYPE_CURRENT', 2);               //item past patch QoA2 (current items)
define('TYPE_NEW', 3);                   //items past patch Fortress (upcoming items)

//enchantments
define('ENCHANT_NONE', 0);               //no enchant or non-enchantable item
define('ENCHANT_NINE', 1);               //enchant to +9
define('ENCHANT_MW_NINE', 2);            //enchant to +9 and masterwork
define('ENCHANT_MW_TWELVE', 3);          //enchant to +12 and masterwork (max)

//weapon
define('BONUS_WEAPON_OLD_PLAIN', 7);     //7% on old non-mw weapons on all stats
define('BONUS_WEAPON_OLD_BASE', 7.5);    //7.5% on old weapons at base and +0
define('BONUS_WEAPON_OLD', 8);           //8% on old weapons
define('BONUS_WEAPON_OLD_MW', 4.5);      //3*1.5% on old weapon mw
define('BONUS_WEAPON_NEW_PLAIN', 4.5);   //4.5% on new non-mw weapons
define('BONUS_WEAPON_NEW', 6);           //6% on new weapons
define('BONUS_WEAPON_FIX', 6);           //2+4% at 2/4 on weapons, current and new

//gloves
define('BONUS_GLOVES_OLD_PLAIN', 4.5);   //4.5% on old non-mw gloves on all stats
define('BONUS_GLOVES_OLD_BASE', 5.1);    //5.1% on old gloves at +0
define('BONUS_GLOVES_OLD', 5.7);         //5.7%% on old gloves
define('BONUS_GLOVES_OLD_MW', 4.5);      //3*1.5% on old gloves mw
define('BONUS_GLOVES_NEW_PLAIN', 2.25);  //2.25% on old non-mw gloves
define('BONUS_GLOVES_NEW', 3);           //3% on new gloves
define('BONUS_GLOVES_NEW_MW', 4.5);      //4.5% at on new globes mw

//jewels
define('BONUS_JEWELS_OLD', 4.5);         //4.5% healing on old rings and nackless
define('BONUS_JEWELS_NEW', 2);           //2% healing on new rings and nackless
define('BONUS_JEWELS_SPECIAL_RING', 5);  //5% bonus on special rings
define('BONUS_JEWELS_SET_1', 3);         //3% set bonus on upcoming jewels (set 1 since there may be more in the future)

//zyrks
define('BONUS_ZYRK', 1);                 //1% healing from healing zyrk
define('BONUS_ZYRK_PRISTINE', 2);        //2% healing from pristine healing zyrk

//chest
define('BONUS_CHEST_OLD_PLAIN', 8.6);    //8.6% recieved bonus with old non-mw chests on all stats
define('BONUS_CHEST_OLD_BASE', 9.5);     //9.5% recieved bonus with old chest at +0
define('BONUS_CHEST_OLD', 10.4);         //10.4% recieved bonus with old chest
define('BONUS_CHEST_NEW_PLAIN', 4.5);    //4.5% recieved bonus with new non-mw chest
define('BONUS_CHEST_NEW', 6);            //6% recieved bonus with new chest

//earrings
define('BONUS_EARRING_OLD', 4.3);        //4.3% recieved bonus with old earrings
define('BONUS_EARRING_NEW', 3.2);        //3.2% recieved bonus with new earrings

//potion
define('BONUS_HEART_POTION', 17);        //17% recieved bonus with heart potion 3

//glyphs
define('GLYPH_HEALINGCIRCLE', 10);		//10% glyph for priest healing circle
define('GLYPH_HEALINGIMMERSION', 20);	//20% glyph for priest healing immersion
define('GLYPH_HEALTHYSELF', 20);		//20% glyph for priest heal thyself

//noctenium
define('NOCTENIUM_FOCUSHEAL', 30);		//30% noctenium bonus for priest focus heal
define('NOCTENIUM_HEALINGCIRCLE', 30);	//30% noctenium bonus for priest healing circle
define('NOCTENIUM_HEALTHYSELF', 30);	//30% noctenium bonus for priest heal thyself
define('NOCTENIUM_TITANICFAVOR', 30);	//30% noctenium bonus for mystic titanic favor

//class equip
define('CLASSEQUIP_FOCUSHEAL', 15);		//15% equip bonus for priest focus heal
define('CLASSEQUIP_HEALINGCIRCLE', 10);	//10% equip bonus for priest healing circle


//fields
$fields = new stdClass();
$fields->type = array('weaponType', 'glovesType', 'chestType');
$fields->enchant = array('weaponEnchant', 'glovesEnchant', 'chestEnchant');
$fields->number = array(
	'weaponBase' => 0, 'skillBase' => 0,
	'weaponBonusBase' => 1, 'weaponBonusZero' => 0, 'weaponBonusPlus' => 1,
	'weaponBonusFix' => 1, 'weaponBonusMw' => 1,
	'glovesBonusBase' => 0, 'glovesBonusZero' => 1, 'glovesBonusPlus' => 1,
	'glovesBonusMw' => 3,
	'oldJewels' => 3, 'newJewels' => 0, 'specialRings' => 2,
	'zyrks' => 0, 'pristineZyrks' => 0,
	'chestBonusBase' => 1, 'chestBonusZero' => 0, 'chestBonusPlus' => 1,
	'oldEarrings' => 0, 'newEarrings' => 0,
	'heartPotion' => 0,
	'jewelSet1' => 0
);
$fields->bool = array(
	'includeTargetBonus' => true,
	'showCrystals' => true, 'showTarget' => true,
	'showGlyphs' => false, 'showNoctenium' => false, 'showClassEquipStats' => false,
	'glyphPriestHealThyself' => false, 'glyphPriestHealingCircle' => false,
	'glyphPriestHealingImmersion' => false,
	'classEquipStatPriestFocusHeal' => false, 'classEquipStatPriestHealingCircle' => false,
	'nocteniumPriestHealThyself' => false, 'nocteniumPriestHealingCircle' => false,
	'nocteniumPriestFocusHeal' => false, 'nocteniumMysticTitanicFavor' => false
);


//weapon base stat list for shortcuts
$weapons = new stdClass();
$weapons->mystic = array(
	5442, 5823, 6231, 6667, 7133
);
$weapons->priest = array(
	5852, 6261, 6700, 7169, 7670
);
$weaponNames = array(
	'abyss',
	'nexus/conjunct',
	'queen/mayhem/adonis',
	'visionmaker/bloodrave/aphrodite/conjunct2',
	'visionmaker2'
);

//skill base stat list for shortcuts
$skills = new stdClass();
$skills->mystic = array(
	'titanicFavor' => 2392
);
$skills->priest = array(
	'focusHeal' => 2360,
	'healingCircle' => 3908,
	'healingImmersion' => 3543,
	'restorativeBurst' => 575,
	'regenerationCircle' => 214,
	'blessingOfBalder' => 73,
	'healThyself' => 2437
);

//enchant levels
$enchants = array(
	ENCHANT_NONE => 'none',
	ENCHANT_NINE => 'nine',
	ENCHANT_MW_NINE => 'mw_nine',
	ENCHANT_MW_TWELVE => 'mw_twelve'
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