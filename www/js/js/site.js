var oi = 'oi';
function xhr(href){

		var link = href;  //$(this).attr('href');									
		$.ajax({															 
			url: link,
			type: 'POST',
			data: {'push':'push'},
			cache: false,
			success: function (result) {
				$('.push-conteudo').html(result);
			}
		});

		$('.toolbar-header').removeClass('header-false');
		$('.toolbar-header').removeClass('header-neutro');
		$('.toolbar-header').removeClass('header-true');

		$('.toolbar-footer').removeClass('footer-false');
		$('.toolbar-footer').removeClass('footer-neutro');
		$('.toolbar-footer').removeClass('footer-true');

		window.history.pushState({href: href}, '', href);
};

$(document).ready(function() {

   $(document).on('click', 'a', function () {

	 if(!$(this).attr("data-push")){
	  xhr($(this).attr("href"));
	  return false; //intercept the link
	 }
   });  

   window.addEventListener('popstate', function(e){
	  if(e.state)
		xhr(e.state.href);
   }); 
});

$(document).on('click', 'a', function () {

  if($( ".nav-group-item" ).hasClass( "active" )){
	$( ".nav-group-item" ).removeClass('active');
  }
});

window.boxNeutro = function(id){

  $('.toolbar-header').addClass('header-neutro');
  $('.toolbar-header').removeClass('header-true');
  $('.toolbar-header').removeClass('header-false');

  $('.toolbar-footer').addClass('footer-neutro');
  $('.toolbar-footer').removeClass('footer-true');
  $('.toolbar-footer').removeClass('footer-false');
  $(id).addClass('box-neutro');
  $(id).removeClass('box-false');
  $(id).removeClass('box-true');
};

window.boxTrue = function(id){

  $('.toolbar-header').addClass('header-true');
  $('.toolbar-header').removeClass('header-neutro');
  $('.toolbar-header').removeClass('header-false');

  $('.toolbar-footer').addClass('footer-true');
  $('.toolbar-footer').removeClass('footer-neutro');
  $('.toolbar-footer').removeClass('footer-false');
  $(id).addClass('box-true');
  $(id).removeClass('box-false');
  $(id).removeClass('box-neutro');
};

window.boxFalse = function(id){

  $('.toolbar-header').addClass('header-false');
  $('.toolbar-header').removeClass('header-neutro');
  $('.toolbar-header').removeClass('header-true');


  $('.toolbar-footer').addClass('footer-false');
  $('.toolbar-footer').removeClass('footer-neutro');
  $('.toolbar-footer').removeClass('footer-true');
  $(id).addClass('box-false');
  $(id).removeClass('box-true');
  $(id).removeClass('box-neutro');
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
	execute: function(result, renderTo, mascara, maskFirst, limit = 15){

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
			html = html.replace('{{total_resultados}}', total);
					
			return renderTo.html(html);

		}else{

			return renderTo.html('Nenhum resultado encontrado');
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



$(document).ready(function() {

	$('#procuracliente').bind("keyup", function(){
		var search = Render.searchFor($('#procuracliente').val(), clientes);

		var maskFirst = `<li class="list-group-item"><div class="media-body"><p>encontramos {{total_resultados}} veiculo</p></div></li>`;
		var mask = `
		<li class="list-group-item">
			<img class="img-circle media-object pull-left" src="/img/avatar2.png" width="32" height="32">
			<div class="media-body">
				<strong>{{nome}}</strong>
				<p>{{sexo}} - {{cpf}} - {{descricao}} - {{telefone}}<span style="float: right;">
	<button class="btn btn-secondary" data-push="push" onclick="xhr('/clientes/remover?id={{id}}')">Remover</button>
	<button class="btn btn-primary" data-push="push" onclick="xhr('/clientes/editar?id={{id}}')">Editar</button>
	<span></p>
			</div>
		</li>`;



		Render.execute(search, $('#renderTo'), mask, maskFirst, 2);
	});
});