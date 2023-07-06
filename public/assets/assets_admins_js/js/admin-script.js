$.ajaxSetup({
 headers:{
   'X_CSRF_TOKEN':$('meta[name="_token"]').attr('content')
 }
});
$(document).ready(function() {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $('.check_box_select').change(function (){
   if (this.checked){
    $(this).parent().siblings('input').attr('readonly', false);
    $(this).parent().siblings('select').attr('disabled', false);
  }
  else{
   $(this).parent().siblings('input').attr('readonly', true);
   $(this).parent().siblings('select').attr('disabled', true);
 }
});
  $('input.check_box_select').change(function (){
    var inputValue = $(this).data('input');
    var selectText = $(this).data('select');
    var vehicle = $(this).data('vehicle');
    if (this.checked){
      $(this).parent().siblings('input').val(inputValue);
      $(this).parent().siblings("select").children("option:selected").html(selectText);
      $(this).parent().siblings("select").children("option:selected").val(vehicle);
    }
    else{
     $(this).parent().siblings('input').val('');
     $(this).parent().siblings('input').attr('readonly',true);
     $(this).parent().siblings("select").children("option:selected").html('Select One');
     $(this).parent().siblings("select").attr('readonly',true);
     $(this).parent().siblings("select").children("option:selected").val('');
   }
 });
  $(window).scroll(function() {
    var scrollVal = $(this).scrollTop();
    if ( scrollVal > 110) {
      $('#action-bar').css({'position':'fixed','top' :'0px', 'width':'81.2%'});
    } else {
      $('#action-bar').css({'position':'static','top':'auto', 'width':'100%'});
    }
  });
  $("#driver_photo").on('click',function () {
    $('#DriverPhotoModal').modal({
      show: true,
      backdrop: false
    })
  });
  $("#applicant_photo").click(function () {
    $('#applicantPhotoModal').modal({
      show: true,
      backdrop: false
    })
  });
  var missMatch=new Array(); 
  var file ='';           
  $(document).on('change','.attach_file',function (){
    if (this.checked){
      file =$(this).val();
      missMatch.push(file);
    }else{
     missMatch.pop(file);
   }
 }); 
  var rejectSmsType='';
  $(document).on('click','#file_miss_case',function () {
    if (this.checked){
     $('#mis_matched').attr('hidden',false);
     $('#custom_reason').attr('hidden',true);
     $('form#reject_sms_form')[0].reset();
     rejectSmsType=$(this).val();
   }else{
    $('#custom_reason').attr('hidden',false);
    $('#mis_matched').attr('hidden',true);
    $('form#reject_file_sms_form')[0].reset();
  }
});
  $(document).on('click','#custom_case',function () {
    if (this.checked){
     $('#custom_reason').attr('hidden',false);
     $('#mis_matched').attr('hidden',true);
     $('form#reject_file_sms_form')[0].reset();
     rejectSmsType=$(this).val();
   }else{
     $('#mis_matched').attr('hidden',false);
     $('#custom_reason').attr('hidden',true);
     $('form#reject_sms_form')[0].reset();
   }
 });    
  $('#approve_App').on('click',function(){
   var app_num = $(this).data('number');
   var sticker_delivery_date = $('#sticker_delivery_date').val();
   var sticker_type = $('#sticker_type').val();
   if (sticker_delivery_date!='' && sticker_type!=null){
     $('#err_msg_delDate').attr('hidden',true);
     $('#err_msg_sticker_type').attr('hidden',true);
     swal({
       title: 'Are you sure?',
       text: "Approve this application!",
       type: 'question',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, Approve it!',
       showLoaderOnConfirm: true,
       preConfirm: function() {
         return new Promise(function() {
           $.ajax({
             url: '/stahqdhaka.army.mil.bd/public/application/approve',
             type: 'get',
             data: {
               'app_num':app_num,
               'sticker_type':sticker_type,
               'sticker_delivery_date':sticker_delivery_date,
             },
             dataType: 'json',
             contentType: "application/json; charset=utf-8",
           })
           .done(function(response){
            if(response[1]=="success"){ 
              $.ajax({
               url: '/stahqdhaka.army.mil.bd/public/send-queued-sms/'+response[3],
               type: 'get',
               data: {
               },
               dataType: 'json',
               contentType: "application/json; charset=utf-8",
             })
              swal('Approved!',response[0],'success').then(function(){
                $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]['app_status']+"</span>");
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $('div.app_status_wrapper').after('<div class="col-md-3 sticker_type_wrapper"><span>Sticker Type</span></div><div class="col-md-9"><span>'+response[2]['sticker_category']+'</span></div>'
                  +'<div class="col-md-3"><span>Delivery Date</span></div><div class="col-md-9"><span>'+response[4]+'</span></div>');
                $('.follow-up-table tbody') 
                .prepend('<tr />') 
                .children('tr:first')
                .prepend('<td>#</td><td>'+response[5]['created_at']+'</td><td>'+response[5]['status']+'</td><td>'+response[5]['comment']+'</td><td>on process</td><td>'+response[5]['updated_by']+'</td>');
                location.reload();
              });
            }else if(response[1]=="fail"){
              swal('Not Now!',response[0],'warning').then(function(){
                $("[data-dismiss=modal]").trigger({ type: "click" });
              });
            }else if(response[1]=="not-now"){
              swal('Not Approved!',response[0],'error').then(function(){
                $("[data-dismiss=modal]").trigger({ type: "click" });
              });
            }else if(response[0]=="no slot available"){
              swal('Not This Date!',response[1],'warning').then(function(){
                $("[data-dismiss=modal]").trigger({ type: "click" });
              });
            }
          })
           .fail(function(response){
             swal('Oops...', 'Something went wrong!' , 'error');
           });
         });
       },
       allowOutsideClick: false
     }); 
   }
   else{
    if(sticker_delivery_date==''){
     $('#err_delDate').text('Delivery Date field is required');
     $('#err_msg_delDate').attr('hidden',false);
     $("input#sticker_delivery_date").on("change", function () {
      if($('#sticker_delivery_date').val()!=null){
       $('#err_msg_delDate').attr('hidden',true);
     }
     else{
      $('#err_msg_delDate').attr('hidden',false);
    }
  });
   } 
   if('#sticker_type'==null){
     $('#err_sticker_type').text('Sticker Type field is required');
     $('#err_msg_sticker_type').attr('hidden',false);
     $("input#sticker_type").on("change", function () {
      if($('#').val()!=''){
       $('#err_msg_sticker_type').attr('hidden',true);
     }
     else{
      $('#err_msg_sticker_type').attr('hidden',false);
    }
  });
   }
 }
}); 
$('#reject_App').on('click',function(){
 var app_num = $(this).data('number');
 var custom_sms_text = $('.sms_text').val();
 var sms_id = $('.sms_id').val();
 if(missMatch.length > 0 || custom_sms_text!=''){
   swal({
     title: 'Are you sure?',
     text: "You want to reject this application!",
     type: 'question',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, reject it!',
     showLoaderOnConfirm: true,
     preConfirm: function() {
       return new Promise(function(resolve) {
         $.ajax({
           url: '/stahqdhaka.army.mil.bd/public/application/reject',
           type: 'get',
           data: {
            'app_num':app_num,
            'missMatch':missMatch,
            'custom_sms_text':custom_sms_text,
            'sms_id':sms_id,
          },
          dataType: 'json'
        })
         .done(function(response){
          console.log(response);
          if(response[1]=="success"){
           $.ajax({
            url: '/stahqdhaka.army.mil.bd/public/send-queued-sms/'+response[3],
            type: 'get',
            data: {
            },
            dataType: 'json'
          });
           swal('Rejected!',response[0],'success').then(function(){
            $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]+"</span>");
            $("[data-dismiss=modal]").trigger({ type: "click" });
              $('.follow-up-table tbody') 
                .prepend('<tr />') 
                .children('tr:first')
                .prepend('<td>#</td><td>'+response[4]['created_at']+'</td><td>'+response[4]['status']+'</td><td>'+response[4]['comment']+'</td><td>on process</td><td>'+response[4]['updated_by']+'</td>');
          });
         }else if(response[1]=="fail"){
          swal('Not Now!',response[0],'warning').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });
        }else if(response[1]=="not-now"){
          swal('Not Rejected!',response[0],'error').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });
        }
      })
         .fail(function(response){
           swal('Oops...', 'Something went wrong!' , 'error');
         });
       });
     },

     allowOutsideClick: false     
   });
 }else{
   if(rejectSmsType=="custom_case"){
    swal('Oops...', 'Please Select any SMS Template for which application will be rejected!' , 'error');
  }else{
    swal('Oops...', 'Please Tick any for which application will be rejected!' , 'error');
  }
}  

});
$('#delete_App').on('click',function(){
 var app_num = $(this).data('number');

 swal({
   title: 'Are you sure?',
   text: "You want to delete this application!",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, delete it!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
       $.ajax({
         url: '/stahqdhaka.army.mil.bd/public/application/delete',
         type: 'get',
         data: {
          'app_num':app_num,
        },
        dataType: 'json'
      })
       .done(function(response){

        if(response[0]=='hard-deleted'){
          swal('Deleted!',response[1],'success');
          window.location.href='/home';
        } 
        if(response[0]=='soft-deleted'){
          swal('Deleted!',response[1],'success').then(function(){
            $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]+"</span>");
            $("[data-dismiss=modal]").trigger({ type: "click" });
            location.reload();
          });

        }
        else if(response[0]=='already-deleted'){
          swal('Not Deleted!',response[1],'warning').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });
        }
        else if(response[0]=='fail'){
          swal('Not Deleted!',response[1],'warning').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });;
        }

      })
       .fail(function(response){
         swal('Oops...', 'Something went wrong!' , 'error');
       });
     });
   },
   allowOutsideClick: false
 });
}); 
$('#undo_app').on('click',function(){
 var app_id = $(this).data('id');

 swal({
   title: 'Are you sure?',
   text: "You want to undo this application!",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, undo it!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
       $.ajax({
         url: '/stahqdhaka.army.mil.bd/public/application/undo',
         type: 'get',
         data: {
          'app_id':app_id,
        },
        dataType: 'json'
      })
       .done(function(response){
        if(response[1]=="success"){
          swal('Undo Done!',response[0],'success').then(function() {
           $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]+"</span>");
           $("[data-dismiss=modal]").trigger({ type: "click" });
           location.reload();
         });
        }if(response[1]=="fail"){
          swal('Sorry!',response[0],'warning').then(function() {
           $("[data-dismiss=modal]").trigger({ type: "click" });
         });
        }
      })
       .fail(function(response){
         swal('Oops...', 'Something went wrong!' , 'error');
       });
     });
   },
   allowOutsideClick: false
 });
});

