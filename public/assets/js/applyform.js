$.ajaxSetup({
 headers:{
   'X_CSRF_TOKEN':$('meta[name="_token"]').attr('content')
 }
});
$(document).ready(function() {
 $('#term_checkbox').change(function (){
   if (this.checked){
    $('#next_btn').attr('disabled', false);
  }
  else{
   $('#next_btn').attr('disabled', true);
 }
});
 function windowScrollTop(){
   $('html, body').animate({
    scrollTop: $("header").offset().top
  }, 0);
 } 
 $('#next_btn').on('click',function(){
   $('#content_form_def').attr('hidden',false);
   $('#content_form_non-def').attr('hidden',false);
   $('#content_term_condition').remove();
   windowScrollTop();
 });
 function readURL(input) {
   imgId = '#prev_'+ $(input).attr('id');
   if (input.files && (input.files[0].size / 1024 / 1024) < 0.25) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $(imgId).attr('src', e.target.result);
      $(imgId).attr('hidden',false);
      $(imgId).css({'display':'inline-block','height':'auto','padding':'10px 0px','max-width':'70%','width': 'auto','max-height': '200px'});
    }
    reader.readAsDataURL(input.files[0]);
    $(input).siblings('div.err_msg').attr('hidden',true);
  }
  else{
    $(input).val('');  
    $(imgId).attr('hidden',true);
    $(input).siblings('div.err_msg').find('span').text('File size exceeds 250 KB.Please reduce file size less than 250kb');
    $(input).siblings('div.err_msg').attr('hidden',false);
  }
}
$("form.Applycationform input[type='file']").change(function(){            
  readURL(this);
  $(this).on('click',function(){
   imgId = '#prev_'+ $(this).attr('id');
   $(imgId).attr('hidden',true);
 })
});
$("form#Application_Form_Non-def_Edit input[type='file']").change(function(){
  readURL(this);
  $(this).on('click',function(){
   imgId = '#prev_'+ $(this).attr('id');
   $(imgId).attr('hidden',true);
 })
});
$('#applicant_spouse_child').change(function (){
 if (this.checked){
  $(".applicant_spouse_child").attr('hidden', false);
  $(".applicant_spouse_child input[type='text']").attr('required', true);
  $(".not_applicant_spouse_child").attr('hidden', true);
  $(".not_applicant_spouse_child input[type='text']").attr('required', false);
}
else{
  $('.applicant_spouse_child').attr('hidden', true);
  $(".applicant_spouse_child input[type='text']").attr('required', false);
  $(".not_applicant_spouse_child").attr('hidden', false);
  $(".not_applicant_spouse_child input[type='text']").attr('required', true);
}
});   
$('#is_transparent').change(function (){
 if (this.checked){
  $(".is_transparent_hide").attr('hidden', false);
  $(".is_transparent_hide input[type='text']").attr('required', true);
}
else{
  $('.is_transparent_hide').attr('hidden', true);
  $(".is_transparent_hide input[type='text']").attr('required', false);
}
}); 
$('.owner_is_company').change(function (){
 if (this.checked){
  $(".company_info_field").attr('hidden', false);
  $(".company_info_field input[type='text']").attr('required', true);
}
else{
 $('.company_info_field').attr('hidden', true);
 $(".company_info_field input[type='text']").attr('required', false);
}
}); 
$('.self_driven').change(function (){
 if (this.checked){
  $(".not_self_driven").attr('hidden', true);
  $(".not_self_driven input").attr('required', false);
}
else{
 $('.not_self_driven').attr('hidden', false);
 $(".Applycationform .not_self_driven input").attr('required', true);
 $(".not_self_driven input[type='checkbox']").attr('required', false);
 $(".driver_perm input").attr('required', false);
}
});
$('.owner_address_permanent').change(function (){
 if (this.checked){
  $('.o_per_flat').val($('.o_flat').val());
  $('.o_per_house').val($('.o_house').val());
  $('.o_per_road').val($('.o_road').val());
  $('.o_per_block').val($('.o_block').val());
  $('.o_per_area').val($('.o_area').val());
}
else{
  $('.o_per_flat').val('');
  $('.o_per_house').val('');
  $('.o_per_road').val('');
  $('.o_per_block').val('');
  $('.o_per_area').val('');  
}
});
$('.driver_address_same_as_present').change(function (){
 if (this.checked){
  $('.driver_per_flat').val($('.driver_pre_flat').val());
  $('.driver_per_house').val($('.driver_pre_house').val());
  $('.driver_per_road').val($('.driver_pre_road').val());
  $('.driver_per_block').val($('.driver_pre_block').val());
  $('.driver_per_area').val($('.driver_pre_area').val());
}
else{
  $('.driver_per_flat').val('');
  $('.driver_per_house').val('');
  $('.driver_per_road').val('');
  $('.driver_per_block').val('');
  $('.driver_per_area').val('');  
}
});

$('#app_address_same_as_present').change(function (){
 if (this.checked){
  $('#app_per_flat').val($('#app_pre_flat').val());
  $('#app_per_house').val($('#app_pre_house').val());
  $('#app_per_road').val($('#app_pre_road').val());
  $('#app_per_block').val($('#app_pre_block').val());
  $('#app_per_area').val($('#app_pre_area').val());
}
else{
  $('#app_per_flat').val('');
  $('#app_per_house').val('');
  $('#app_per_road').val('');
  $('#app_per_block').val('');
  $('#app_per_area').val(''); 
}
});
$('div#o_c_address_same_pre_per_ofc input[type="checkbox"]').on('change', 
  function() {
   $(this).siblings('input[type="checkbox"]').prop('checked', false);
   if ($('.o_c_address_same_pre:checked').val() == '0'){ 
    $('#o_c_flat').val($('#app_pre_flat').val());
    $('#o_c_house').val($('#app_pre_house').val());
    $('#o_c_road').val($('#app_pre_road').val());
    $('#o_c_block').val($('#app_pre_block').val());
    $('#o_c_area').val($('#app_pre_area').val());
  }
  else if ($('.o_c_address_same_per:checked').val()== '1'){
    $('#o_c_flat').val($('#app_per_flat').val());
    $('#o_c_house').val($('#app_per_house').val());
    $('#o_c_road').val($('#app_per_road').val());
    $('#o_c_block').val($('#app_per_block').val());
    $('#o_c_area').val($('#app_per_area').val());
  }
  else if ($('.o_c_address_same_ofc:checked').val()== '2'){
    $('#o_c_flat').val($('#applicant_o_flat').val());
    $('#o_c_house').val($('#applicant_o_house').val());
    $('#o_c_road').val($('#applicant_o_road').val());
    $('#o_c_block').val($('#applicant_o_block').val());
    $('#o_c_area').val($('#applicant_o_area').val());
  }
  else{
    $('#o_c_flat').val('');
    $('#o_c_house').val('');
    $('#o_c_road').val('');
    $('#o_c_block').val('');
    $('#o_c_area').val('');
  }
});

