function TextTrie(array){

	if(array == null) array = [];

	var options = {};
	
	function getStep(text){
	
		var step = options;
		for(var i = 0; i<text.length; ++i){
		
			var char = text.charAt(i);
			
			if(step[char] == undefined) return null;
			
			step = step[char];
		}
		
		return step;
	}
	
	function flatten(step, result){
	
		if(step.value != undefined) result.push(step.value);
		
		for(var prop in step){
			
			if(prop.length == 1) flatten(step[prop], result);
		}
		
		return result;
	}
	
	// ------------------------------
	
	function addText(text) {
	
		if(text.length == 0) return;
		
		var step = options;
		for(var i = 0; i<text.length; ++i){
		
			var char = text.charAt(i);
			
			if(step[char] == undefined) step[char] = {};
			
			step = step[char];
		}
		step.value = text;
	}
	
	function getOptions(text) {
		
		step = getStep(text);
		
		if(step == null) return [];
		
		return flatten(step, []);
	}
	
	function contains(text) {
	
		step = getStep(text);
		
		return step != null && step.value != undefined
	}
		
	// ------------------------------
	
	this.addText = addText;
	this.getOptions = getOptions;
	this.contains = contains;
	
	for(var i = 0; i<array.length; ++i) addText(array[i]);
}

function produceSingleAutocomplete(id, optionsTrie) {

	var container = $(document.createElement('div'));
	var element = $(document.createElement('input'));
	var suggestions = $(document.createElement('ul'));
	
	container.append(element);
	container.append(suggestions);
	
	container.addClass('autocomplete');
	element.attr('id', id);
	suggestions.attr('id', id + '_dropdown');
	
	element.keypress(function(){
	
		var text = $(this).val();
		var options = optionsTrie.find(text);
		
		// remove any <li> element in 'suggestions' which is not in 'options'
		// add any element in 'options' as a <li> element in 'suggestions' (if it is not added already)
	});
	
	return container;
}

function makeAutocomplete(select){

	var id = select.attr('id');
	var multiple = select.attr('multiple');
	
	var options = [];
	
	select.children('option').each(function(index){
	
		var element = $(this);
	
		options[index] = element.text();
	});
	
	optionsTrie = new TextTrie(options);
	
	replacement = multiple ? 'Multiple autocomplete dropdowns not supported yet' : produceSingleAutocomplete(id, optionsTrie);
	
	select.replaceWith(replacement);
}