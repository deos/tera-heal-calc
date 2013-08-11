window.addEvent('domready', function(){

	//helper functions
	var toggleSelect = function(el, enabled, value, callback){
		el.set('disabled', !enabled);
		if(!enabled){
			el.set('value', value || 0);
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
        toggleSelect(document.id('weaponBonusZero'), types.weapon!=globalTypes.new);
        toggleSelect(document.id('weaponBonusPlus'), enchants.weapon!=globalEnchants.none);
        toggleInfo(document.id('weaponBonusFix'), types.weapon>=globalTypes.current && enchants.weapon!=globalEnchants.none);
        toggleInfo(document.id('weaponBonusMw'), types.weapon==globalTypes.current && enchants.weapon==globalEnchants.mw.twelve);

        //gloves
        toggleSelect(document.id('glovesEnchant'), types.gloves!=globalTypes.none, globalEnchants.none, function(){ enchants.gloves = this.get('value').toInt(); });
        toggleInfo(document.id('glovesBonusBase'), types.gloves==globalTypes.new);
        toggleSelect(document.id('glovesBonusZero'), types.gloves!=globalTypes.new && types.gloves!=globalTypes.none);
        toggleSelect(document.id('glovesBonusPlus'), types.gloves!=globalTypes.none && enchants.gloves!=globalEnchants.none);
        toggleSelect(document.id('glovesBonusMw'), types.gloves==globalTypes.current && types.gloves!=globalTypes.none && enchants.gloves==globalEnchants.mw.twelve, ((types.gloves==globalTypes.new && enchants.gloves==globalEnchants.mw.twelve) ? 3 : 0));

        //chest
        toggleSelect(document.id('chestEnchant'), types.chest!=globalTypes.none, globalEnchants.none, function(){ enchants.chest = this.get('value').toInt(); });
        toggleSelect(document.id('chestBonusBase'), types.chest!=globalTypes.new && types.chest!=globalTypes.none);
        toggleSelect(document.id('chestBonusZero'), types.chest!=globalTypes.new && types.chest!=globalTypes.none);
        toggleSelect(document.id('chestBonusPlus'),  types.chest!=globalTypes.none && enchants.chest!=globalEnchants.none);
    };
    document.getElements('#weaponType, #weaponEnchant, #glovesType, #glovesEnchant, #chestType, #chestEnchant').addEvent('change', toggleElements);
    toggleElements();

	//cant have more then 3 rings/nacklesses total
	limitFields(document.getElements('#oldJewels, #newJewels'), 3);

	//cant use more then 4 zyrks total
	limitFields(document.getElements('#zyrks, #pristineZyrks'), 4);

	//cant have more then 2 earrings total
	limitFields(document.getElements('#oldEarrings, #newEarrings'), 2);

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