/// Form Validatiom function
function applicantInfoValidate(){
  if($("input#applicant_name").val()==''){
    $('#err_applicantName').text("Applicant's Name field is required");
    $('#err_msg_applicantName').attr('hidden',false);
    $("input#applicant_name").addClass('red-border');
  }
  else if($("input#applicant_name").val()!=null){
    $('#err_msg_applicantName').attr('hidden',true); 
    $("input#applicant_name").removeClass('red-border');
  }
  $("input#applicant_name").on("keyup bind cut change copy paste", function () {
    if($(this).val()!=null){
     $('#err_msg_applicantName').attr('hidden',true); 
     $("input#applicant_name").removeClass('red-border');
   }
   else{
    $('#err_msg_applicantName').attr('hidden',false); 
    $("input#applicant_name").addClass('red-border');   
  }
});
            /////  
            if($("input#applicant_phone").val()==''){
              $('#err_applicantPhone').text("Applicant's Phone field is required");
              $('#err_msg_applicantPhone').attr('hidden',false);
              $("input#applicant_phone").addClass('red-border');
            }
            else if($("input#applicant_phone").val()!=null){
              $('#err_msg_applicantPhone').attr('hidden',true); 
              $("input#applicant_phone").removeClass('red-border');
            }
            $("input#applicant_phone").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantPhone').attr('hidden',true); 
               $("input#applicant_phone").removeClass('red-border');

             }
             else{
              $('#err_msg_applicantPhone').attr('hidden',false);
              $("input#applicant_phone").addClass('red-border');

            }
          });
            /////    
            if($("input#f_h_name").val()==''){
              $('#err_applicantFather').text("Applicant's Father/Husband name field is required");
              $('#err_msg_applicantFather').attr('hidden',false);
              $("input#f_h_name").addClass('red-border');
            }
            else if($("input#f_h_name").val()!=null){
              $('#err_msg_applicantFather').attr('hidden',true); 
              $("input#f_h_name").removeClass('red-border');
            }
            $("input#f_h_name").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantFather').attr('hidden',true);
               $("input#f_h_name").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantFather').attr('hidden',false); 
              $("input#f_h_name").addClass('red-border');   
            }
          });
            /////

            if($("input#applicant_nid").val()==''){
              $('#err_applicantNid').text('Applicant NID Number is required');
              $('#err_msg_applicantNid').attr('hidden',false);
              $("input#applicant_nid").addClass('red-border');
            }
            else if($("input#applicant_nid").val()!=null){
              $('#err_msg_applicantNid').attr('hidden',true); 
              $("input#applicant_nid").removeClass('red-border');

            }
            $("input#applicant_nid").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantNid').attr('hidden',true);
               $("input#applicant_nid").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantNid').attr('hidden',false);  
              $("input#applicant_nid").addClass('red-border');  
            }
          });
            /////        /////

            if($("input#applicant_tin").val()==''){
              $('#err_applicantTin').text('Tin Number field is required');
              $('#err_msg_applicantTin').attr('hidden',false);
              $("input#applicant_tin").addClass('red-border');
            }
            else if($("input#applicant_tin").val()!=null){
              $('#err_msg_applicantTin').attr('hidden',true); 
              $("input#applicant_tin").removeClass('red-border');

            }
            $("input#applicant_tin").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantTin').attr('hidden',true);
               $("input#applicant_tin").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantTin').attr('hidden',false);  
              $("input#applicant_tin").addClass('red-border');  
            }
          });
            /////        /////

            if($("input#app_pre_area").val()==''){
              $('#err_applicantArea').text('Present Area field is required');
              $('#err_msg_applicantArea').attr('hidden',false);
              $("input#app_pre_area").addClass('red-border');
            }
            else if($("input#app_pre_area").val()!=null){
              $('#err_msg_applicantArea').attr('hidden',true); 
              $("input#app_pre_area").removeClass('red-border');

            }
            $("input#app_pre_area").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantArea').attr('hidden',true);
               $("input#app_pre_area").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantArea').attr('hidden',false); 
              $("input#app_pre_area").addClass('red-border');   
            }
          });
            /////    
            if($("input#app_pre_flat").val()==''){
              $('#err_applicantFlat').text('Present Flat field is required');
              $('#err_msg_applicantFlat').attr('hidden',false);
              $("input#app_pre_flat").addClass('red-border');
            }
            else if($("input#app_pre_flat").val()!=null){
              $('#err_msg_applicantFlat').attr('hidden',true); 
              $("input#app_pre_flat").removeClass('red-border');

            }
            $("input#app_pre_flat").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantFlat').attr('hidden',true);
               $("input#app_pre_flat").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantFlat').attr('hidden',false); 
              $("input#app_pre_flat").addClass('red-border');   
            }
          });
            /////        /////

            if($("input#app_pre_road").val()==''){
              $('#err_applicantRoad').text('Present Road field is required');
              $('#err_msg_applicantRoad').attr('hidden',false);
              $("input#app_pre_road").addClass('red-border');
            }
            else if($("input#app_pre_road").val()!=null){
              $('#err_msg_applicantRoad').attr('hidden',true);
              $("input#app_pre_road").removeClass('red-border'); 

            }
            $("input#app_pre_road").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantRoad').attr('hidden',true);
               $("input#app_pre_road").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantRoad').attr('hidden',false); 
              $("input#app_pre_road").addClass('red-border');   
            }
          });
            /////        /////

            if($("input#app_pre_block").val()==''){
              $('#err_applicantBlock').text('Present Block field is required');
              $('#err_msg_applicantBlock').attr('hidden',false);
              $("input#app_pre_block").addClass('red-border');
            }
            else if($("input#app_pre_block").val()!=null){
              $('#err_msg_applicantBlock').attr('hidden',true);
              $("input#app_pre_block").removeClass('red-border'); 

            }
            $("input#app_pre_block").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantBlock').attr('hidden',true);
               $("input#app_pre_block").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantBlock').attr('hidden',false);  
              $("input#app_pre_block").addClass('red-border');  
            }
          });
            /////        /////

            if($("input#app_pre_house").val()==''){
              $('#err_applicantHouse').text('Present House field is required');
              $('#err_msg_applicantHouse').attr('hidden',false);
              $("input#app_pre_house").addClass('red-border');
            }
            else if($("input#app_pre_house").val()!=null){
              $('#err_msg_applicantHouse').attr('hidden',true);
              $("input#app_pre_house").removeClass('red-border'); 

            }
            $("input#app_pre_house").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantHouse').attr('hidden',true);
               $("input#app_pre_house").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantHouse').attr('hidden',false);
              $("input#app_pre_house").addClass('red-border');    
            }
          }); 
                 /////    permanent add    /////

                 if($("input#app_per_area").val()==''){
                  $('#err_applicantPArea').text('Permanent Area field is required');
                  $('#err_msg_applicantPArea').attr('hidden',false);
                  $("input#app_per_area").addClass('red-border');

                }
                else if($("input#app_per_area").val()!=null){
                  $('#err_msg_applicantPArea').attr('hidden',true); 
                  $("input#app_per_area").removeClass('red-border');
                }
                $("input#app_per_area").on("keyup bind cut change copy paste", function () {
                  if($(this).val()!=null){
                   $('#err_msg_applicantPArea').attr('hidden',true); 
                   $("input#app_per_area").removeClass('red-border');
                 }
                 else{
                  $('#err_msg_applicantPArea').attr('hidden',false); 
                  $("input#app_per_area").addClass('red-border');
                }
              });
            /////   
            if($("input#app_per_flat").val()==''){
              $('#err_applicantPFlat').text('Permanent Flat field is required');
              $('#err_msg_applicantPFlat').attr('hidden',false);
              $("input#app_per_flat").addClass('red-border');

            }
            else if($("input#app_per_flat").val()!=null){
              $('#err_msg_applicantPFlat').attr('hidden',true); 
              $("input#app_per_flat").removeClass('red-border');
            }
            $("input#app_per_flat").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantPFlat').attr('hidden',true); 
               $("input#app_per_flat").removeClass('red-border');
             }
             else{
              $('#err_msg_applicantPFlat').attr('hidden',false); 
              $("input#app_per_flat").addClass('red-border');
            }
          });
            /////        /////

            if($("input#app_per_road").val()==''){
              $('#err_applicantPRoad').text('Permanent Road field is required');
              $('#err_msg_applicantPRoad').attr('hidden',false);
              $("input#app_per_road").addClass('red-border');
            }
            else if($("input#app_per_road").val()!=null){
              $('#err_msg_applicantPRoad').attr('hidden',true); 
              $("input#app_per_road").removeClass('red-border');
            }
            $("input#app_per_road").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantPRoad').attr('hidden',true);
               $("input#app_per_road").removeClass('red-border');
             }
             else{
              $('#err_msg_applicantPRoad').attr('hidden',false);
              $("input#app_per_road").addClass('red-border');    
            }
          });
            /////        /////

            if($("input#app_per_block").val()==''){
              $('#err_applicantPBlock').text('Permanent Block field is required');
              $('#err_msg_applicantPBlock').attr('hidden',false);
              $("input#app_per_block").addClass('red-border');
            }
            else if($("input#app_per_block").val()!=null){
              $('#err_msg_applicantPBlock').attr('hidden',true);
              $("input#app_per_block").removeClass('red-border'); 

            }
            $("input#app_per_block").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantPBlock').attr('hidden',true);
               $("input#app_per_block").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantPBlock').attr('hidden',false); 
              $("input#app_per_block").addClass('red-border');   
            }
          });
            /////        /////

            if($("input#app_per_house").val()==''){
              $('#err_applicantPHouse').text('Permanent House field is required');
              $('#err_msg_applicantPHouse').attr('hidden',false);
              $("input#app_per_house").addClass('red-border');
            }
            else if($("input#app_per_house").val()!=null){
              $('#err_msg_applicantPHouse').attr('hidden',true);
              $("input#app_per_house").removeClass('red-border'); 

            }
            $("input#app_per_house").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicantPHouse').attr('hidden',true);
               $("input#app_per_house").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicantPHouse').attr('hidden',false);
              $("input#app_per_house").addClass('red-border');    
            }
          });
            /////
         /////
         if($('#image1_e').val()===''){
          $('#err_applicantPhoto').text('Applicant Photo is required');
          $('#err_msg_applicantPhoto').attr('hidden',false);
          $("input#image1_e").addClass('red-border');              
        }
        else if($('#image1_e').val()!=''){
          $('#err_msg_applicantPhoto').attr('hidden',true);
          $("input#image1_e").removeClass('red-border'); 
        }

        $('#image1_e').on('change',function(){
          if($('#image1_e').val()!=''){
           $('#err_msg_applicantPhoto').attr('hidden',true);
           $("input#image1_e").removeClass('red-border');  
         }
         else{
          $('#err_msg_applicantPhoto').attr('hidden',false);
          $("input#image1_e").addClass('red-border');     
        }
      });
               /////   
               if($('#image2_e').val()===''){
                $('#err_appNidCopy').text('Applicant NID Copy is required');
                $('#err_msg_appNidCopy').attr('hidden',false);
                $("input#image2_e").addClass('red-border');              
              }
              else if($('#image2_e').val()!=''){
                $('#err_msg_appNidCopy').attr('hidden',true);
                $("input#image2_e").removeClass('red-border');
              }

              $('#image2_e').on('change',function(){
                if($('#image2_e').val()!=''){
                 $('#err_msg_appNidCopy').attr('hidden',true); 
                 $("input#image2_e").removeClass('red-border');
               }
               else{
                $('#err_msg_appNidCopy').attr('hidden',false); 
                $("input#image2_e").addClass('red-border');   
              }
            });
               /////    
               if($('#image3_e').val()===''){
                $('#err_appcopy').text('Application Copy is required');
                $('#err_msg_appcopy').attr('hidden',false);
                $("input#image3_e").addClass('red-border');              
              }
              else if($('#image3_e').val()!=''){
                $('#err_msg_appcopy').attr('hidden',true);
                $("input#image3_e").removeClass('red-border');
              }

              $('#image3_e').on('change',function(){
                if($('#image3_e').val()!=''){
                 $('#err_msg_appcopy').attr('hidden',true);
                 $("input#image3_e").removeClass('red-border'); 
               }
               else{
                $('#err_msg_appcopy').attr('hidden',false);
                $("input#image3_e").addClass('red-border');    
              }
            });
               /////
               if($('#image2_e_def_id').val()===''){
                $('#err_def_id').text('DEF ID Copy is required');
                $('#err_msg_def_id').attr('hidden',false);
                $("input#image2_e_def_id").addClass('red-border');
              }
              else if($('#image2_e_def_id').val()!=''){
                $('#err_msg_def_id').attr('hidden',true);
                $("input#image2_e_def_id").removeClass('red-border');
              }
              $('#image2_e_def_id').on('change',function(){
                if($('#image2_e_def_id').val()!=''){
                 $('#err_msg_def_id').attr('hidden',true);
                 $("input#image2_e_def_id").removeClass('red-border');
               }
               else{
                $('#err_msg_def_id').attr('hidden',false);
                $("input#image2_e_def_id").addClass('red-border');
              }
            });
               /////

               if($("select#residence_type").val()==null){
                $('#err_restype').text('Residence type field is required');
                $('#err_msg_restype').attr('hidden',false);
                $("select#residence_type").addClass('red-border');
              }
              else if($("select#residence_type").val()!=null){
                $('#err_msg_restype').attr('hidden',true);
                $("select#residence_type").removeClass('red-border');
              }
              $('select#residence_type').on('change',function(){
                if($("select#residence_type").val()!=null){
                  $('#err_msg_restype').attr('hidden',true);
                  $("select#residence_type").removeClass('red-border');
                }
                else{
                  $('#err_msg_restype').attr('hidden',false);
                  $("select#residence_type").addClass('red-border');
                }
              });

              /////      
              if($("input#app_sticker_num").val()==''){
                $('#err_tin').text('Tin Number is required');
                $('#err_msg_tin').attr('hidden',false);
                $("input#app_sticker_num").addClass('red-border');
              }
              else if($("input#app_sticker_num").val()!=''){
                $('#err_msg_tin').attr('hidden',true);
                $("input#app_sticker_num").removeClass('red-border');
              }
              $('input#app_sticker_num').on('change',function(){
                if($("input#app_sticker_num").val()!=''){
                  $('#err_msg_tin').attr('hidden',true);
                  $("input#app_sticker_num").removeClass('red-border');
                }
                else{
                  $('#err_msg_tin').attr('hidden',false);
                  $("input#app_sticker_num").addClass('red-border');
                }
              });
               /////
                      /////
                      if($("#applicant_spouse_child").is(':checked')){
                        if($("select#spouse_parents_rank").val()==null){
                          $('#err_spouse_parents_rank').text('Spouses/Parents Rank field is required');
                          $('#err_msg_spouse_parents_rank').attr('hidden',false);
                          $("select#spouse_parents_rank").addClass('red-border');              
                        }
                        else if($("select#spouse_parents_rank").val()!=null){
                          $('#err_msg_spouse_parents_rank').attr('hidden',true);
                          $("select#spouse_parents_rank").removeClass('red-border');  

                        }
                        $('select#spouse_parents_rank').on('change',function(){
                          if($("select#spouse_parents_rank").val()!=null){
                           $('#err_msg_spouse_parents_rank').attr('hidden',true);
                           $("select#spouse_parents_rank").removeClass('red-border');  
                         }
                         else{
                          $('#err_msg_spouse_parents_rank').attr('hidden',false);
                          $("select#spouse_parents_rank").addClass('red-border');     
                        }
                      })
             /////
             if($("select#spouse_parents_unit").val()==null){
              $('#err_spouse_parents_unit').text('Spouses/Parents Rank field is required');
              $('#err_msg_spouse_parents_unit').attr('hidden',false);
              $("select#spouse_parents_unit").addClass('red-border');              
            }
            else if($("select#spouse_parents_unit").val()!=null){
              $('#err_msg_spouse_parents_unit').attr('hidden',true);
              $("select#spouse_parents_unit").removeClass('red-border');  

            }
            $('select#spouse_parents_unit').on('change',function(){
              if($("select#spouse_parents_unit").val()!=null){
               $('#err_msg_spouse_parents_unit').attr('hidden',true);
               $("select#spouse_parents_unit").removeClass('red-border');  
             }
             else{
              $('#err_msg_spouse_parents_unit').attr('hidden',false);
              $("select#spouse_parents_unit").addClass('red-border');     
            }
          })
             /////
             if($("input#spouse_parent_BA_no").val()==''){
              $('#err_applicant_spouse_parent_BA_no').text('Spouse/Parents BA No. field is required');
              $('#err_msg_applicant_spouse_parent_BA_no').attr('hidden',false);
              $("input#spouse_parent_BA_no").addClass('red-border');
            }
            else if($("input#spouse_parent_BA_no").val()!=null){
              $('#err_msg_applicant_spouse_parent_BA_no').attr('hidden',true);
              $("input#spouse_parent_BA_no").removeClass('red-border'); 

            }
            $("input#spouse_parent_BA_no").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicant_spouse_parent_BA_no').attr('hidden',true);
               $("input#spouse_parent_BA_no").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicant_spouse_parent_BA_no').attr('hidden',false);
              $("input#spouse_parent_BA_no").addClass('red-border');    
            }
          });
            /////      
                   /////
                   if($("input#spouse_parent_name").val()==''){
                    $('#err_applicant_spouse_parent_name').text('Spouse/Parents BA No. field is required');
                    $('#err_msg_applicant_spouse_parent_name').attr('hidden',false);
                    $("input#spouse_parent_name").addClass('red-border');
                  }
                  else if($("input#spouse_parent_name").val()!=null){
                    $('#err_msg_applicant_spouse_parent_name').attr('hidden',true);
                    $("input#spouse_parent_name").removeClass('red-border'); 

                  }
                  $("input#spouse_parent_name").on("keyup bind cut change copy paste", function () {
                    if($(this).val()!=null){
                     $('#err_msg_applicant_spouse_parent_name').attr('hidden',true);
                     $("input#spouse_parent_name").removeClass('red-border'); 
                   }
                   else{
                    $('#err_msg_applicant_spouse_parent_name').attr('hidden',false);
                    $("input#spouse_parent_name").addClass('red-border');    
                  }
                });
            /////

          }
          else if($("#applicant_spouse_child").not(':checked')){
  /////
  if($("select#applicant_rank").val()==null){
    $('#err_applicant_rank').text('Spouses/Parents Rank field is required');
    $('#err_msg_applicant_rank').attr('hidden',false);
    $("select#applicant_rank").addClass('red-border');              
  }
  else if($("select#applicant_rank").val()!=null){
    $('#err_msg_applicant_rank').attr('hidden',true);
    $("select#applicant_rank").removeClass('red-border');  

  }
  $('select#applicant_rank').on('change',function(){
    if($("select#applicant_rank").val()!=null){
     $('#err_msg_applicant_rank').attr('hidden',true);
     $("select#applicant_rank").removeClass('red-border');  
   }
   else{
    $('#err_msg_applicant_rank').attr('hidden',false);
    $("select#applicant_rank").addClass('red-border');     
  }
})
             /////
             if($("input#BA_no").val()==''){
              $('#err_applicant_BA_no').text('BA No. field is required');
              $('#err_msg_applicant_BA_no').attr('hidden',false);
              $("input#BA_no").addClass('red-border');
            }
            else if($("input#BA_no").val()!=null){
              $('#err_msg_applicant_BA_no').attr('hidden',true);
              $("input#BA_no").removeClass('red-border'); 

            }
            $("input#BA_no").on("keyup bind cut change copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_applicant_BA_no').attr('hidden',true);
               $("input#BA_no").removeClass('red-border'); 
             }
             else{
              $('#err_msg_applicant_BA_no').attr('hidden',false);
              $("input#BA_no").addClass('red-border');    
            }
          });
            /////  
          }
         /////



       }

       function vehicleInfoValidate(){
        if($("select#vehicle_type").val()==null){
          $('#err_vehicletype').text('Vehicle type field is required');
          $('#err_msg_vehicletype').attr('hidden',false);
          $("select#vehicle_type").addClass('red-border');              
        }
        else if($("select#vehicle_type").val()!=null){
          $('#err_msg_vehicletype').attr('hidden',true);
          $("select#vehicle_type").removeClass('red-border');  

        }
        $('select#vehicle_type').on('change',function(){
          if($("select#vehicle_type").val()!=null){
           $('#err_msg_vehicletype').attr('hidden',true);
           $("select#vehicle_type").removeClass('red-border');  
         }
         else{
          $('#err_msg_vehicletype').attr('hidden',false);
          $("select#vehicle_type").addClass('red-border');     
        }
      })

        if($("input#vehicle_reg_no").val()==''){
          $('#err_vehiclereg').text('Vehicle Registration Number field is required');
          $('#err_msg_vehiclereg').attr('hidden',false);
          $("input#vehicle_reg_no").addClass('red-border'); 
        }
        else if($("input#vehicle_reg_no").val()!=null){
          $('#err_msg_vehiclereg').attr('hidden',true); 
          $("input#vehicle_reg_no").removeClass('red-border');

        }
        $("input#vehicle_reg_no").on("keyup bind cut copy paste", function () {
          if($(this).val()!=null){
           $('#err_msg_vehiclereg').attr('hidden',true); 
           $("input#vehicle_reg_no").removeClass('red-border');
         }
         else{
          $('#err_msg_vehiclereg').attr('hidden',false); 
          $("input#vehicle_reg_no").addClass('red-border');   
        }
      });   
        if($("input#owner_name").val()==''){
          $('#err_ownername').text('Owner name field is required');
          $('#err_msg_ownername').attr('hidden',false);
          $("input#owner_name").addClass('red-border');
        }
        else if($("input#owner_name").val()!=null){
          $('#err_msg_ownername').attr('hidden',true);
          $("input#owner_name").removeClass('red-border'); 

        }
        $("input#owner_name").on("keyup bind cut copy paste", function () {
          if($(this).val()!=null){
           $('#err_msg_ownername').attr('hidden',true);
           $("input#owner_name").removeClass('red-border'); 
         }
         else{
          $('#err_msg_ownername').attr('hidden',false);
          $("input#owner_name").addClass('red-border');    
        }
      });

        if($('#image2_b').val()===''){
          $('#err_vehicleregphoto').text('Registration certificate copy is required');
          $('#err_msg_vehicleregphoto').attr('hidden',false);
          $("#image2_b").addClass('red-border');
        }
        else if($('#image2_b').val()!=''){
          $('#err_msg_vehicleregphoto').attr('hidden',true);
          $("#image2_b").removeClass('red-border');
        }

        $('#image2_b').on('change',function(){
          if($('#image2_b').val()!=''){
           $('#err_msg_vehicleregphoto').attr('hidden',true);
           $("#image2_b").removeClass('red-border');
         }
         else{
          $('#err_msg_vehicleregphoto').attr('hidden',false);
          $("#image2_b").addClass('red-border');
        }
      });

         /////
         if($("#is_transparent").is(':checked')){
          $(".is_transparent_hide").attr('hidden', false);
          $(".is_transparent_hide input[type='text']").attr('required', true);

          if($("select#glass_type").val()==null){
            $('#err_glasstype').text('Glass type field is required');
            $('#err_msg_glasstype').attr('hidden',false);
            $("select#glass_type").addClass('red-border');              
          }
          else if($("select#glass_type").val()!=null){
            $('#err_msg_glasstype').attr('hidden',true);
            $("select#glass_type").removeClass('red-border');  

          }
          $('select#glass_type').on('change',function(){
            if($("select#glass_type").val()!=null){
             $('#err_msg_glasstype').attr('hidden',true);
             $("select#glass_type").removeClass('red-border');  
           }
           else{
            $('#err_msg_glasstype').attr('hidden',false);
            $("select#glass_type").addClass('red-border');     
          }
        })


        }

            //////  
             /////
             if($(".owner_is_company").is(':checked')){
              if($("input#company_name").val()==''){
                $('#err_companyname').text('Company name field is required');
                $('#err_msg_companyname').attr('hidden',false);
                $("input#company_name").addClass('red-border');
              }
              else if($("input#company_name").val()!=null){
                $('#err_msg_companyname').attr('hidden',true);
                $("input#company_name").removeClass('red-border'); 

              }
              $("input#company_name").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyname').attr('hidden',true);
                 $("input#company_name").removeClass('red-border'); 
               }
               else{
                $('#err_msg_companyname').attr('hidden',false);
                $("input#company_name").addClass('red-border');    
              }
            });
              ////
              if($("input#c_flat").val()==''){
                $('#err_companyflat').text('Flat field is required');
                $('#err_msg_companyflat').attr('hidden',false);
                $("input#c_flat").addClass('red-border');
              }
              else if($("input#c_flat").val()!=null){
                $('#err_msg_companyflat').attr('hidden',true);
                $("input#c_flat").removeClass('red-border'); 

              }
              $("input#c_flat").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyflat').attr('hidden',true); 
                 $("input#c_flat").removeClass('red-border');
               }
               else{
                $('#err_msg_companyflat').attr('hidden',false);
                $("input#c_flat").addClass('red-border');    
              }
            });
              /////
              ////
              if($("input#c_house").val()==''){
                $('#err_companyhouse').text('House field is required');
                $('#err_msg_companyhouse').attr('hidden',false);
                $("input#c_house").addClass('red-border');
              }
              else if($("input#c_house").val()!=null){
                $('#err_msg_companyhouse').attr('hidden',true);
                $("input#c_house").removeClass('red-border'); 

              }
              $("input#c_house").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyhouse').attr('hidden',true); 
                 $("input#c_house").removeClass('red-border');
               }
               else{
                $('#err_msg_companyhouse').attr('hidden',false);
                $("input#c_house").addClass('red-border');    
              }
            });
              /////
              ////
              if($("input#c_road").val()==''){
                $('#err_companyroad').text('Road field is required');
                $('#err_msg_companyroad').attr('hidden',false);
                $("input#c_road").addClass('red-border');
              }
              else if($("input#c_road").val()!=null){
                $('#err_msg_companyroad').attr('hidden',true);
                $("input#c_road").removeClass('red-border'); 

              }
              $("input#c_road").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyroad').attr('hidden',true); 
                 $("input#c_road").removeClass('red-border');
               }
               else{
                $('#err_msg_companyroad').attr('hidden',false);
                $("input#c_road").addClass('red-border');    
              }
            });
              /////
              ////
              if($("input#c_block").val()==''){
                $('#err_companyblock').text('Block field is required');
                $('#err_msg_companyblock').attr('hidden',false);
                $("input#c_block").addClass('red-border');
              }
              else if($("input#c_block").val()!=null){
                $('#err_msg_companyblock').attr('hidden',true);
                $("input#c_block").removeClass('red-border'); 
              }
              $("input#c_block").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyblock').attr('hidden',true); 
                 $("input#c_block").removeClass('red-border');
               }
               else{
                $('#err_msg_companyblock').attr('hidden',false);
                $("input#c_block").addClass('red-border');    
              }
            });
              ///// 



               ////
               if($("input#c_area").val()==''){
                $('#err_companyarea').text('Area field is required');
                $('#err_msg_companyarea').attr('hidden',false);
                $("input#c_area").addClass('red-border');
              }
              else if($("input#c_area").val()!=null){
                $('#err_msg_companyarea').attr('hidden',true);
                $("input#c_area").removeClass('red-border'); 

              }
              $("input#c_area").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_companyarea').attr('hidden',true); 
                 $("input#c_area").removeClass('red-border');
               }
               else{
                $('#err_msg_companyarea').attr('hidden',false);
                $("input#c_area").addClass('red-border');    
              }
            });


            }

            //////

            if($("input#o_area").val()==''){
              $('#err_ownerarea').text('Area field is required');
              $('#err_msg_ownerarea').attr('hidden',false);
              $("input#o_area").addClass('red-border');
            }
            else if($("input#o_area").val()!=null){
              $('#err_msg_ownerarea').attr('hidden',true);
              $("input#o_area").removeClass('red-border'); 

            }
            $("input#o_area").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerarea').attr('hidden',true); 
               $("input#o_area").removeClass('red-border');
             }
             else{
              $('#err_msg_ownerarea').attr('hidden',false);
              $("input#o_area").addClass('red-border');    
            }
          });


            if($("input#o_flat").val()==''){
              $('#err_ownerflat').text('Flat field is required');
              $('#err_msg_ownerflat').attr('hidden',false);
              $("input#o_flat").addClass('red-border');
            }
            else if($("input#o_flat").val()!=null){
              $('#err_msg_ownerflat').attr('hidden',true);
              $("input#o_flat").removeClass('red-border'); 

            }
            $("input#o_flat").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerflat').attr('hidden',true);
               $("input#o_flat").removeClass('red-border'); 
             }
             else{
              $('#err_msg_ownerflat').attr('hidden',false); 
              $("input#o_flat").addClass('red-border');   
            }
          });     

            if($("input#o_house").val()==''){
              $('#err_ownerhouse').text('House field is required');
              $('#err_msg_ownerhouse').attr('hidden',false);
              $("input#o_house").addClass('red-border');
            }
            else if($("input#o_house").val()!=null){
              $('#err_msg_ownerhouse').attr('hidden',true);
              $("input#o_house").removeClass('red-border'); 

            }
            $("input#o_house").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerhouse').attr('hidden',true);
               $("input#o_house").removeClass('red-border'); 
             }
             else{
              $('#err_msg_ownerhouse').attr('hidden',false); 
              $("input#o_house").addClass('red-border');   
            }
          });


            if($("input#o_road").val()==''){
              $('#err_ownerroad').text('Road field is required');
              $('#err_msg_ownerroad').attr('hidden',false);
              $("input#o_road").addClass('red-border');
            }
            else if($("input#o_road").val()!=null){
              $('#err_msg_ownerroad').attr('hidden',true);
              $("input#o_road").removeClass('red-border'); 

            }
            $("input#o_road").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerroad').attr('hidden',true);
               $("input#o_road").removeClass('red-border'); 
             }
             else{
              $('#err_msg_ownerroad').attr('hidden',false);
              $("input#o_road").addClass('red-border');    
            }
          });

            if($("input#o_block").val()==''){
              $('#err_ownerblock').text('Block field is required');
              $('#err_msg_ownerblock').attr('hidden',false);
              $("input#o_block").addClass('red-border');
            }
            else if($("input#o_block").val()!=null){
              $('#err_msg_ownerblock').attr('hidden',true); 
              $("input#o_block").removeClass('red-border');

            }
            $("input#o_block").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerblock').attr('hidden',true); 
               $("input#o_block").removeClass('red-border');
             }
             else{
              $('#err_msg_ownerblock').attr('hidden',false);  
              $("input#o_block").addClass('red-border');  
            }
          });
            /////
            if($("input#owner_nid").val()==''){
              $('#err_ownerNid').text('Owner NID field is required');
              $('#err_msg_ownerNid').attr('hidden',false);
              $("input#owner_nid").addClass('red-border');
            }
            else if($("input#owner_nid").val()!=null){
              $('#err_msg_ownerNid').attr('hidden',true); 
              $("input#owner_nid").removeClass('red-border');

            }
            $("input#owner_nid").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_ownerNid').attr('hidden',true);
               $("input#owner_nid").removeClass('red-border'); 
             }
             else{
              $('#err_msg_ownerNid').attr('hidden',false);  
              $("input#owner_nid").addClass('red-border');  
            }
          });
            /////
            if($('#image3_b').val()===''){
              $('#err_ownerNidCopy').text('Owner NID copy is required');
              $('#err_msg_ownerNidCopy').attr('hidden',false);
              $("#image3_b").addClass('red-border');
            }
            else if($('#image3_b').val()!=''){
              $('#err_msg_ownerNidCopy').attr('hidden',true);
              $("#image3_b").removeClass('red-border');
            }

            $('#image3_b').on('change',function(){
              if($('#image3_b').val()!=''){
               $('#err_msg_ownerNidCopy').attr('hidden',true); 
               $("#image3_b").removeClass('red-border');
             }
             else{
              $('#err_msg_ownerNidCopy').attr('hidden',false); 
              $("#image3_b").addClass('red-border');
            }
          });
               ///
               if($('#image4_b').val()===''){
                $('#err_taxCopy').text('Tax Token copy is required');
                $('#err_msg_taxCopy').attr('hidden',false);
                $("#image4_b").addClass('red-border');
              }
              else if($('#image4_b').val()!=''){
                $('#err_msg_taxCopy').attr('hidden',true);
                $("#image4_b").removeClass('red-border');
              }

              $('#image4_b').on('change',function(){
                if($('#image4_b').val()!=''){
                 $('#err_msg_taxCopy').attr('hidden',true);
                 $("#image4_b").removeClass('red-border');
               }
               else{
                $('#err_msg_taxCopy').attr('hidden',false); 
                $("#image4_b").addClass('red-border');
              }
            });
               ///
               if($('#image5_b').val()===''){
                $('#err_fitnessCopy').text('Fitness certificate copy is required');
                $('#err_msg_fitnessCopy').attr('hidden',false); 
                $("#image5_b").addClass('red-border');
              }
              else if($('#image5_b').val()!=''){
                $('#err_msg_fitnessCopy').attr('hidden',true);
                $("#image5_b").removeClass('red-border');
              }

              $('#image5_b').on('change',function(){
                if($('#image5_b').val()!=''){
                 $('#err_msg_fitnessCopy').attr('hidden',true); 
                 $("#image5_b").removeClass('red-border');
               }
               else{
                $('#err_msg_fitnessCopy').attr('hidden',false); 
                $("#image5_b").addClass('red-border');
              }
            });
               ///
               if($('#image6_b').val()===''){
                $('#err_insuranceCopy').text('Insurance certificate copy is required');
                $('#err_msg_insuranceCopy').attr('hidden',false);
                $("#image6_b").addClass('red-border');
              }
              else if($('#image6_b').val()!=''){
                $('#err_msg_insuranceCopy').attr('hidden',true);
                $("#image6_b").removeClass('red-border');
              }

              $('#image6_b').on('change',function(){
                if($('#image6_b').val()!=''){
                 $('#err_msg_insuranceCopy').attr('hidden',true);
                 $("#image6_b").removeClass('red-border');
               }
               else{
                $('#err_msg_insuranceCopy').attr('hidden',false);
                $("#image6_b").addClass('red-border');
              }
            });
               /////
               if($("input#tax_paid_upto").val()==''){
                $('#err_taxVal').text('Tax token validity date field is required');
                $('#err_msg_taxVal').attr('hidden',false);
                $("input#tax_paid_upto").addClass('red-border');
              }
              else if($("input#tax_paid_upto").val()!=null){
                $('#err_msg_taxVal').attr('hidden',true); 
                $("input#tax_paid_upto").removeClass('red-border');

              }
              $("input#tax_paid_upto").on("change", function () {
                if($(this).val()!=null){
                 $('#err_msg_taxVal').attr('hidden',true); 
                 $("input#tax_paid_upto").removeClass('red-border');
               }
               else{
                $('#err_msg_taxVal').attr('hidden',false); 
                $("input#tax_paid_upto").addClass('red-border');   
              }
            });
            /////
            if($("input#fitnness_validity").val()==''){
              $('#err_fitnessVal').text('Fitnness validity date field is required');
              $('#err_msg_fitnessVal').attr('hidden',false);
              $("input#fitnness_validity").addClass('red-border');
            }
            else if($("input#fitnness_validity").val()!=null){
              $('#err_msg_fitnessVal').attr('hidden',true);
              $("input#fitnness_validity").removeClass('red-border'); 

            }
            $("input#fitnness_validity").on("change", function () {
              if($(this).val()!=null){
               $('#err_msg_fitnessVal').attr('hidden',true);
               $("input#fitnness_validity").removeClass('red-border'); 
             }
             else{
              $('#err_msg_fitnessVal').attr('hidden',false);
              $("input#fitnness_validity").addClass('red-border');    
            }
        
            
          });

               /////      
               if($("textarea#in_out_gate").val()==''){
                $('#err_inOut_Gate').text('In/Out Gate field is required');
                $('#err_msg_inOut_Gate').attr('hidden',false);
                $("textarea#in_out_gate").addClass('red-border');
              }
              else if($("textarea#in_out_gate").val()!=''){
                $('#err_msg_inOut_Gate').attr('hidden',true);
                $("textarea#in_out_gate").removeClass('red-border');
              }
              $('textarea#in_out_gate').on('change',function(){
                if($("textarea#in_out_gate").val()!=''){
                  $('#err_msg_inOut_Gate').attr('hidden',true);
                  $("textarea#in_out_gate").removeClass('red-border');
                }
                else{
                  $('#err_msg_inOut_Gate').attr('hidden',false);
                  $("textarea#in_out_gate").addClass('red-border');
                }
              });
               /////    
               ///////

             }
             function notSelfDriven(){
              if($("input#driver_name").val()==''){
                $('#err_drivername').text('Driver Name field is required');
                $('#err_msg_drivername').attr('hidden',false);
                $("input#driver_name").addClass('red-border');
              }
              else if($("input#driver_name").val()!=null){
                $('#err_msg_drivername').attr('hidden',true);
                $("input#driver_name").removeClass('red-border'); 

              }
              $("input#driver_name").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_drivername').attr('hidden',true); 
                 $("input#driver_name").removeClass('red-border');
               }
               else{
                $('#err_msg_drivername').attr('hidden',false);
                $("input#driver_name").addClass('red-border');    
              }
            });
            /////
            if($('#image10_b').val()===''){
              $('#err_driverphoto').text('Driver Photo is required');
              $('#err_msg_driverphoto').attr('hidden',false); 
              $("#image10_b").addClass('red-border');             
            }
            else if($('#image10_b').val()!=''){
              $('#err_msg_driverphoto').attr('hidden',true);
              $("#image10_b").removeClass('red-border');
            }

            $('#image10_b').on('change',function(){
              if($('#image10_b').val()!=''){
               $('#err_msg_driverphoto').attr('hidden',true);
               $("#image10_b").removeClass('red-border'); 
             }
             else{
              $('#err_msg_driverphoto').attr('hidden',false);
              $("#image10_b").addClass('red-border');    
            }
          });
               /////
               if($("input#dri_pre_house").val()==''){
                $('#err_driverhouse').text('House field is required');
                $('#err_msg_driverhouse').attr('hidden',false);
                $("input#dri_pre_house").addClass('red-border');
              }
              else if($("input#dri_pre_house").val()!=null){
                $('#err_msg_driverhouse').attr('hidden',true);
                $("input#dri_pre_house").removeClass('red-border'); 

              }
              $("input#dri_pre_house").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_driverhouse').attr('hidden',true);
                 $("input#dri_pre_house").removeClass('red-border'); 
               }
               else{
                $('#err_msg_driverhouse').attr('hidden',false);
                $("input#dri_pre_house").addClass('red-border');    
              }
            });
            /////            
               /////
               if($("input#dri_pre_flat").val()==''){
                $('#err_driverflat').text('Flat field is required');
                $('#err_msg_driverflat').attr('hidden',false);
                $("input#dri_pre_flat").addClass('red-border');
              }
              else if($("input#dri_pre_flat").val()!=null){
                $('#err_msg_driverflat').attr('hidden',true);
                $("input#dri_pre_flat").removeClass('red-border'); 

              }
              $("input#dri_pre_flat").on("keyup bind cut copy paste", function () {
                if($(this).val()!=null){
                 $('#err_msg_driverflat').attr('hidden',true);
                 $("input#dri_pre_flat").removeClass('red-border'); 
               }
               else{
                $('#err_msg_driverflat').attr('hidden',false);
                $("input#dri_pre_flat").addClass('red-border');    
              }
            });
            /////
            if($("input#dri_pre_road").val()==''){
              $('#err_driverroad').text('Road field is required');
              $('#err_msg_driverroad').attr('hidden',false);
              $("input#dri_pre_road").addClass('red-border');
            }
            else if($("input#dri_pre_road").val()!=null){
              $('#err_msg_driverroad').attr('hidden',true);
              $("input#dri_pre_road").removeClass('red-border'); 

            }
            $("input#dri_pre_road").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_driverroad').attr('hidden',true);
               $("input#dri_pre_road").removeClass('red-border'); 
             }
             else{
              $('#err_msg_driverroad').attr('hidden',false);
              $("input#dri_pre_road").addClass('red-border');    
            }
          });
            /////
            if($("input#dri_pre_block").val()==''){
              $('#err_driverblock').text('Block field is required');
              $('#err_msg_driverblock').attr('hidden',false);
              $("input#dri_pre_block").addClass('red-border');
            }
            else if($("input#dri_pre_block").val()!=null){
              $('#err_msg_driverblock').attr('hidden',true);
              $("input#dri_pre_block").removeClass('red-border'); 

            }
            $("input#dri_pre_block").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_driverblock').attr('hidden',true); 
               $("input#dri_pre_block").removeClass('red-border');
             }
             else{
              $('#err_msg_driverblock').attr('hidden',false);
              $("input#dri_pre_block").addClass('red-border');    
            }
          });
            /////
            if($("input#dri_pre_area").val()==''){
              $('#err_driverarea').text('Area field is required');
              $('#err_msg_driverarea').attr('hidden',false);
              $("input#dri_pre_area").addClass('red-border');
            }
            else if($("input#dri_pre_area").val()!=null){
              $('#err_msg_driverarea').attr('hidden',true);
              $("input#dri_pre_area").removeClass('red-border'); 

            }
            $("input#dri_pre_area").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_driverarea').attr('hidden',true);
               $("input#dri_pre_area").removeClass('red-border'); 
             }
             else{
              $('#err_msg_driverarea').attr('hidden',false);
              $("input#dri_pre_area").addClass('red-border');    
            }
          });
            /////
            if($("input#drivernid_number").val()==''){
              $('#err_driverNid').text('Driver NID Number field is required');
              $('#err_msg_driverNid').attr('hidden',false);
              $("input#drivernid_number").addClass('red-border');
            }
            else if($("input#drivernid_number").val()!=null){
              $('#err_msg_driverNid').attr('hidden',true);
              $("input#drivernid_number").removeClass('red-border'); 
            }
            $("input#drivernid_number").on("keyup bind cut copy paste", function () {
              if($(this).val()!=null){
               $('#err_msg_driverNid').attr('hidden',true);
               $("input#drivernid_number").removeClass('red-border'); 
             }
             else{
              $('#err_msg_driverNid').attr('hidden',false);
              $("input#drivernid_number").addClass('red-border');    
            }
          });
            /////
            if($('#image11_b').val()===''){
              $('#err_driverNidcopy').text('Driver NID Copy is required');
              $('#err_msg_driverNidcopy').attr('hidden',false);
              $("#image11_b").addClass('red-border');              
            }
            else if($('#image11_b').val()!=''){
              $('#err_msg_driverNidcopy').attr('hidden',true);
              $("#image11_b").removeClass('red-border');
            }

            $('#image11_b').on('change',function(){
              if($('#image11_b').val()!=''){
               $('#err_msg_driverNidcopy').attr('hidden',true);
               $("#image11_b").removeClass('red-border'); 
             }
             else{
              $('#err_msg_driverNidcopy').attr('hidden',false);
              $("#image11_b").addClass('red-border');    
            }
          });  
                 /////
                 if($('#image12_b').val()===''){
                  $('#err_driverlicence').text('Driver Licence Copy is required');
                  $('#err_msg_driverlicence').attr('hidden',false);
                  $("#image12_b").addClass('red-border');              
                }
                else if($('#image12_b').val()!=''){
                  $('#err_msg_driverlicence').attr('hidden',true);
                  $("#image12_b").removeClass('red-border');
                }

                $('#image12_b').on('change',function(){
                  if($('#image12_b').val()!=''){
                   $('#err_msg_driverlicence').attr('hidden',true);
                   $("#image12_b").removeClass('red-border'); 
                 }
                 else{
                  $('#err_msg_driverlicence').attr('hidden',false);
                  $("#image12_b").addClass('red-border');    
                }
              });
              }
              if($('#self_driven_checkbox').is(':checked')){
                $(".not_self_driven").attr('hidden', true);
                $(".not_self_driven input").attr('required', false);

              }
              else{
               $('.not_self_driven').attr('hidden', false);
               $(".Applycationform .not_self_driven input").attr('required', true);
               $(".not_self_driven input[type='checkbox']").attr('required', false);
               $(".driver_perm input").attr('required', false);

             } 
             function driverInfoValidate(){

              if($('#image12_b').val()===''){
                $('#err_driverlicence').text('Driver Licence Copy is required');
                $('#err_msg_driverlicence').attr('hidden',false); 
                $("#image12_b").addClass('red-border');             
              }
              else if($('#image12_b').val()!=''){
                $('#err_msg_driverlicence').attr('hidden',true);
                $("#image12_b").removeClass('red-border');
              }

              $('#image12_b').on('change',function(){
                if($('#image12_b').val()!=''){
                 $('#err_msg_driverlicence').attr('hidden',true);
                 $("#image12_b").removeClass('red-border'); 
               }
               else{
                $('#err_msg_driverlicence').attr('hidden',false);
                $("#image12_b").addClass('red-border');    
              }
            });

              if($('#self_driven_checkbox').is(':checked')){
                $(".not_self_driven").attr('hidden', true);
                $(".not_self_driven input").attr('required', false);

              }
              else{
               $('.not_self_driven').attr('hidden', false);
               $(".Applycationform .not_self_driven input").attr('required', true);
               $(".not_self_driven input[type='checkbox']").attr('required', false);
               $(".driver_perm input").attr('required', false);
               notSelfDriven();
             }        
           }
           $('.change-btn').on('click',function(){
            $(this).siblings('input').attr('disabled',false);
            $(this).siblings('.cancel-btn').attr('hidden',false);
            $(this).attr('hidden',true);
          }); 
           $('.cancel-btn').on('click',function(){
            $(this).siblings('input').attr('disabled',true);
            $(this).siblings('input').val('');
            $(this).siblings('.change-btn').attr('hidden',false);
            $(this).attr('hidden',true);
            $(this).siblings('.change-btn').data('photo');
            $(this).siblings('div').find('img').attr('src',$(this).siblings('.change-btn').data('photo'));
          });

           $("input[type='date']").on('change',function(){
            var date=new Date($(this).val());
            if (date <= new Date()){
              $(this).val('');
              $(this).parent().append("<div class='validity-check err_msg'><i  class='fas fa-exclamation-triangle'></i><span> This validity has been expired </span></div>");
            }else{
              $(this).siblings('.validity-check').remove();
            }
          })

           $("#def-E-n-btn1").click(function () {

           });                
           $("#E-n-btn3").click(function () {
           });

           $("#E-p-btn1").click(function () {
            $('#E-myTab li:nth-child(1) a').tab('show');
            windowScrollTop();
          });
           $("#E-p-btn2").click(function () {
            $('#E-myTab li:nth-child(2) a').tab('show');
            windowScrollTop();
          });   
           $("#E-p-btn3").click(function () {
            $('#E-myTab li:nth-child(3) a').tab('show');
            windowScrollTop();
          });
 $('#Application_Form_def_Edit').on('submit',function(e){
            e.preventDefault();
            var app_id = $(this).data('id');
            var form=$('#Application_Form_def_Edit');
            var formData=form.serialize();
            var url='/applicationForm/update/'+app_id;
            var type='post';
            $('#ajax-loader').attr('hidden',false);
            $.ajax({
              type:type,
              url:url,
              data:new FormData($("#Application_Form_def_Edit")[0]),
              processData:false,
              contentType:false,
              success:function(response){
               $('#ajax-loader').attr('hidden',true);

               if(response[1]=="success renew"){
                 if(response[2]=="Customer"){
                   swal(
                    'Congratulation!',response[0],'success').then(function() {
                     location.reload();
                   });
                  }else if(response[2]==""){
                    swal(
                     'Congratulation!',response[0],'success').then(function() {
                       var splitUrl = document.location.href.split('/');
                       var win = window.open('/application-review/'+splitUrl[5],'_parent');
                       win.focus();
                     });
                   }
                 }  
                 if(response[1]=="DB_Transaction_error"){
                  swal(
                   'Sorry!', response[0], 'warning').then(function() { 
                 // location.reload();    
               });
                 }


          //         toastr.success("Great!!! Application Submitted Successfully." );
          // setTimeout(function() {

              // location.reload();         
          //        }, 1500);
        },
        error:function(response){
                            var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');

          }

        });
          });

