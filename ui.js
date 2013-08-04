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

		toggleSelect(document.id('weaponBonusZero'), type!=window.types.new);
		toggleInfo(document.id('weaponBonusFix'), type>=window.types.current);
		toggleInfo(document.id('weaponBonusMw'), type==window.types.current);
	}.bind(document.id('weaponType'));
	document.id('weaponType').addEvent('change', changeWeaponFields);
	changeWeaponFields();

	//hide some gloves stats on specific types
	var changeGlovesFields = function(){
		var type = this.get('value');

		toggleInfo(document.id('glovesBonusBase'), type==window.types.new);
		toggleSelect(document.id('glovesBonusZero'), type!=window.types.new);
		toggleSelect(document.id('glovesBonusMw'), type==window.types.current, (type==window.types.new ? 3 : 0));
	}.bind(document.id('glovesType'));
	document.id('glovesType').addEvent('change', changeGlovesFields);
	changeGlovesFields();

	//cant have more then 3 rings/nacklesses total
	limitFields(document.getElements('#oldJewels, #newJewels'), 3);

	//cant use more then 4 zyrks total
	limitFields(document.getElements('#zyrks, #pristineZyrks'), 4);

	//hide some chest stats on specific types
	var changeChestFields = function(){
		var type = this.get('value');

		toggleSelect(document.id('chestBonusBase'), type!=window.types.new);
		toggleSelect(document.id('chestBonusZero'), type!=window.types.new);
	}.bind(document.id('chestType'));
	document.id('chestType').addEvent('change', changeChestFields);
	changeChestFields();

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