window.addEvent('domready', function(){

	//helper functions
	var toggleInput = function(el, enabled, value, callback){
		el.set('disabled', !enabled);
		if(!enabled){
			if(el.get('tag')=='input' && el.get('type')=='checkbox'){
				el.set('checked', value || false);
			}
			else{
				el.set('value', value || 0);
			}

			if(callback){
				callback.apply(el);
			}
		}
	};

	var toggleInfo = function(el, enabled){
		el.set('value', (enabled ? 1 : 0));
		document.getElements('label[data-id="'+el.get('id')+'"], #info_'+el.get('id')).setStyle('display', (enabled ? null : 'none'));
	};

	var limitFields = function(elements, limit){
		if(limit<=0 || elements.length<1){
			return;
		}

		var doLimit = function(){
			var value = (this.get('type')=='checkbox' ? 0+this.get('checked') : this.get('value').toInt());

			if(value>limit){
				this.set('value', limit);
				value = limit;
			}

			var remaining = limit - value;
			elements.each(function(el){
				if(el==this){
					return;
				}
				if(el.get('type')=='checkbox'){
					if(remaining==0){
						el.set('checked', false);
					}
					else{
						remaining -= 0+el.get('checked');
					}
				}
				else if(el.get('tag')=='select'){
					var values = el.getElements('option').get('value'),
						max = Math.max.apply(null, values),
						set = Math.min(max, Math.min(el.get('value').toInt(), remaining));

					el.set('value', set);
					remaining -= set;
				}
				else{
					el.set('value', remaining);
					remaining = 0;
				}
			}, this);
		};

		elements.addEvent('change', doLimit);
		doLimit.apply(elements[0]);
	};

	//element checker to toggle element visibility based on input
	var toggleElements = function(){
		var types = {
			'weapon': document.id('weaponType').get('value').toInt(),
			'gloves': document.id('glovesType').get('value').toInt(),
			'chest': document.id('chestType').get('value').toInt()
		};
		var enchants = {
			'weapon': document.id('weaponEnchant').get('value').toInt(),
			'gloves': document.id('glovesEnchant').get('value').toInt(),
			'chest': document.id('chestEnchant').get('value').toInt()
		};
		var globalTypes = window.types,
			globalEnchants = window.enchants;

		//weapon
		toggleInput(document.id('weaponBonusZero'), types.weapon!=globalTypes.new);
		toggleInput(document.id('weaponBonusPlus'), enchants.weapon!=globalEnchants.none);
		toggleInfo(document.id('weaponBonusFix'), types.weapon>=globalTypes.current && enchants.weapon!=globalEnchants.none);
		toggleInfo(document.id('weaponBonusMw'), types.weapon==globalTypes.current && enchants.weapon==globalEnchants.mw.twelve);

		//gloves
		toggleInput(document.id('glovesEnchant'), types.gloves!=globalTypes.none, globalEnchants.none, function(){ enchants.gloves = this.get('value').toInt(); });
		toggleInfo(document.id('glovesBonusBase'), types.gloves==globalTypes.new);
		toggleInput(document.id('glovesBonusZero'), types.gloves!=globalTypes.new && types.gloves!=globalTypes.none);
		toggleInput(document.id('glovesBonusPlus'), types.gloves!=globalTypes.none && enchants.gloves!=globalEnchants.none);
		toggleInput(document.id('glovesBonusMw'), types.gloves==globalTypes.current && types.gloves!=globalTypes.none && enchants.gloves==globalEnchants.mw.twelve, ((types.gloves==globalTypes.new && enchants.gloves==globalEnchants.mw.twelve) ? 3 : 0));
		toggleInput(document.id('glovesEtching'), types.gloves!=globalTypes.none);

		//chest
		toggleInput(document.id('chestEnchant'), types.chest!=globalTypes.none, globalEnchants.none, function(){ enchants.chest = this.get('value').toInt(); });
		toggleInput(document.id('chestBonusBase'), types.chest!=globalTypes.new && types.chest!=globalTypes.none);
		toggleInput(document.id('chestBonusZero'), types.chest!=globalTypes.new && types.chest!=globalTypes.none);
		toggleInput(document.id('chestBonusPlus'),  types.chest!=globalTypes.none && enchants.chest!=globalEnchants.none);
	};
	document.getElements('#weaponType, #weaponEnchant, #glovesType, #glovesEnchant, #chestType, #chestEnchant').addEvent('change', toggleElements);
	toggleElements();

	//cant have more then 3 rings/nacklesses total
	limitFields(document.getElements('#oldJewels, #newJewels'), 3);

	//element checker to toggle jewel set options based on input
	var toggleRings = function(){
		toggleInput(document.id('specialRings'), document.id('oldJewels').get('value').toInt());
	};
	document.getElements('#oldJewels, #newJewels').addEvent('change', toggleRings);
	toggleRings();

	//element checker to toggle jewel set options based on input
	var toggleJewelSets = function(){
		var enabled = {
			'set1': document.id('jewelSet1').get('checked'),
			'set2_1': document.id('jewelSet2_1').get('checked'),
			'set2_2': document.id('jewelSet2_2').get('checked')
		};

		toggleInput(document.id('jewelSet2_1'), (enabled.set1 && !enabled.set2_2), false, function(){ enabled.set2_1 = this.get('checked'); });
		toggleInput(document.id('jewelSet2_2'), (enabled.set1 && !enabled.set2_1));
	};
	document.getElements('#jewelSet1, #jewelSet2_1, #jewelSet2_2').addEvent('change', toggleJewelSets);
	toggleJewelSets();

	//cant use more then 4 zyrks total
	limitFields(document.getElements('#zyrks, #pristineZyrks'), 4);

	//cant have more then 2 earrings total
	limitFields(document.getElements('#oldEarrings, #newEarrings'), 2);

	//cant use more then one glyph since you can only calc for one skill
	limitFields(document.getElements('#glyphPriestHealingCircle, #glyphPriestHealingImmersion, #glyphPriestHealThyself'), 1);

	//cant use more then one noctenium bonus since you can only calc for one skill
	limitFields(document.getElements('#nocteniumPriestFocusHeal, #nocteniumPriestHealingCircle, #nocteniumPriestHealThyself, #nocteniumMysticTitanicFavor'), 1);

	//cant use more then one chest stat since you can only calc for one skill
	limitFields(document.getElements('#classEquipStatPriestFocusHeal, #classEquipStatPriestHealingCircle'), 1);

	//add shortcut methods
	document.getElements('div[data-target]').addEvent('click:relay(li[data-value])', function(e){
		if(e){
			e.preventDefault();
		}
		var input = document.id(this.getParent('div').get('data-target'));
		if(input){
			input.set('value', this.get('data-value')).focus();
		}
	});

	//enable disabled selects on submit so we dont miss out values
	document.getElements('form').addEvent('submit', function(){
		this.getElements('select').set('disabled', false);
	});

	//change language
	document.id('language').addEvent('change', function(){
		this.getParent('form').submit();
	});

});