<?php

//types
define('TYPE_NONE', '-2');
define('TYPE_OLD', '-1');
define('TYPE_CURRENT', '0');
define('TYPE_NEW', '1');

//weapon
define('BONUS_WEAPON_OLD_BASE', 7.5); //7.5% on old weapons at base and +0
define('BONUS_WEAPON_OLD', 8);        //8% on old weapons
define('BONUS_WEAPON_OLD_MW', 4.5);   //3*1.5% on old weapon mw
define('BONUS_WEAPON_NEW', 6);        //6% on new weapons
define('BONUS_WEAPON_FIX', 6);        //2+4% at 2/4 on weapons, current and new

//gloves
define('BONUS_GLOVES_OLD_BASE', 5.1); //5.1% on old gloves at +0
define('BONUS_GLOVES_OLD', 5.7);      //5.7%% on old gloves
define('BONUS_GLOVES_OLD_MW', 4.5);   //3*1.5% on old gloves mw
define('BONUS_GLOVES_NEW', 3);        //3% on new gloves
define('BONUS_GLOVES_NEW_MW', 6);     //3*2% at on new globes mw

//jewels
define('BONUS_JEWELS_OLD', 4.5);      //4.5% healing on old rings and nackless
define('BONUS_JEWELS_NEW', 2);        //2% healing on new rings and nackless
define('BONUS_SPECIAL_RING', 5);      //5% bonus on special rings

//zyrks
define('BONUS_ZYRK', 1);              //1% healing from healing zyrk
define('BONUS_ZYRK_PRISTINE', 2);     //2% healing from pristine healing zyrk

//chest
define('BONUS_CHEST_OLD_BASE', 9.5);  //9.5% recieved bonus with old chest at +0
define('BONUS_CHEST_OLD', 10.4);      //10.4% recieved bonus with old chest
define('BONUS_CHEST_NEW', 6.9);       //6.9% recieved bonus with new chest

//earrings
define('BONUS_EARRING_OLD', 4.5);     //4.5% recieved bonus with old earrings
define('BONUS_EARRING_NEW', 2);       //2% recieved bonus with new earrings

//potion
define('BONUS_HEART_POTION', 17);     //17% recieved bonus with heart potion 3


//fields
$numberFields = array(
	'weaponBase' => 0, 'skillBase' => 0,
	'weaponBonusBase' => 1, 'weaponBonusZero' => 0, 'weaponBonusPlus' => 1,
	'weaponBonusFix' => 1, 'weaponBonusMw' => 1,
	'glovesBonusBase' => 0, 'glovesBonusZero' => 1, 'glovesBonusPlus' => 1,
	'glovesBonusMw' => 3,
	'oldJewels' => 3, 'newJewels' => 0, 'specialRings' => 2,
	'zyrks' => 0, 'pristineZyrks' => 0,
	'includeTargetBonus' => 0,
	'chestBonusBase' => 1, 'chestBonusZero' => 0, 'chestBonusPlus' => 1,
	'oldEarrings' => 0, 'newEarrings' => 0, 'heartPotion' => 0
);
$typeFields = array('weaponType', 'glovesType', 'chestType');


//type constants for js
?>
<script type="text/javascript">
	window.types = {
		'none': <?php echo TYPE_NONE; ?>,
		'old': <?php echo TYPE_OLD; ?>,
		'current': <?php echo TYPE_CURRENT; ?>,
		'new': <?php echo TYPE_NEW; ?>
	};
</script>