$('#forward_ps').on('click',function(){
 var app_num = $(this).data('number');

 swal({
   title: 'Are you sure?',
   text: "Forward this application to PS",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, Forward it!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
       $.ajax({
         url: '/stahqdhaka.army.mil.bd/public/application/forward',
         type: 'get',
         data: {
          'app_num':app_num,
        },
        dataType: 'json'
      })
       .done(function(response){
        if(response[0]==10){
          swal('Forwarded!',response[1],'success').then(function() {

           $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]+"</span>");
           $("[data-dismiss=modal]").trigger({ type: "click" });
           location.reload();
         });
        }
        else if(response[0]==11){
          swal('Not Now!',response[1],'warning').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });
        }
        else if(response[0]==12){
          swal('Not Forwarded!',response[1],'error').then(function(){
            $("[data-dismiss=modal]").trigger({ type: "click" });
          });
        }

      })
       .fail(function(response){
         swal('Oops...', 'Something went wrong!' , 'error');
       });
     });
   },
   allowOutsideClick: false
 });
});
$('#issueSticker_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#issueSticker_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/sticker/issue';
  var type='post';
  swal({
   title: 'Are you sure?',
   text: "Issue Processing",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, Issue It!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
       $.ajax({
        type:type,
        url:url,
        data:new FormData($("#issueSticker_Form")[0]),
        processData:false,
        contentType:false,
        success:function(response){
          if(response[0]==11){
            swal('Issued!',response[1],'success').then(function() {
              var win = window.open('/invoice/'+response[3], '_blank');
              win.focus();
              $('#app_status').replaceWith("<span id='app_status' style='color: red'>"+response[2]+"</span>");
              $("[data-dismiss=modal]").trigger({ type: "click" });
              location.reload();
            });
          }
          else if(response[0]==10){
            swal('Not Now!',response[1],'warning').then(function(){
              $("[data-dismiss=modal]").trigger({ type: "click" });
            });
          }
          else if(response[0]==12){
            swal('Not Issued!',response[1],'error').then(function(){
              $("[data-dismiss=modal]").trigger({ type: "click" });
            });
          }
        },
        error:function(response){
          swal('Oops...', 'Something went wrong!' , 'error');

        }
      });
     });
   },
   allowOutsideClick: false,
 });
});