$('#applicant_detail_form-DEF').on('submit',function(e){
            e.preventDefault();
            if($("#applicant_spouse_child").is(':checked')){
              if($("input#applicant_name").val()!='' && $('#image2_e_def_id').val()!='' && $("input#spouse_parent_BA_no").val()!='' && $("select#spouse_parents_rank").val()!=null && $("input#spouse_parent_name").val()!='' && $("select#spouse_parents_unit").val()!=null && $("input#applicant_tin").val()!='' && $("select#residence_type").val()!=null && $("input#applicant_phone").val()!='' && $("input#f_h_name").val()!='' && $('#app_pre_house').val()!='' &&$('#app_pre_road').val()!=''
               && $('#image2_e').val()!='' && $('#image3_e').val()!='' && $('#image1_e').val()!='' && $("input#app_pre_block").val()!='' && $("input#app_pre_area").val()!='' && $("input#app_per_house").val()!=''
               && $("input#app_per_road").val()!='' && $("input#app_per_block").val()!='' && $("input#app_per_area").val()!='' && $("input#applicant_nid").val()!=''){
               DefApplicantDetailAjax();
           }else{
            $('#E-myTab li:nth-child(2) a').addClass('not-active');
            applicantInfoValidate();
            swal('Oops!', 'Please fill required form fields', 'warning');
          }
        }
        else if($("#applicant_spouse_child").not(':checked')){
         if($("input#applicant_name").val()!='' && $('#image2_e_def_id').val()!='' && $("input#BA_no").val()!='' && $("select#applicant_rank").val()!=null && $("input#applicant_tin").val()!='' && $("select#residence_type").val()!=null && $("input#applicant_phone").val()!='' && $("input#f_h_name").val()!='' && $('#app_pre_house').val()!='' &&$('#app_pre_road').val()!=''
           && $('#image2_e').val()!='' && $('#image3_e').val()!='' && $('#image1_e').val()!='' && $("input#app_pre_block").val()!='' && $("input#app_pre_area").val()!='' && $("input#app_per_house").val()!=''
           && $("input#app_per_road").val()!='' && $("input#app_per_block").val()!='' && $("input#app_per_area").val()!='' && $("input#applicant_nid").val()!=''){
          DefApplicantDetailAjax();
      }else{
        $('#E-myTab li:nth-child(2) a').addClass('not-active');
        applicantInfoValidate();
        swal('Oops!', 'Please fill required form fields', 'warning');
      }
    }
  });
           function DefApplicantDetailAjax(){

             $('#ajax-loader').attr('hidden',false);
             var form=$('#applicant_detail_form-DEF');
             var formData=form.serialize();
             var url='/applicant-details/store';
             var type='post';
             $.ajax({
              type:type,
              url:url,
              data:new FormData($("#applicant_detail_form-DEF")[0]),
              processData:false,
              contentType:false,
              success:function(response){
               $('#ajax-loader').attr('hidden',true);
               if(response[1]=="not_your_account"){
                swal('sorry', response[0] , 'warning');
              }else{
                $('#E-myTab li:nth-child(2) a').removeClass('not-active');
                $('#E-myTab li:nth-child(2) a').tab('show');
                windowScrollTop();        
              }

            },

            error:function(response){
                
                 var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
            }
          });
           }
