window.MS = {

	delay: function (fn, tm) {
		window.setTimeout(function () {
			fn();
		}, tm);
	},
	delayPersistent: (function(fn, ms){
		var timer = 0;
		return function(fn, ms){
			clearTimeout(timer);
			timer = setTimeout(fn, ms);
		};
	}())
};
window.boxNeutro = function(id){

  $('.toolbar-header').classList.add('header-neutro');
  $('.toolbar-header').classList.remove('header-true');
  $('.toolbar-header').classList.remove('header-false');

  $('.toolbar-footer').classList.add('footer-neutro');
  $('.toolbar-footer').classList.remove('footer-true');
  $('.toolbar-footer').classList.remove('footer-false');
  $(id).classList.add('box-neutro');
  $(id).classList.remove('box-false');
  $(id).classList.remove('box-true');
};

window.boxTrue = function(id){

  $('.toolbar-header').classList.add('header-true');
  $('.toolbar-header').classList.remove('header-neutro');
  $('.toolbar-header').classList.remove('header-false');

  $('.toolbar-footer').classList.add('footer-true');
  $('.toolbar-footer').classList.remove('footer-neutro');
  $('.toolbar-footer').classList.remove('footer-false');
  $(id).classList.add('box-true');
  $(id).classList.remove('box-false');
  $(id).classList.remove('box-neutro');

	MS.delay(function(){
		id.classList.add('hidden');
	}, 10000);
};

window.boxFalse = function(id){

  $('.toolbar-header').classList.add('header-false');
  $('.toolbar-header').classList.remove('header-neutro');
  $('.toolbar-header').classList.remove('header-true');


  $('.toolbar-footer').classList.add('footer-false');
  $('.toolbar-footer').classList.remove('footer-neutro');
  $('.toolbar-footer').classList.remove('footer-true');
  $(id).classList.add('box-false');
  $(id).classList.remove('box-true');
  $(id).classList.remove('box-neutro');
	MS.delay(function(){
		id.classList.add('hidden');
	}, 10000);
};

window.closeResposta = function(){


	$('.toolbar-header').classList.remove('header-false');
	$('.toolbar-header').classList.remove('header-neutro');
	$('.toolbar-header').classList.remove('header-true');

	$('.toolbar-footer').classList.remove('footer-false');
	$('.toolbar-footer').classList.remove('footer-neutro');
	$('.toolbar-footer').classList.remove('footer-true');
	$('#resposta-ajax').classList.add('hidden');
	MS.delay(function(){
		id.classList.add('hidden');
	}, 10000);
};

window.Render = {

	trimString: function(s){

		var l = 0, r= s.length -1;
		while(l < s.length && s[l] == ' '){

			l++;
		}

		while(r > l && s[r] == ' '){

			r-=1;
		}

		return s.substring(l, r+1);
	},
	compareObjects: function(o1, o2){

		var k = '';
		for(k in o1){

			if(o1[k] != o2[k]){

				return false;
			}
		}

		for(k in o2){

			if(o1[k] != o2[k]){

				return false;
			}
		}

		return true;
	},
	itemExists: function(haystack, needle){

		for(var i = 0; i < haystack.length; i++){

			if(this.compareObjects(haystack[i], needle)){

				return true;
			}
		}

		return false;
	},
	procura: function(arr, s){
		var matches = [], i, key;

		for(i = arr.length; i--;){

			for( key in arr[i]){

				if(arr[i].hasOwnProperty(key) && arr[i][key].indexOf(s) > -1){

					matches.push(arr[i]);
				}
			}
		}

		return matches;
	},
	execute: function(result, renderTo, mascara, maskFirst, maskLast = '', maskEmpty = '', limit = 9999){

		if(result.length !== 0){

			var html = maskFirst;
			if(limit >= 1){

				var limitPadrao = 1;

				for (var cols in result){

					var mask = mascara;

					for (var i in result[cols]){

						mask = mask.split('{{'+i+'}}').join(result[cols][i]);
					}

					mask = mask.split('{{key}}').join((indice - 1));

					if(limitPadrao <= limit){
						total = limitPadrao;
						html += mask;
						limitPadrao = limitPadrao + 1;
					}
					
				}

			}else{

				var indice = '';
				for (var cols in result){

					var mask = mascara;

					for (var ind in result[cols]){

						mask = mask.split('{{'+ind+'}}').join(result[cols][ind]);
					}

					html += mask;
				}
			}

			if(total <= 9){
				total = '0'+total;
			}
			html = html.replace('{{total_resultados}}', total)+maskLast;
					
			return renderTo.html(html);

		}else{

			return renderTo.html(maskEmpty);
		}
	},
	searchFor: function(toSearch, objeto){

		var results = [];
		
		toSearch = this.trimString(toSearch);

		for(var i = 0; i < objeto.length; i++){

			for(var key in objeto[i]){

				if(objeto[i][key].indexOf(toSearch) != -1){

					if(!this.itemExists(results, objeto[i])){

						results.push(objeto[i]);
					}
				}
			}
		}

		return results;
	}
};