$(document).on('click','.resendSms',function(){
  var followUpId = $(this).data('id');
  swal({
   title: 'Are you sure?',
   text: "Retry to send sms",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, Send Sms!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
       $.ajax({
         url: '/stahqdhaka.army.mil.bd/public/send-sms/retry/'+followUpId,
         type: 'get',
         data: {
          'followUpId':followUpId,
        },
        dataType: 'json'
      })
       .done(function(response){
        if(response[0]=='success'){
         swal('Done!','Your requested SMS has been sent successfully','success').then(function() {
           $('span.sms-failed').remove();
           $('.sms-status-replace').replaceWith('<span style="color: green;" title="sms sent"><i class="fas fa-check"></i></span>');
         });
       }
       if(response[0]=='fail'){
         swal('Sorry!','Your requested SMS has not sent','warning').then(function() {
         });
       }
     })
       .fail(function(response){
         swal('Oops...', 'Something went wrong!' , 'error');
       });
     });
   },
   allowOutsideClick: false
 });
});
$('#special_case').on('change',function(){
  if(this.checked){
    $('.special_case').attr('hidden',false);
    $('.special_data').attr('required',true);
  }else{
   $('.special_case').attr('hidden',true);
   $('.special_data').attr('required',false);
 }
});
$('#normal_case').on('change',function(){
  if(this.checked){
    $('.special_case').attr('hidden',true);
    $('.special_data').attr('required',false);
  }else{
   $('.special_case').attr('hidden',false);
   $('.special_data').attr('required',true);
 }
});
if($('#normal_case').is(':checked')){
  $('.special_case').attr('hidden',true);
  $('.special_data').attr('required',false);
}else{
 $('.special_case').attr('hidden',false);
 $('.special_data').attr('required',true);
}
$("input#discount_amount").on("keyup bind input cut copy paste change", function (){
  var discount=0;
  var total=0;
  var amount=0;
  discount = parseFloat($(this).val());
  amount = parseFloat($('#amount').val());
  total=amount-discount;
  $('#total_amount').val(total);
  if($(this).val()==''){
    $('#total_amount').val(amount);
  }
});
$(document).on('change','select.sms_template',function(){
  var sms_id = $(this).val();
  var all_sms = $(this).data('sms');
  $.each( all_sms, function( key, value ) {
    if(sms_id==value['id']){
      $('.sms_subject').val(value['sms_subject']);
      $('.sms_text').val(value['sms_text']);
      $('.sms_id').val(value['id']);
    }
  }); 
})
 $('#sendSms_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#sendSms_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/send/sms';
  var type='post';
  swal({
   title: 'Are you sure?',
   text: "Mail sending",
   type: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: 'Yes, Send Mail!',
   showLoaderOnConfirm: true,
   preConfirm: function() {
     return new Promise(function(resolve) {
      $.ajax({
        type:type,
        url:url,
        data:new FormData($("#sendSms_Form")[0]),
        processData:false,
        contentType:false,
      })
      .done(function(response){
        if(response[1]=="failed"){
         swal('Not Sent!',response[0],'warning');
       }else if(response[1]=="success"){
         $.ajax({
          url: '/stahqdhaka.army.mil.bd/public/send-queued-sms/'+response[2],
          type: 'get',
          data: {
          },
          dataType: 'json'
        });
         swal('Congratulation!',response[0],'success').then(function(){
          $("[data-dismiss=modal]").trigger({ type: "click" });
          $('.follow-up-table tbody') 
          .prepend('<tr />') 
          .children('tr:first')
          .prepend('<td>#</td><td>'+response[3]['created_at']+'</td><td>'+response[3]['status']+'</td><td>'+response[3]['comment']+'</td><td>on process</td><td>'+response[3]['updated_by']+'</td>');
        });
       }
     })
      .fail(function(response){
       swal('Oops...', 'Something went wrong!' , 'error');
     });
    });
   },
   allowOutsideClick: false,
 });
}); 
$('#AddSms_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#AddSms_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/add/sms';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#AddSms_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      var table = $('#example').DataTable();
      var  idx= table.rows().count();
      idx++;
      var rowNode = table
      .row.add( ['<b class="serial">'+idx+'</b>', response[1]['sms_template_name'],response[1]['sms_subject'],response[1]['sms_text'],response[1]['creator'],response[1]['updater'], 
        '<button class="btn btn-info view-sms mr-1" data-template="'+response[1]['sms_template_name']+'" data-subject="'+response[1]['sms_subject']+'" data-message="'+response[1]['sms_text']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#view_template_modal"><i class="fas fa-eye"></i></button>'+
        '<button class="btn btn-info edit-sms mr-1" data-template="'+response[1]['sms_template_name']+'" data-subject="'+response[1]['sms_subject']+'" data-message="'+response[1]['sms_text']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button>'+
        '<button class="btn btn-danger delete-sms ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'] )
      .order([0, 'dsc']).draw()
      .node().id = 'sms-'+idx;
      $( rowNode )
      .css( 'color', 'green' )
      .animate( { color: 'red' } );
      swal('Congratulation!',response[0],'success').then(function() {
       $('#AddSms_Form')[0].reset();
       $("[data-dismiss=modal]").trigger({ type: "click" });
       $(".print-error-msg").css('display','none');
     });
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');

    }
  });
});