$('#applicant_detail_form').on('submit',function(e){
            e.preventDefault();
            if($("input#applicant_name").val()!='' && $("input#applicant_tin").val()!='' && $("select#residence_type").val()!=null && $("input#applicant_phone").val()!='' && $("input#f_h_name").val()!='' && $('#app_pre_house').val()!='' &&$('#app_pre_road').val()!=''
              && $('#image2_e').val()!='' && $('#image3_e').val()!='' && $('#image1_e').val()!='' && $("input#app_pre_block").val()!='' && $("input#app_pre_area").val()!='' && $("input#app_per_house").val()!=''
              && $("input#app_per_road").val()!='' && $("input#app_per_block").val()!='' && $("input#app_per_area").val()!='' && $("input#applicant_nid").val()!='')
            {  

             $('#ajax-loader').attr('hidden',false);
             var form=$('#applicant_detail_form');
             var formData=form.serialize();
             var url='/applicant-details/store';
             var type='post';
             $.ajax({
              type:type,
              url:url,
              data:new FormData($("#applicant_detail_form")[0]),
              processData:false,
              contentType:false,
              success:function(response){
                $('#ajax-loader').attr('hidden',true);
                $('#E-myTab li:nth-child(2) a').removeClass('not-active');
                $('#E-myTab li:nth-child(2) a').tab('show');
                windowScrollTop();
              },

              error:function(response){
                                var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
              }
            });
           }
           else{
            $('#E-myTab li:nth-child(2) a').addClass('not-active');
            applicantInfoValidate();
            swal('Oops!', 'Please fill required form fields', 'warning');
          }
});
$('#applicant_detail_form_Edit').on('submit',function(e){
  e.preventDefault();
  $('#ajax-loader').attr('hidden',false);
  var app_id = $(this).data('id');
  var form=$('#applicant_detail_form_Edit');
  var formData=form.serialize();
  var url='/applicant-detail/update/'+app_id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#applicant_detail_form_Edit")[0]),
    processData:false,
    contentType:false,
    success:function(response){
     $('#ajax-loader').attr('hidden',true);
     if(response[1]=="not_your_account"){
      swal('sorry!', response[0] , 'warning');
    }
    else if(response[1]=="success"){
      swal('Great!', response[0] , 'success').then(function(){
       windowScrollTop(); 
       location.reload();
     });

    }
  },
  error:function(response){
                        var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
          }
        });
});
$('#vehicle_detail_form').on('submit',function(e){
            e.preventDefault();
            if($("#is_transparent").is(':checked') && $(".owner_is_company").is(':checked')){
              if($("input#company_name").val()!='' && $("select#glass_type").val()!=null  && $("input#c_flat").val()!='' && $("input#c_road").val()!='' && $("input#c_block").val()!='' && $("input#c_house").val()!='' && $("input#c_area").val()!='' && $("input#fitnness_validity").val()!='' && $("input#tax_paid_upto").val()!='' && $('#image5_b').val()!=''
               && $('#image4_b').val()!='' && $('#image3_b').val()!='' && $('#image2_b').val()!='' && $("input#owner_nid").val()!='' && $("input#o_block").val()!='' && $("input#o_house").val()!=''
               && $("input#o_road").val()!='' && $("input#o_area").val()!='' && $("input#o_flat").val()!='' && $("textarea#in_out_gate").val()!='' && $("input#owner_name").val()!='' && $("select#vehicle_type").val()!=null && $("input#vehicle_reg_no").val()!='' ){
                vehicleDetailAjaxSubmit();
            }else{
              $('#B-myTab li:nth-child(3) a').addClass('not-active');
              $('#E-myTab li:nth-child(3) a').addClass('not-active');
              vehicleInfoValidate();
              swal('Oops!', 'Please fill required form fields', 'warning');
            }
          }
          else if($(".owner_is_company").is(':checked') && $("#is_transparent").not(':checked')  ){                
            if($("input#company_name").val()!='' && $("input#c_flat").val()!='' && $("input#c_road").val()!='' && $("input#c_block").val()!='' && $("input#c_house").val()!='' && $("input#c_area").val()!='' && $("input#fitnness_validity").val()!='' && $("input#tax_paid_upto").val()!='' && $('#image5_b').val()!=''
             && $('#image4_b').val()!='' && $('#image3_b').val()!='' && $('#image2_b').val()!='' && $("input#owner_nid").val()!='' && $("input#o_block").val()!='' && $("input#o_house").val()!=''
             && $("input#o_road").val()!='' && $("input#o_area").val()!='' && $("input#o_flat").val()!='' && $("textarea#in_out_gate").val()!='' && $("input#owner_name").val()!='' && $("select#vehicle_type").val()!=null && $("input#vehicle_reg_no").val()!='' ){

             vehicleDetailAjaxSubmit();
         }else{
          $('#B-myTab li:nth-child(3) a').addClass('not-active');
          $('#E-myTab li:nth-child(3) a').addClass('not-active');
          vehicleInfoValidate();
          swal('Oops!', 'Please fill required form fields', 'warning');
        }
      }
      else if($("#is_transparent").is(':checked') && $(".owner_is_company").not(':checked')){ 
       if($("select#glass_type").val()!=null && $("input#fitnness_validity").val()!='' && $("input#tax_paid_upto").val()!='' && $('#image5_b').val()!=''
         && $('#image4_b').val()!='' && $('#image3_b').val()!='' && $('#image2_b').val()!='' && $("input#owner_nid").val()!='' && $("input#o_block").val()!='' && $("input#o_house").val()!=''
         && $("input#o_road").val()!='' && $("input#o_area").val()!='' && $("input#o_flat").val()!='' && $("textarea#in_out_gate").val()!='' && $("input#owner_name").val()!='' && $("select#vehicle_type").val()!=null && $("input#vehicle_reg_no").val()!='' ){

         vehicleDetailAjaxSubmit();

     }else{
      $('#B-myTab li:nth-child(3) a').addClass('not-active');
      $('#E-myTab li:nth-child(3) a').addClass('not-active');
      vehicleInfoValidate();
      swal('Oops!', 'Please fill required form fields', 'warning');
    }
  }
  else if($("#is_transparent").not(':checked') && $(".owner_is_company").not(':checked')){
    if($("input#fitnness_validity").val()!='' && $("input#tax_paid_upto").val()!='' && $('#image5_b').val()!=''
     && $('#image4_b').val()!='' && $('#image3_b').val()!='' && $('#image2_b').val()!='' && $("input#owner_nid").val()!='' && $("input#o_block").val()!='' && $("input#o_house").val()!=''
     && $("input#o_road").val()!='' && $("input#o_area").val()!='' && $("input#o_flat").val()!='' && $("textarea#in_out_gate").val()!='' && $("input#owner_name").val()!='' && $("select#vehicle_type").val()!=null && $("input#vehicle_reg_no").val()!='' ){

      vehicleDetailAjaxSubmit();

  }else{
    $('#B-myTab li:nth-child(3) a').addClass('not-active');
    $('#E-myTab li:nth-child(3) a').addClass('not-active');
    vehicleInfoValidate();
    swal('Oops!', 'Please fill required form fields', 'warning');
  }
}
});
function vehicleDetailAjaxSubmit(){
 $('#ajax-loader').attr('hidden',false);
 var form=$('#vehicle_detail_form');
 var formData=form.serialize();
 var url='/vehicle-detail/store';
 var type='post';
 $.ajax({
  type:type,
  url:url,
  data:new FormData($("#vehicle_detail_form")[0]),
  processData:false,
  contentType:false,
  success:function(response){
   $('#ajax-loader').attr('hidden',true);
   if(response[1]=="already-applied"){
    swal('sorry', response[0] , 'warning');
  }else{
    $('#B-myTab li:nth-child(3) a').removeClass('not-active');
    $('#B-myTab li:nth-child(3) a').tab('show'); 
    $('#E-myTab li:nth-child(3) a').removeClass('not-active');
    $('#E-myTab li:nth-child(3) a').tab('show');
    windowScrollTop();
  }

},
error:function(response){
                  var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');

}
});
}

