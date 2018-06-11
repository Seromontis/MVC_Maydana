function openURL(href){

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
        window.history.pushState({href: href}, '', href);
}

$(document).ready(function() {

   $(document).on('click', 'a', function () {

     if(!$(this).attr("data-push")){
      openURL($(this).attr("href"));
      return false; //intercept the link
     }
   });  

   window.addEventListener('popstate', function(e){
      if(e.state)
        openURL(e.state.href);
   }); 
});


   $(document).on('click', 'a', function () {

    if($( ".nav-group-item" ).hasClass( "active" )){
      $( ".nav-group-item" ).removeClass('active');
    }

    

  });

window.boxNeutro = function(id){
  $(id).addClass('box-neutro');
  $(id).removeClass('box-false');
  $(id).removeClass('box-true');
};

window.boxTrue = function(id){
  $(id).addClass('box-true');
  $(id).removeClass('box-false');
  $(id).removeClass('box-neutro');
};

window.boxFalse = function(id){
  $(id).addClass('box-false');
  $(id).removeClass('box-true');
  $(id).removeClass('box-neutro');
};