$(document).on('click', 'button.view-sms', function(){
 $('.sms-template').html($(this).data('template'));
 $('.sms-subject').html($(this).data('subject'));
 $('.sms-text').html($(this).data('message'));
});   

var id=null; var tr_id=null;  var sl=null;
$(document).on('click', '.edit-sms', function(){
 $('input.sms_template_name').val($(this).data('template'));
 $('input.sms_subject').val($(this).data('subject'));
 $('textarea.sms_text').val($(this).data('message'));

 id = $(this).data('id');
 tr = $(this).parent().parent();
 tr_id=tr.attr('id');
 sl = $('#'+tr_id +" .serial").text();
});

$('#UpdateSms_Form').on('submit', function(e){
  e.preventDefault();
  var form=$('#UpdateSms_Form');
  var formData=form.serialize();
  var table = $('#example').DataTable();
  var url='/stahqdhaka.army.mil.bd/public/update/sms/'+id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#UpdateSms_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      if(response[1]['id'] == id){
        var rData = [
        '<b class="serial">'+sl+'</b>',
        response[1]['sms_template_name'],
        response[1]['sms_subject'],
        response[1]['sms_text'],
        response[1]['creator'],
        response[1]['updater'], 
        '<button class="btn btn-info view-sms mr-1" data-template="'+response[1]['sms_template_name']+'" data-subject="'+response[1]['sms_subject']+'" data-message="'+response[1]['sms_text']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#view_template_modal"><i class="fas fa-eye"></i></button><button class="btn btn-info edit-sms mr-1" data-template="'+response[1]['sms_template_name']+'" data-subject="'+response[1]['sms_subject']+'" data-message="'+response[1]['sms_text']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button><button class="btn btn-danger delete-sms ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'
        ];
        table
        .row( 'tr#'+tr_id )
        .data(rData)
        .draw();
        swal('Congratulation!',response[0],'success').then(function() {
         $('#UpdateSms_Form')[0].reset();
         $("[data-dismiss=modal]").trigger({ type: "click" });
       });
      }
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');
    }
  });
});


function printSMSErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li> <i class="fas fa-exclamation-triangle"></i> '+value+'</li>');
  });
}

$(document).on('click', '.delete-sms', function(){
  var tr = $(this).parents('tr');
  var tr_id=tr.attr('id');
        // alert(tr_id+ ' '+ 'tr#'+tr_id);

        var id = $(this).data('id');


        swal({
         title: 'Are you sure?',
         text: "You want to delete this SMS Template!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!',
         showLoaderOnConfirm: true,
         preConfirm: function() {
           return new Promise(function(resolve) {
             $.ajax({
               url: '/stahqdhaka.army.mil.bd/public/delete/sms',
               type: 'post',
               data: {
                _token: CSRF_TOKEN,
                'id':id,
              },
              dataType: 'json'
            })
             .done(function(response){
              swal('Congratulation!',response[0],'success').then(function(){
                var table = $('#example').DataTable();
                table
                .row("tr#"+tr_id)
                .remove()
                .draw();
              });
            })
             .fail(function(response){
               swal('Oops...', 'Something went wrong!' , 'error');
             });
           });
         },
         allowOutsideClick: false
       });
      });



$('#add_bank_deposit_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#add_bank_deposit_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/add/bank/deposit';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#add_bank_deposit_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      var table = $('#example').DataTable();
      var  idx= table.rows().count();
      idx++;
      var rowNode = table
      .row.add( ['<b class="serial">'+idx+'</b>', response[1]['depositor_name'],response[1]['bank_name'],response[1]['bank_acc_no'],response[1]['deposit_date'],response[1]['created_by'],response[1]['amount']
        ])
      .order([0, 'dsc']).draw()
      .node();
      $( rowNode )
      .css( 'color', 'green' )
      .animate( { color: 'red' } );

      swal('Congratulation!',response[0],'success').then(function() {
       $('#add_bank_deposit_Form')[0].reset();
       $("[data-dismiss=modal]").trigger({ type: "click" });

     });
    },
    error:function(response){
            // printSMSErrorMsg(response.responseJSON);
            swal('Oops...', 'Something went wrong!' , 'error');
          }
        });
});