////// Driver Info Submission
$('#driver_detail_form').on('submit',function(e){
  e.preventDefault();
  if($('#self_driven_checkbox').is(':checked') && $('#image12_b').val()!=''){
    driverFormAjaxReq();
  }
  else if($('#self_driven_checkbox').not(':checked') && $('#image12_b').val()!='' && $('#image11_b').val()!=''
   && $("input#drivernid_number").val()!=null && $("input#dri_pre_house").val()!='' && $("input#dri_pre_road").val()!=''
   && $("input#dri_pre_block").val()!='' && $("input#dri_pre_area").val()!='' && $('#image10_b').val()!=''
   && $("input#driver_name").val()!=''){
    driverFormAjaxReq();
}else{
  driverInfoValidate();
  swal('Oops!', 'Please fill required form fields', 'warning');
} 
});
function driverFormAjaxReq(){
 $('#ajax-loader').attr('hidden',false);
 var form=$('#driver_detail_form');
 var formData=form.serialize();
 var url='/driver-details/store';
 var type='post';
 $.ajax({
  type:type,
  url:url,
  data:new FormData($("#driver_detail_form")[0]),
  processData:false,
  contentType:false,
  success:function(response){
    $('#ajax-loader').attr('hidden',true);
    $('#E-myTab li:nth-child(4) a').tab('show');
    windowScrollTop();
  },
  error:function(response){
                     var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
  }
});
}
$('#document_form').on('submit',function(e){
  e.preventDefault();
  $('#ajax-loader').attr('hidden',false);
  var form=$('#document_form');
  var formData=form.serialize();
  var url='/document/store';
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#document_form")[0]),
    processData:false,
    contentType:false,
    success:function(response){
     $('#ajax-loader').attr('hidden',true);
     if(response[1]=="success renew"){
      swal(
       'Congratulation!',response[0],'success').then(function() {
         $('#ajax-loader').attr('hidden',false);
         $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type:"post",
          url:"/send-submission-sms/success/"+response[2],
          data:'',
          dataType:'json',
          success:function(res){
            // $('#ajax-loader').attr('hidden',true);
          
            window.location.href='/applied-applications';
          }
        });
         
         window.location.href = '/applied-applications';
       });

     }else if(response[1]=="success for renew"){
      swal(
       'Congratulation!',response[0],'success').then(function() {
         $('#ajax-loader').attr('hidden',false);
         $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          type:"post",
          url:"/send-submission-renew-sms/success/"+response[2],
          data:'',
          dataType:'json',
          success:function(res){
            window.location.href = '/applied-applications';
          }
        });
         window.location.href = '/applied-applications';
       });
     }  
   },
   error:function(response){
                            var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  // $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
          }
        });
});

