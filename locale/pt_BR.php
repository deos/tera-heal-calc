<?php
$descriptions = array(
	'title'						=> 'Calculadora de Heal Tera',
	'yes'						=> 'Sim',
	'no'						=> 'Não',
	'mystic'					=> 'Mystic',
	'priest'					=> 'Priest',
	'level'						=> 'Level',

	'decimalSeperator'			=> '.',
	'thousandSeperator'			=> ',',

	'calculate'					=> 'Calcular',
	'generateUrl'				=> 'Gerar um URL para esse preset',

	'base'						=> 'Status Base',
	'baseWeapon' 				=> 'Heal base na Arma',
	'baseSkill' 				=> 'Heal base na Skill',

	'type'						=> 'Tipo',
	'enchant'					=> 'Encantamento',

	'weapon'					=> 'Arma',
	'weaponTypeNone' 			=> 'Não calcular a Arma',
	'weaponTypeOld' 			=> 'Arma muito antiga com power nos status masterwork',
	'weaponTypeCurrent' 		=> 'Arma antiga com heal nos status masterwork',
	'weaponTypeNew' 			=> 'Arma atual com attackspeed nos status masterwork',
	'weaponBase' 				=> 'Com heal bônus nos status base',
	'weaponZero' 				=> 'Tem heal bônus no +0',
	'weaponPlus' 				=> 'Tem heal bonus em mais status',
	'weaponFix' 				=> 'Tem heal bonus fixo no +4/+8',
	'weaponMw'	 				=> 'Tem heal bônus nos status masterwork',
	'weaponEtching'				=> 'Weapon etching',

	'gloves'					=> 'Luva',
	'glovesTypeNone' 			=> 'Nao calcular a luva',
	'glovesTypeOld' 			=> 'Luva muito antiga com power nos status masterwork',
	'glovesTypeCurrent'	 		=> 'Luva antiga com status roláveis masterwork',
	'glovesTypeNew' 			=> 'Luva atual com attackspeed nos status masterwork',
	'glovesBase' 				=> 'Com heal bônus nos status base',
	'glovesZero' 				=> 'Tem heal bônus no +0',
	'glovesPlus' 				=> 'Tem heal bônus em mais status',
	'glovesMw' 					=> 'Tem heal bônus nos status masterwork',
	'glovesEtching'				=> 'Gloves etching',

	'jewels'					=> 'Acessórios',
	'jewelsOld' 				=> 'Numero de antigos anéis/colar com 4.52% heal bônus',
	'jewelsNew' 				=> 'Numero de anéis/colar com 2% heal bonus',
	'jewelsSpecial' 			=> 'Numero de antigos anéis com especial 5% heal bonus',
	'necklaceBonus'				=> 'Heal adicional no colar',
	'noNecklaceBonus'			=> 'Nenhum',
	'broochBonus1'				=> 'Broche com 1% heal bônus',
	'broochBonus2'				=> 'Broche com 1.5% heal bonus',
	'jewelSet1'					=> 'Set bónus 2 de healer acessórios',
	'jewelSet2_1'				=> 'Set bônus 2 de healer acessórios',
	'jewelSet2_2'				=> 'Set bônus 5 de healer acessórios PvE',

	'crystals' 					=> 'Cristais',
	'crystalsZyrks' 			=> 'Quantidade de zyrks com 1% heal bonus',
	'crystalsPristineZyrks'		=> 'Quantidade de zyrks com 2% heal bonus',
	'crystalsPristineZyrks2'	=> 'Quantidade de zyrks com 2.5% heal bonus',

	'target'					=> 'Heal bônus no alvo',
	'targetInclude' 			=> 'Incluir heal bônus no alvo',
	'targetHeartPotion' 		=> 'Alvo esta usando heart potion III',

	'chestTypeNone' 			=> 'Não calcular o peito',
	'chestTypeCurrent' 			=> 'Peito antigo',
	'chestTypeNew' 				=> 'Peito atual',
	'chestBase' 				=> 'Tem heal bônus nos status base',
	'chestZero' 				=> 'Tem heal bônus no +0',
	'chestPlus' 				=> 'Tem heal bonus em mais status',

	'earringsOld' 				=> 'Numero de brincos antigos com 4.32% heal bonus',
	'earringsNew' 				=> 'Numero de brincos com 3.2% heal bônus',
	'earringBonusLeft'			=> 'Heal adicional no brinco esquerdo',
	'earringBonusRight'			=> 'Heal adicional no brinco direito',
	'noEarringBonus'			=> 'Nenhum',

	'result'					=> 'Resultado',
	'resultWeapon' 				=> 'Heal bonus na Arma:',
	'resultGloves' 				=> 'Heal bônus na Luva:',
	'resultJewels' 				=> 'Heal bônus nos Acessórios:',
	'resultCrystals' 			=> 'Heal bônus nos Cristais:',
	'resultTarget' 				=> 'Heal bônus no Alvo:',
	'resultMultiplier'			=> 'Multiplicador dos skills boosts',
	'resultHeal' 				=> 'HP Curado:',
	'resultHealCrit'			=> 'Critico na cura HP:',

	'glyphs'					=> 'Glyphs',
	'noctenium'					=> 'Noctenium bônus',
	'classEquipStats'			=> 'Skill roletavel no peito',

	'info'						=> 'Informação',
	'infoTexts'					=> array(
		'Você pode usar um set de acessórios completos ou combinar 2 sets para receber o bônus em 2 itens do mesmo set',
		'Limites de algumas skills são ignorados',
		'Os créditos pela fórmula de cálculo vai para Karyudo e todos os outros envolvidos!'
	),

	'mysticWeapons'				=> 'Armas de Mystic',
	'mysticSkills'				=> 'Skills de Mystic',
	'priestWeapons'				=> 'Armas de Priest',
	'priestSkills'				=> 'Skills de Priest',
	'weaponNames'				=> array(
		60 => array(
			'Abyss',
			'Nexus / Conjunct',
			'Regent / Mayhem / Steadfast',
			'Visionmaker / Bloodrave / Wonderholme / Strikeforce / Patron / Opportune',
			'Nightforge PvE / Nightforge PvP / Devastator / Favored',
			'Archetype / Advantaged'
		),
		65 => array(
			'Ambit/Controvert',
			'Discovery/Defiance',
			'Generation/Renegade'
		)
	),
	'skillNames'				=> array(
		'titanicFavor' 									=> 'Titanic favor',
		'vampiricPulse'									=> 'Vampiric Pulse',
		'focusHeal' 									=> 'Focus heal',
		'healingCircle'									=> 'Healing circle',
		'healingImmersion' 								=> 'Healing immersion',
		'restorativeBurst' 								=> 'Restoration burst',
		'regenerationCircle' 							=> 'Regeneration circle',
		'blessingOfBalder' 								=> 'Blessing of balder',
		'healThyself'									=> 'Heal thyself'
	),
	'enchants'					=> array(
		'none' 											=> 'Não é possivel encantar ou não esta encantada',
		'nine' 											=> 'Encantada até +9',
		'mw_nine'										=> 'Masterwork e encantada até +9',
		'mw_twelve'										=> 'Masterwork e encantada até +12'
	),
	'etchings'					=> array(
		'none'											=> 'Sem etching de heal',
		'etching_1_tmp'									=> 'Healing etching I ephemeral',
		'etching_2_tmp'									=> 'Healing etching II ephemeral',
		'etching_2'										=> 'Healing etching II',
		'etching_3_tmp'									=> 'Healing etching III ephemeral',
		'etching_3'										=> 'Healing etching III'
	)
);