$('#change_password_form').on('submit',function(e){
  e.preventDefault();
  var form=$('#change_password_form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/change/password';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#change_password_form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      if(response[1]=='success'){
        swal('Congratulation!',response[0],'success').then(function() {
         $('#change_password_form')[0].reset();
         $("[data-dismiss=modal]").trigger({ type: "click" });
       });
      }
      if(response[1]=='fail'){
       swal('Sorry!',response[0],'warning');
     }

   },
   error:function(response){
            // printSMSErrorMsg(response.responseJSON);
            swal('Oops...', 'Something went wrong!' , 'error');
          }
        });
});
$('#AddAdmin_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#AddAdmin_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/add/admin';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#AddAdmin_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      var table = $('#example').DataTable();
      var  idx= table.rows().count();
      idx++;
      var rowNode = table
      .row.add( ['<b class="serial">'+idx+'</b>', response[1]['name'],response[1]['email'],response[1]['role'],response[1]['created_at'], 
        '<button class="btn btn-info edit-admin mr-1" data-name="'+response[1]['name']+'" data-email="'+response[1]['email']+'" data-role="'+response[1]['role']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button>'+
        '<button class="btn btn-danger delete-admin ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'] )
      .order([0, 'dsc']).draw()
      .node().id = 'sms-'+idx;
      $( rowNode )
      .css( 'color', 'green' )
      .animate( { color: 'red' } );
      swal('Congratulation!',response[0],'success').then(function() {
       $('#AddAdmin_Form')[0].reset();
       $("[data-dismiss=modal]").trigger({ type: "click" });
       $(".print-error-msg").css('display','none');
     });
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');

    }
  });
});


$(document).on('click', '.edit-admin', function(){
 $('input.name').val($(this).data('name'));
 $('input.email').val($(this).data('email'));
 $('input.role').val($(this).data('role'));

 id = $(this).data('id');
 tr = $(this).parent().parent();
 tr_id=tr.attr('id');
 sl = $('#'+tr_id +" .serial").text();
});

