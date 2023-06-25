(function($) {
  "use strict";

  $(document).ready(function() {

    var pptitle = $("h3.pptitle").html();
    var logo = $("#adm-logo img").attr("src");
    var table = $('#example').DataTable( {      
      aLengthMenu: [[25, 50, 75, 100,  120, -1], [25, 50, 75, 100,  120, "All"]],
      iDisplayLength: 25,
      responsive: true,
      buttons: [
        {
          extend: 'print',
          title: '',
          customize: function ( win ) {
            $(win.document.body)
            .addClass( 'p-body' )
            .css( 'font-size', '14px' )
            .prepend(
              '<div class="p-heading"><div class="logo"><img src="'+logo+'" style="" /></div><div class="ptitle" ><h3>Station Headquarters Dhaka Cantonment</h3><p>Shaheed Sharani, Dhaka, Bangladesh</p><p>Contact: 01797-585010</p><h4>'+pptitle+'</h4></div><div class="qrcode"></div></div>'
              )
            .append(
              '<div class="sto-wrap" style="display:flex;justify-content:space-between;align-itmes:center;text-align: center; margin:65px 15px 15px;font-size:14px;font-weight: bold;"><span style="border-top: 1px solid #000;width:150px;text-align:center;padding-top:3px;">NCO</span> <span style="border-top: 1px solid #000;width:150px;text-align:center;padding-top:3px;">STO</span> <span style="border-top: 1px solid #000;width:150px;text-align:center;padding-top:3px;">Comd.</span></div>'
              );

            $(win.document.body).find( 'table' )
            .addClass( 'compact print-table' )
            .css( {'font-size': '12px'} );

            $(win.document.body).find( 'thead' )
            .css( {'border-color': 'black'} );

            $(win.document.body).find( 'th' )
            .css( {'color': '#000','padding': '8px','border-color': 'black'} );

            $(win.document.body).find( 'td' )
            .css( {'color': '#000','padding': '8px','border-color': 'black'} );

          }
        }
      ]

    });

    table.on( 'draw', function () {
      var body = $( table.table().body() );

      body.unhighlight();
      body.highlight( table.search() );  
    } );

    table.buttons().container().appendTo( '.content-area .panel-heading' ).css("display", "inline-flex");

    $(".panel-heading .dt-buttons.btn-group button.btn-secondary").addClass("btn-info").removeClass("btn-secondary")

    $(".has_submenu >a").click(function(e) {               
      $(this).parent("li").children('ul.sub-menu').stop(true, false, true).slideToggle(300); // toggle element
      return false;
    });


    var url = window.location.pathname,
    urlRegExp = new RegExp(url.replace(/\/$/,''));    
    $('ul.sidebar-menu li > a').each(function(){
      if(urlRegExp.test($(this).attr('href'))){
        $(this).parent("li").addClass('current');
      }
    });

    // $('input[type="date"]').Zebra_DatePicker();

    //Append chevron down icon in menu
    $("ul.sub-menu").parent("li").addClass('has-sub-menu').children('a').append('<span class="fa fa-chevron-down"></span>');      

      //sidebar menu slideToggle
      $('ul.sidebar-menu > li.has-sub-menu > a, .opened>ul.sub-menu > li > a').click(function(e) {   

        if($(this).parent("li").children("ul").hasClass("sub-menu") ){
          $(this).parent("li").toggleClass("active");
        }     
        $(this).parent("li").children('ul.sub-menu').stop(true, false, true).slideToggle(300); 
        return false;
      });

        // scrollTop
        $(".scrolltotop").on('click', function(){       
          $("html").animate({'scrollTop' : '0'}, 500);            
          return false;
        });

        $(window).scroll( function() {
          var windowpos = $(window).scrollTop();
          if( windowpos >= 50 ) {
            $("a.scrolltotop").fadeIn();
          }
          else {
            $("a.scrolltotop").fadeOut();   
          }
        });

        $("li.current").parent("ul.sub-menu").css("display","block").parent("li").addClass("active");



        $(".checkbox-container .checkmark").on("click", function(){          
          $(this).toggleClass("checked");   
          // Check if has class checked      
          if($(this).hasClass("checked")){            
            $(this).parent(".checkbox-container").siblings('input').attr('readonly', false);
            $(this).parent(".checkbox-container").siblings('select').attr('disabled', false);
          } else {
            $(this).parent(".checkbox-container").siblings('input').attr('readonly', true);
            $(this).parent(".checkbox-container").siblings('select').attr('disabled', true);
          }
        });

  });

})(jQuery);