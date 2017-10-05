    (function($){

      $(window).scroll(function(){

        var scrollYpos = $(document).scrollTop();

        var body = $('body');
        var header = $('#header');
        var headerHeight = header.outerHeight();

        if(scrollYpos > headerHeight) {
          header.addClass('fixed');
          body.addClass('is-fixed');
        } else {
          header.removeClass('fixed');
          body.removeClass('is-fixed');
        }

      });

    })(jQuery);




    /*********** GET THE CURRENT GOOGLE MAP STUFF AND MANIPULATE IT ************/
	
      jQuery(document).ready(function($){
	  /*
		/* gab Probleme bei enfold mit dem Menü
        $('body').css({
          'padding-top': $('#header').outerHeight() + 20
        });
      */  
  // toggle Kateforie Auswahl

        $('.tribe-events-filters-group-heading').click(function() {
  $('.tribe-events-filter-group').toggleClass( "cat-open" );
});


      // Hightlight current day in calendar widget 
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var currentDay = d.getFullYear() + '-' +
          ((''+month).length<2 ? '0' : '') + month + '-' +
          ((''+day).length<2 ? '0' : '') + day;
            $('a[data-day = '+currentDay+']').addClass('active-day');

        $(':checkbox').change(function(){


    


          //google.maps.event.trigger(window.wpgmza_map_id, 'resize');


          //enable markecluyster refresh
         // window.MYMAP[1].mc.clearMarkers();

        });

        /* NÄCHSTER TAG FIX */
        $('.tribe-events-day').find('.tribe-events-sub-nav').find('a').on('click',function(e){
          location.href = $(this).attr('href');
          return false;
        });



        /* SHARE POPUP */
        $('.sharebutton').click(function(e){
          e.preventDefault();
          var w = 480;
          var h = 140;
          var left = (screen.width/2)-(w/2);
          var top = (screen.height/2)-(h/2);
          var url = $(this).attr('href');
          var title = $(this).attr('title');
          return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        });



        jQuery("body").on("click", ".wpgmza_checkbox", function() {
          var newHash = [];
          jQuery('.wpgmza_checkbox').each(function(){
            if(jQuery(this).is(':checked')){
              newHash.push(
                jQuery(this).data('name')
              );
            }
          });

          location.hash = '#'+newHash.join(':');

        });

      });





    /********** ADD CATEGORY FILTERING BY URL ********/

    jQuery(window).load(function($){

      var hashCat = location.hash.replace('#','');
      var hashEls = hashCat.split(':');

      for(i=0;i<hashEls.length;i++){
        jQuery('.checkbox-'+hashEls[i]).trigger('click');
      }

    });