$('#UpdateAdmin_Form').on('submit', function(e){
  e.preventDefault();
  var form=$('#UpdateAdmin_Form');
  var formData=form.serialize();
  var table = $('#example').DataTable();
  var url='/stahqdhaka.army.mil.bd/public/update/admin/'+id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#UpdateAdmin_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      if(response[1]['id'] == id){
        var row_data = [
        '<b class="serial">'+sl+'</b>',
        response[1]['name'],
        response[1]['email'],
        response[1]['role'],
        response[1]['created_at'],
        '<button class="btn btn-info edit-admin mr-1" data-name="'+response[1]['name']+'" data-email="'+response[1]['email']+'" data-role="'+response[1]['role']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button><button class="btn btn-danger delete-admin ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'
        ];
        table
        .row( 'tr#'+tr_id )
        .data(row_data)
        .draw();
        swal('Congratulation!',response[0],'success').then(function() {
         $('#UpdateAdmin_Form')[0].reset();
         $("[data-dismiss=modal]").trigger({ type: "click" });
       });
      }
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');
    }
  });
});
$(document).on('click', '.delete-admin', function(){
  var tr = $(this).parents('tr');
  var tr_id=tr.attr('id');
        // alert(tr_id+ ' '+ 'tr#'+tr_id);
        var id = $(this).data('id');
        swal({
         title: 'Are you sure?',
         text: "You want to delete this Admin!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!',
         showLoaderOnConfirm: true,
         preConfirm: function() {
           return new Promise(function(resolve) {
             $.ajax({
               url: '/stahqdhaka.army.mil.bd/public/delete/admin',
               type: 'post',
               data: {
                _token: CSRF_TOKEN,
                'id':id,
              },
              dataType: 'json'
            })
             .done(function(response){
              swal('Congratulation!',response[0],'success').then(function(){
                var table = $('#example').DataTable();
                table
                .row("tr#"+tr_id)
                .remove()
                .draw();
              });
            })
             .fail(function(response){
               swal('Oops...', 'Something went wrong!' , 'error');
             });
           });
         },
         allowOutsideClick: false
       });
      });


$(document).on('click', '.edit-client', function(){
 $('input.name').val($(this).data('name'));
 $('input.user_name').val($(this).data('uname'));
 $('input.phone').val($(this).data('phone'));
 $('input.email').val($(this).data('email'));
 var role =$(this).data('role');
 if(role=="def"){
   $('#client_role_def').attr('hidden',false);
   $('#client_role_nondef').attr('hidden',true);
   $('#client_role_nondef').attr('disabled',true);
   $('#client_role_def').attr('disabled',false);
 }else{
   $('#client_role_nondef').attr('hidden',false);
   $('#client_role_def').attr('hidden',true);
   $('#client_role_def').attr('disabled',true);
   $('#client_role_nondef').attr('disabled',false);
 }
 id = $(this).data('id');
 tr = $(this).parent().parent();
 tr_id=tr.attr('id');
 sl = $('#'+tr_id +" .sorting_1").text();
});

$('#UpdateClient_Form').on('submit', function(e){
  e.preventDefault();
  var form=$('#UpdateClient_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/update/client/'+id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#UpdateClient_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      if(response[1]['id'] == id){
       $('#'+tr_id).find("td:eq(1)").html(response[1]['name']);
       $('#'+tr_id).find("td:eq(2)").html(response[1]['user_name']);
       $('#'+tr_id).find("td:eq(3)").html(response[1]['email']);
       $('#'+tr_id).find("td:eq(4)").html(response[1]['phone']);
       $('#'+tr_id).find("td:eq(5)").html(response[1]['role']);
       $('#'+tr_id).find("td:eq(6)").html('<button class="btn btn-info edit-client" data-name="'+response[1]['name']+'" data-email="'+response[1]['email']+'" data-role="'+response[1]['role']+'" data-phone="'+response[1]['phone']+'" data-uname="'+response[1]['user_name']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_client_modal"><i class="fas fa-edit"></i></button>');
       swal('Congratulation!',response[0],'success').then(function() {
         $('#UpdateClient_Form')[0].reset();
         $("[data-dismiss=modal]").trigger({ type: "click" });
       });
     }
   },
   error:function(response){
    printSMSErrorMsg(response.responseJSON);
    swal('Oops...', 'Something went wrong!' , 'error');
  }
});
});
$('#AddSticker_Form').on('submit',function(e){
  e.preventDefault();
  var form=$('#AddSticker_Form');
  var formData=form.serialize();
  var url='/stahqdhaka.army.mil.bd/public/add/sticker';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#AddSticker_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      var table = $('#example').DataTable();
      var  idx= table.rows().count();
      idx++;
      var rowNode = table
      .row.add( ['<b class="serial">'+idx+'</b>',
       response[1]['name'],
       response[1]['value'],
       response[1]['price'],
       response[1]['duration'],
       response[1]['created_by']+'<br>'+response[3],
       response[1]['updated_by'], 
       '<button class="btn btn-info edit-sticker mr-1" data-name="'+response[1]['name']+'" data-price="'+response[1]['price']+'" data-duration="'+response[1]['duration']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button>'+
       '<button class="btn btn-danger delete-sticker ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'] )
      .order([0, 'dsc']).draw()
      .node().id = 'sticker-'+idx;
      $( rowNode )
      .css( 'color', 'green' )
      .animate( { color: 'red' } );
      swal('Congratulation!',response[0],'success').then(function() {
       $('#AddSticker_Form')[0].reset();
       $("[data-dismiss=modal]").trigger({ type: "click" });
       $(".print-error-msg").css('display','none');
     });
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');

    }
  });
});