$('#vehicle_detail_form_Edit').on('submit',function(e){
  e.preventDefault();
  $('#ajax-loader').attr('hidden',false);
  var app_id = $(this).data('id');
  var form=$('#vehicle_detail_form_Edit');
  var formData=form.serialize();
  var url='/vehicle-detail/update/'+app_id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#vehicle_detail_form_Edit")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      $('#ajax-loader').attr('hidden',true);
      if(response[1]=="success"){
        swal('Great!', response[0] , 'success').then(function(){
         windowScrollTop(); 
         location.reload();
       });
      }
    },
    error:function(response){
                          var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');
          }
        });
});


$('#driver_detail_form_Edit').on('submit',function(e){
  e.preventDefault();
  $('#ajax-loader').attr('hidden',false);
  var app_id = $(this).data('id');
  var form=$('#driver_detail_form_Edit');
  var formData=form.serialize();
  var url='/driver-detail/update/'+app_id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#driver_detail_form_Edit")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      $('#ajax-loader').attr('hidden',true);
      if(response[1]=="success"){
        swal('Great!', response[0] , 'success').then(function(){
         windowScrollTop(); 
         location.reload();
       });
      }
    },
    error:function(response){
                            var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');

          }


        });
});


$('#document_form_Edit').on('submit',function(e){
  e.preventDefault();
  $('#ajax-loader').attr('hidden',false);
  var app_id = $(this).data('id');
  var form=$('#document_form_Edit');
  var formData=form.serialize();
  var url='/document/update/'+app_id;
  var type='post';
  $.ajax({
    type:type,
    url:url,
    data:new FormData($("#document_form_Edit")[0]),
    processData:false,
    contentType:false,
    success:function(response){
      $('#ajax-loader').attr('hidden',true);
      if(response[1]=="success"){
        swal('Great!', response[0] , 'success').then(function(){
         windowScrollTop(); 
         location.reload();
       });
      }
    },
    error:function(response){
                            var errorMsg ='';
                   $.each(response.responseJSON, function(key, value){
                     $.each(value, function(key1, value1){
                          errorMsg+= '<p style="margin-bottom:5px; color:red">'+ value1+ '</p> <br>';
                     });
                });

                  $('#ajax-loader').attr('hidden',true);
                  console.log(errorMsg)
             
              swal('Oops...', errorMsg , 'error');

          }


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
      window.location.href = "/customer/login";
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

}); // End document.ready