$(document).on('click', '.edit-sticker', function(){
 $('input.sticker_name').val($(this).data('name'));
 $('input.sticker_value').val($(this).data('value'));
 $('input.sticker_price').val($(this).data('price'));
 $('input.sticker_duration').val($(this).data('duration'));

 id = $(this).data('id');
 tr = $(this).parent().parent();
 tr_id=tr.attr('id');
 sl = $('#'+tr_id +" .serial").text();
});

$('#UpdateSticker_Form').on('submit', function(e){
  e.preventDefault();
  var form=$('#UpdateSticker_Form');
  var formData=form.serialize();
  var table = $('#example').DataTable();
  var url='/stahqdhaka.army.mil.bd/public/update/sticker/'+id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#UpdateSticker_Form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      if(response[1]['id'] == id){
        var row_data = [
        '<b class="serial">'+sl+'</b>',
        response[1]['name'],
        response[1]['value'],
        response[1]['price'],
        response[1]['duration'],
        response[1]['created_by'] +'<br>' + response[2],
        response[1]['updated_by'] +'<br>' +response[3],
        '<button class="btn btn-info edit-sticker mr-1" data-name="'+response[1]['name']+'" data-value="'+response[1]['value']+'" data-price="'+response[1]['price']+'" data-duration="'+response[1]['duration']+'" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#edit_template_modal"><i class="fas fa-edit"></i></button><button class="btn btn-danger delete-sticker ml-0" data-id="'+response[1]['id']+'" data-toggle="modal" data-target="#delete_template_modal"><i class="fas fa-trash-alt"></i></button>'
        ];
        table
        .row( 'tr#'+tr_id )
        .data(row_data)
        .draw();
        swal('Congratulation!',response[0],'success').then(function() {
         $('#UpdateSticker_Form')[0].reset();
         $("[data-dismiss=modal]").trigger({ type: "click" });
       });
      }
    },
    error:function(response){
      printSMSErrorMsg(response.responseJSON);
      swal('Oops...', 'Something went wrong!' , 'error');
    }
  });
});
$(document).on('click', '.delete-sticker', function(){
  var tr = $(this).parents('tr');
  var tr_id=tr.attr('id');
        // alert(tr_id+ ' '+ 'tr#'+tr_id);
        var id = $(this).data('id');
        swal({
         title: 'Are you sure?',
         text: "You want to delete this Sticker!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!',
         showLoaderOnConfirm: true,
         preConfirm: function() {
           return new Promise(function(resolve) {
             $.ajax({
               url: '/stahqdhaka.army.mil.bd/public/delete/sticker',
               type: 'post',
               data: {
                _token: CSRF_TOKEN,
                'id':id,
              },
              dataType: 'json'
            })
             .done(function(response){
              swal('Congratulation!',response[0],'success').then(function(){
                var table = $('#example').DataTable();
                table
                .row("tr#"+tr_id)
                .remove()
                .draw();
              });
            })
             .fail(function(response){
               swal('Oops...', 'Something went wrong!' , 'error');
             });
           });
         },
         allowOutsideClick: false
       });
      });
// check if localStorage available 
// http://stackoverflow.com/questions/16427636/check-if-localstorage-is-available
function lsTest(){
  var test = 'test';
  try {
    localStorage.setItem(test, test);
    localStorage.removeItem(test);
    return true;
  } catch(e) {
    return false;
  }
}      
 // listen to storage event
 window.addEventListener('storage', function(event){
    // do what you want on logout-event
    if (event.key == 'logout-event') {
      // $('#console').html('Received logout event! Insert logout script here.');
      window.location.href="/login"; 
    }
  }, false);

 $(document).ready(function(){
  if(lsTest()) {
    $('#logout').on('click', function(){
      // change logout-event and therefore send an event
      localStorage.setItem('logout-event', 'logout' + Math.random());
      return true;
    });   
  } else {
     // setInterval or setTimeout
   }
 });     
// end of doc.ready()    
});
