
<div class="content-area" id="app-content-area" style="position: relative;">
    <div id="content-heading">
        <h4>
        Application Edit Form</h4>
    </div>
    <ul class="nav nav-tabs" id="E-myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="app-info-tab" data-toggle="tab" href="#app-info" role="tab" aria-controls="app-info" aria-selected="true">Applicant's Details</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" id="vehicle-tab" data-toggle="tab" href="#vehicle" role="tab" aria-controls="vehicle" aria-selected="false">Vehicle details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="driver-tab" data-toggle="tab" href="#driver" role="tab" aria-controls="driver" aria-selected="false">Driver's details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="documents-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Documents</a>
        </li>
    </ul>
    

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show fade active" id="app-info" role="tabpanel" aria-labelledby="app-info-tab">
            <div class="container-fluid">
                <form id="applicant_detail_form_Edit" data-id="{{$app->id}}" class="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Applicant's full name</label> <span>*</span> <br>
                            <small>As per national ID card</small>
                        </div>
                        @if(!empty($app))
                        <div class="col-md-8">
                            <input type="text" id="applicant_name" value="{{$app->applicant->name}}" name="applicant_name" class="form-control in-form mandatory"  >

                        </div>
                        @else
                        <div class="col-md-8">
                            <input type="text" id="applicant_name" value="{{$app->applicant->name}}" name="applicant_name" class="form-control in-form mandatory" placeholder="" >
                            <div id="err_msg_applicantName" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantName"> </span>
                            </div>
                        </div>
                        @endif


                        @if(!empty($app->applicant->applicantDetail->applicant_photo))
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Change Applicant's photo</label> <span>*</span> <br>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <img id="prev_image1exist_e" src="{{url('/')}}{{$app->applicant->applicantDetail->applicant_photo}}"  alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                <span class="file_error"></span>
                            </div>
                            <input type="file" id="image1exist_e" accept="image/png, image/jpg, image/jpeg" name="applicant_photo" class="form-control in-form mandatory" placeholder="" value="" >
                            <div id="err_msg_applicantPhoto" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhoto"> </span>
                            </div>
                        </div>
                        @else
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Applicant's photo</label> <span>*</span> <br>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <img src="" id="prev_image1_e" alt="preview application" hidden>
                                <span class="file_error"></span>
                            </div>
                            <input type="file" id="image1_e" accept="image/png, image/jpg, image/jpeg" name="applicant_photo" class="form-control in-form mandatory" placeholder="" value="" >
                            <div id="err_msg_applicantPhoto" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhoto"> </span>
                            </div>
                        </div>
                        @endif



                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Mobile number</label> <span>*</span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="{{$app->applicant->phone}}" name="applicant_phone" id="applicant_phone" class="form-control in-form mandatory" placeholder="" >
                            <div id="err_msg_applicantPhone" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhone"> </span>
                            </div>
                        </div>

                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">
                                @if(isset($app->applicant->applicantDetail->father_name) && $app->applicant->applicantDetail->father_name != "")
                                <input type="radio" checked name="guardian" value="1"> Father
                                <input type="radio" name="guardian" value="0">  Husband's name
                                @elseif(isset($app->applicant->applicantDetail->husband_name) && $app->applicant->applicantDetail->husband_name != "")
                                <input type="radio"  name="guardian" value="1"> Father
                                <input type="radio" checked name="guardian" value="0">  Husband's name
                                @else
                                <input type="radio" checked name="guardian" value="1"> Father
                                <input type="radio" name="guardian" value="0">  Husband's name
                                @endif

                            </label> <span>*</span> <br>
                            <small>As per national ID card</small>
                        </div>
                        <div class="col-md-8">
                            @if(isset($app->applicant->applicantDetail->father_name) && $app->applicant->applicantDetail->father_name != '')

                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder=""  value="{{$app->applicant->applicantDetail->father_name}}">
                            @elseif(!empty($app->applicant->applicantDetail->husband_name))
                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder=""  value="{{$app->applicant->applicantDetail->husband_name}}">
                            @else
                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder="" >
                            @endif
                            <div id="err_msg_applicantFather" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantFather"> </span>
                            </div>
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Applicant's profession</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="{{isset($app->applicant->applicantDetail->profession) && $app->applicant->applicantDetail->profession != '' ? $app->applicant->applicantDetail->profession : ''}}" name="profession" class="form-control in-form mandatory" placeholder="" >
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Applicant's company name</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="{{isset($app->applicant->applicantDetail->company_name) && $app->applicant->applicantDetail->company_name != '' ? $app->applicant->applicantDetail->company_name : ''}}" name="ap_company_name" class="form-control in-form mandatory" placeholder="" >
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Applicant's designation</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" value="{{isset($app->applicant->applicantDetail->designation) && $app->applicant->applicantDetail->designation != '' ? $app->applicant->applicantDetail->designation : ''}}" name="designation" class="form-control in-form mandatory" placeholder="" >
                        </div>
                        <?php $app_address = null;?>

                        @if(isset($app->applicant->applicantDetail->address))
                        <?php $app_address = json_decode($app->applicant->applicantDetail->address, true);   ?>
                        @endif
                        <div class="col-md-2 offset-md-1">
                            <p style="margin-bottom: 0px; margin-top: 30px;"><b>Office Address</b></p>
                        </div>
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Flat No.</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="applicant_o_flat" id="applicant_o_flat" class="form-control in-form mandatory" value="{{isset($app_address['office']['o_flat']) ? $app_address['office']['o_flat'] : '' }}" placeholder="" >
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">House No.</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="applicant_o_house" id="applicant_o_house" class="form-control in-form mandatory" value="{{isset($app_address['office']['o_house']) ? $app_address['office']['o_house'] : '' }}" placeholder="" >
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Road No.</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="applicant_o_road" id="applicant_o_road" class=" form-control in-form mandatory" value="{{isset($app_address['office']['o_road']) ? $app_address['office']['o_road'] : '' }}" placeholder="" >
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Block/Section</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="applicant_o_block" id="applicant_o_block" class=" form-control in-form mandatory" placeholder="" value="{{isset($app_address['office']['o_block']) ? $app_address['office']['o_block'] : '' }}">
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <label for="" class="label-form">Area</label> <span></span> <br>
                            <small></small>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="applicant_o_area" id="applicant_o_area" class=" form-control in-form mandatory" placeholder="" value="{{isset($app_address['office']['o_area']) ? $app_address['office']['o_area'] : '' }}">
                        </div>
                        <div class="col-md-2 offset-md-1">
                            <p style="margin-bottom: 0px; margin-top: 30px;"><b>Present Address</b></p>
                        </div>
                        <div class="col-md-8">
                            <!-- <input type="checkbox"  name="app_address_same_as_office" id="app_address_same_as_office"  style="margin-top: 3px;width: 16px; height: 16px;" >
                                <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;" title="Use office address as present address">Same as office address</span> -->
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_flat" id="app_pre_flat" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['present']['flat']) ? $app_address['present']['flat'] : ''}}" >
                                <div id="err_msg_applicantFlat" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantFlat"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_house" id="app_pre_house" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['present']['house']) ? $app_address['present']['house'] : ''}}" >
                                <div id="err_msg_applicantHouse" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantHouse"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_road" id="app_pre_road" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['present']['road']) ? $app_address['present']['road'] : ''}}" >
                                <div id="err_msg_applicantRoad" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantRoad"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_block" id="app_pre_block" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['present']['block']) ? $app_address['present']['block'] : ''}}" >
                                <div id="err_msg_applicantBlock" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantBlock"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Area</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text"  id="app_pre_area" name="applicant_area" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['present']['road']) ? $app_address['present']['area'] : ''}}" >
                                <div id="err_msg_applicantArea" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantArea"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <p style="margin-bottom: 0px; margin-top: 30px;"><b>Permanent Address</b></p>
                            </div>
                            <div class="col-md-8">
                                @if( ($app_address['permanent'] !='') && ($app_address['present']['flat'] == $app_address['permanent']['p_flat']) && ($app_address['present']['house'] == $app_address['permanent']['p_house']) && ($app_address['present']['road'] == $app_address['permanent']['p_road']) && ($app_address['present']['block'] == $app_address['permanent']['p_block']) && ($app_address['present']['area'] == $app_address['permanent']['p_area'])) 
                                <input type="checkbox" checked name="app_address_same_as_present"
                                id="app_address_same_as_present"  style="margin-top: 3px;width: 16px; height: 16px;" >
                                @else

                                <input type="checkbox"  name="app_address_same_as_present"
                                id="app_address_same_as_present"  style="margin-top: 3px;width: 16px; height: 16px;" >
                                @endif
                                <label for="app_address_same_as_present" style="display: inline-block; margin-bottom: 0px; cursor: pointer; margin-top: 30px;"  title="Use present address as permanent address">Same as present address</label>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_p_flat" id="app_per_flat" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['permanent']['p_flat']) ? $app_address['permanent']['p_flat'] : '' }}" >
                                <div id="err_msg_applicantPFlat" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPFlat"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_p_house" id="app_per_house" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['permanent']['p_house']) ? $app_address['permanent']['p_house'] : '' }}" >
                                <div id="err_msg_applicantPHouse" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPHouse"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_p_road" id="app_per_road" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['permanent']['p_road']) ? $app_address['permanent']['p_road'] : '' }}" >
                                <div id="err_msg_applicantPRoad" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPRoad"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="applicant_p_block" id="app_per_block" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['permanent']['p_block']) ? $app_address['permanent']['p_block'] : '' }}" >
                                <div id="err_msg_applicantPBlock" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPBlock"> </span>
                                </div>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <label for="" class="label-form">Area</label> <span>*</span> <br>
                                <small></small>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="app_per_area" name="applicant_p_area" class="form-control in-form mandatory" placeholder="" value="{{isset($app_address['permanent']['p_area']) ? $app_address['permanent']['p_area'] : '' }}" >
                                <div id="err_msg_applicantPArea" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantPArea"> </span>
                                </div>
                            </div>

                            <div class="col-md-2 offset-md-1" >
                              <label for="" class="label-form">Residence Type</label> <span>*</span> <br>
                              <small></small>
                          </div>
                          <div class="col-md-8 mt-2 " >
                           <select name="residence_type" id="residence_type" class="form-control in-form mandatory" required>
                              <option  selected value="{{!empty($app->applicant->applicantDetail->residence_type)?$app->applicant->applicantDetail->residence_type:''}}">{{!empty($app->applicant->applicantDetail->residence_type)?$app->applicant->applicantDetail->residence_type:''}}</option>
                              <option  value="Own">Own</option>
                              <option  value="Rental">Rental</option>
                              <option  value="Other">Other</option>
                          </select>
                          <div id="err_msg_restype" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_restype"> </span>
                          </div>
                      </div>

                      <div class="col-md-2 offset-md-1">
                        <label for="" class="label-form">Email</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8">
                        <input type="text" value="{{$app->applicant->email ? $app->applicant->email : '' }}" name="applicant_email" class="form-control in-form" placeholder="" >
                    </div>
                    <div class="col-md-2 offset-md-1">
                      <label for="" class="label-form">Tin</label> <span>*</span> <br>
                      <small></small>
                  </div>
                  <div class="col-md-8">
                    <input type="text" value="{{!empty($app->applicant->applicantDetail->tin)?$app->applicant->applicantDetail->tin:''}}" name="applicant_tin" id="applicant_tin" class="form-control in-form required mandatory" placeholder="" required>
                    <div id="err_msg_applicantTin" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantTin"> </span>
                    </div>
                </div>
                <div class="col-md-2 offset-md-1">
                    <label for="" class="label-form">National ID number</label> <span>*</span> <br>
                    <small></small>
                </div>
                @if(!empty($app))
                <div class="col-md-8 mt-2">
                    <input type="number" value="{{isset($app->applicant->applicantDetail->nid_number) && $app->applicant->applicantDetail->nid_number != '' ? $app->applicant->applicantDetail->nid_number : ''}}" name="applicant_nid" id="applicant_nid" class="form-control in-form"   >

                </div>
                @else
                <div class="col-md-8 mt-2">
                    <input type="number" value="{{isset($app->applicant->applicantDetail->nid_number) && $app->applicant->applicantDetail->nid_number != '' ? $app->applicant->applicantDetail->nid_number : ''}}" name="applicant_nid" id="applicant_nid" class="form-control in-form" placeholder="" >
                    <div id="err_msg_applicantNid" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_applicantNid"> </span>
                    </div>
                </div>
                @endif


                @if(isset($app->applicant->applicantDetail->nid_photo) && $app->applicant->applicantDetail->nid_photo !='')

                <div class="col-md-2 offset-md-1">
                    <label for="" class="label-form">Change NID copy</label> <span>*</span> <br>
                    <small></small>
                </div>
                <div class="col-md-8">
                    <div>
                        <img src="{{url('')}}{{$app->applicant->applicantDetail->nid_photo}}" id="prev_image2exist_e" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                    </div>
                    <input type="file" id="image2exist_e" accept="image/png, image/jpg, image/jpeg" name="applicant_nid_photo" class="form-control in-form mandatory" >
                    <div id="err_msg_appNidCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_appNidCopy"> </span>
                    </div>
                </div>
                @else
                <div class="col-md-2 offset-md-1">
                    <label for="" class="label-form">NID copy</label> <span>*</span> <br>
                    <small></small>
                </div>
                <div class="col-md-8">
                    <div>
                        <img src="" id="prev_image2_e" alt="preview application" hidden>
                    </div>
                    <input type="file" id="image2_e" accept="image/png, image/jpg, image/jpeg" name="applicant_nid_photo" class="form-control in-form mandatory" >
                    <div id="err_msg_appNidCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_appNidCopy"> </span>
                    </div>
                </div>
                @endif

                <div class="col-md-2 offset-md-1">
                  <label for="" class="label-form">Number Of Sticker allocated to applicant/applicant's family 2018</label> <span>*</span> <br>
                  <small></small>
              </div>
              <div class="col-md-8">

                  <input type="number" id="app_sticker_num" value="{{!empty($app->applicant->applicantDetail->no_sticker_to_self_family)?$app->applicant->applicantDetail->no_sticker_to_self_family:'0'}}"  name="sticker_num_to_self_family" class="form-control in-form mandatory" required>
                  <div id="err_msg_app_sticker_num" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_app_sticker_num"> </span>
                  </div>
              </div>
              <div class="col-md-2 offset-md-1">
                  <label for="" class="label-form">Currently allocated Sticker Types </label> <span></span> <br>
                  <small></small>
              </div>
              <div class="col-md-8">

                  <input type="text" id="current_sticker_type"  name="current_sticker_type" class="form-control in-form mandatory" value="{{!empty($app->applicant->applicantDetail->allocated_current_sticker_type)?$app->applicant->applicantDetail->allocated_current_sticker_type:''}}">
                  <div id="err_msg_app_currentstickertype" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_app_currentstickertype"> </span>
                  </div>
              </div>
              <div class="col-md-2 offset-md-1">
                  <label for="" class="label-form">Currently allocated Sticker No </label> <span></span> <br>
                  <small></small>
              </div>
              <div class="col-md-8">

                  <input type="text" id="current_sticker_no"  name="current_sticker_no" class="form-control in-form mandatory" value="{{!empty($app->applicant->applicantDetail->allocated_current_sticker_no)?$app->applicant->applicantDetail->allocated_current_sticker_no:''}}">
                  <div id="err_msg_app_currentstickerno" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_app_currentstickerno"> </span>
                  </div>
              </div>
              <div class="col-md-2 offset-md-1">
                  <label for="" class="label-form">Applicant Remarks </label> <span></span> <br>
                  <small></small>
              </div>
              <div class="col-md-8">
                <textarea id="applicant_remarks" name="applicant_remarks" class="form-control in-form" value="">{{!empty($app->remark)?$app->remark:''}}</textarea>
            </div>

            <div class="col-md-2 offset-md-5">
                <button type="submit" class="btn btn-primary custm-btn" id="E-n-btn1">Update & Save</button>
            </div>
        </div>
    </form>
</div>

</div>

<div class="tab-pane" id="vehicle" role="tabpanel" aria-labelledby="vehicle-tab">
    <div class="container-fluid">
     <form id="vehicle_detail_form_Edit" data-id="{{$app->id}}" class="form Applycationform" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Vehicle type</label> <span>*</span> <br>
                <small></small>
            </div>
            @if(!empty($app->vehicleinfo->vehicleType->name))
            <div class="col-md-8">
                <select name="vehicle_type" id="vehicle_type" class="form-control-sm mandatory" >
                    <option  selected value="{{$app->vehicleinfo->vehicleType->id}}">{{$app->vehicleinfo->vehicleType->name}}</option>
                    <?php $vehicleTypes=App\VehicleType::all(); ?>
                    @if(isset($vehicleTypes))
                    @foreach($vehicleTypes as $vehicleType)
                    <option value="{{$vehicleType->id}}">{{$vehicleType->name}}</option>
                    @endforeach
                    @endif
                </select>

            </div>

            @endif
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Vehicle registration number</label> <span>*</span> <br>
                <small></small>
            </div>
            @if(!empty($app))
            <div class="col-md-8">
                <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" class="form-control in-form mandatory" value="{{$app->vehicleinfo->reg_number}}">
            </div>
            @else
            <div class="col-md-8">
                <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" class="form-control in-form mandatory" placeholder="Enter your vehicle registration number" >
                <div id="err_msg_vehiclereg" class="err_msg" hidden><i  class="fas fa-exclamation-triangle"></i>
                    <span id="err_vehiclereg"> </span>
                </div>
            </div>
            @endif


            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Registration certificate copy</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app))
                <div>
                    <img src="{{url('')}}{{$app->vehicleinfo->reg_cert_photo}}" id="prev_image2_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                </div>
                <input type="file" id="image2_b_exist" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" name="vehicle_reg_photo" >
                <div id="err_msg_vehicleregphoto" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_vehicleregphoto"> </span>
                </div>
                @else
                <div>
                    <img src="" id="prev_image2_b" alt="preview application" hidden>
                </div>
                <input type="file" id="image2_b" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" name="vehicle_reg_photo" >
                <div id="err_msg_vehicleregphoto" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_vehicleregphoto"> </span>
                </div>
                @endif
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Loan Taken</label> <span></span> <br>
                <small></small>
            </div>

            <div class="col-md-8 mt-2">
                @if(!empty($app->vehicleinfo->loan_taken))
                <input type="checkbox" checked name="loan_taken"  class="loan_taken" value="1" style="margin-top: 3px;width: 16px; height: 16px;" >
                @else
                <input type="checkbox"  name="loan_taken"  class="loan_taken" value="1" style="margin-top: 3px;width: 16px; height: 16px;" >
                @endif
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Owner name</label><span>*</span><br>
                <small></small>
            </div>
            @if(!empty($app))
            <div class="col-md-8">
                <input type="text" name="owner_name" id="owner_name" class="form-control in-form mandatory" value="{{$app->vehicleowner->owner_name}}" >
            </div>
            @else
            <div class="col-md-8">
                <input type="text" name="owner_name" id="owner_name" class="form-control in-form mandatory" >
                <div id="err_msg_ownername" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_ownername"> </span>
                </div>
            </div>
            @endif

            @if(!empty($app->vehicleowner->company_name))
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">If owner is a company</label> <span></span> <br>
                <small></small>
            </div>

            <div class="col-md-8 mt-2">
                <input type="checkbox"  name="owner_is_company" checked class="owner_is_company" value="1" style="margin-top: 3px;width: 16px; height: 16px;" >
            </div>

            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">Name Of Company</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="company_name" class="form-control in-form" value="{{$app->vehicleowner->company_name}}">
            </div>
            <?php $com_address = json_decode($app->vehicleowner->company_address, true);   ?>
            <div class="col-md-2 offset-md-1 company_info_field">
                <p style="margin-bottom: 0px; margin-top: 30px;"><b>Company's Address</b></p> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="c_flat" class="c_flat form-control in-form" value="{{$com_address['flat']}}">
            </div>

            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">House No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="c_house" class="c_house form-control in-form" value="{{$com_address['house']}}">
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="c_road" class="c_road form-control in-form" value="{{$com_address['road']}}" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="c_block" class="c_block form-control in-form" value="{{$com_address['block'] }}" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" >
                <label for="" class="label-form">Area</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" >
                <input type="text" name="c_area" class="c_area form-control in-form" value="{{$com_address['area'] }}" >
            </div>

            @else
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">If owner is a company</label> <span></span> <br>
                <small></small>
            </div>
            <div class="col-md-8 mt-2">
                <input type="checkbox"  name="owner_is_company" class="owner_is_company" value="1" style="margin-top: 3px;width: 16px; height: 16px;" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">Name Of Company</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="company_name" class="form-control in-form" value="">
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <p style="margin-bottom: 0px; margin-top: 30px;"><b>Company's Address</b></p> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="c_flat" class="c_flat form-control in-form" placeholder="" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">House No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="c_house" class="c_house form-control in-form" placeholder="" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="c_road" class="c_road form-control in-form" placeholder="" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="c_block" class="c_block form-control in-form" placeholder="" >
            </div>
            <div class="col-md-2 offset-md-1 company_info_field" hidden>
                <label for="" class="label-form">Area</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8 company_info_field" hidden>
                <input type="text" name="c_area" class="c_area form-control in-form" placeholder="" >
            </div>
            @endif
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Tax paid upto</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->tax_token_validity))
                <input type="date" data-date=""  data-date-format="DD MMMM YYYY" value="{{$app->vehicleinfo->tax_token_validity}}" name="tax_paid_upto" id="tax_paid_upto" class="form-control in-form mandatory" >
                <div id="err_msg_taxVal" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_taxVal"> </span>
                </div>
                @else
                <input type="date" data-date=""  data-date-format="DD MMMM YYYY" value="" name="tax_paid_upto" id="tax_paid_upto" class="form-control in-form mandatory" >
                <div id="err_msg_taxVal" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_taxVal"> </span>
                </div>
                @endif
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Tax paid token copy</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->tax_token_photo))
                <div>
                    <img src="{{url('')}}{{$app->vehicleinfo->tax_token_photo}}" id="prev_image4_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                </div>
                <input type="file" id="image4_b_exist" accept="image/png, image/jpg, image/jpeg" name="tax_token_photo" class="form-control in-form mandatory" >
                <div id="err_msg_taxCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_taxCopy"> </span>
                </div>
                @else
                <div>
                    <img src="" id="prev_image4_b" alt="preview application" hidden>
                </div>
                <input type="file" id="image4_b" accept="image/png, image/jpg, image/jpeg" name="tax_token_photo" class="form-control in-form mandatory" >
                <div id="err_msg_taxCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_taxCopy"> </span>
                </div>
                @endif
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Fitness validity</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->fitness_validity))
                <input type="date" value="{{$app->vehicleinfo->fitness_validity}}" name="fitnness_validity" id="fitnness_validity" class="form-control in-form mandatory" >
                <div id="err_msg_fitnessVal" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_fitnessVal"> </span>
                </div>
                @else
                <input type="date" value="" name="fitnness_validity" id="fitnness_validity" class="form-control in-form mandatory" >
                <div id="err_msg_fitnessVal" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_fitnessVal"> </span>
                </div>
                @endif
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Fitness certificate copy</label> <span>*</span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->fitness_cert_photo))
                <div>
                    <img src="{{url('')}}{{$app->vehicleinfo->fitness_cert_photo}}" id="prev_image5_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                </div>
                <input type="file" id="image5_b_exist" name="fitness_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" >
                <div id="err_msg_fitnessCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_fitnessCopy"> </span>
                </div>

                @else
                <div>
                    <img src="" id="prev_image5_b" alt="preview application" hidden>
                </div>
                <input type="file" id="image5_b" name="fitness_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" >
                <div id="err_msg_fitnessCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_fitnessCopy"> </span>
                </div>
                @endif
            </div>

            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Insurance validity</label> <br>
                <small></small>
            </div>
            <div class="col-md-8">
               
                <input type="date" value="" name="insurance_validity" id="insurance_validity" class="form-control in-form mandatory" >
                <div id="err_msg_insuranceValidity" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_insuranceValidity"> </span>
                </div>
                
            </div>
            <div class="col-md-2 offset-md-1">
                <label for="" class="label-form">Insurance certificate copy</label> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->insurance_cert_photo))
                <div>
                    <img src="{{url('')}}{{$app->vehicleinfo->insurance_cert_photo}}" id="prev_image6_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                </div>
                <input type="file" id="image6_b_exist" name="insurance_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form" >
                <div id="err_msg_insuranceCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_insuranceCopy"> </span>
                </div>
                @else
                <div>
                    <img src="" id="prev_image6_b" alt="preview application" hidden>
                </div>
                <input type="file" id="image6_b" name="insurance_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form" >
                <div id="err_msg_insuranceCopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_insuranceCopy"> </span>
                </div>
                @endif
            </div>
            <div class="col-md-2 offset-md-1" id="Necessity-div">
                <label for="" class="label-form">Necessity of Using Cantonment Area</label> <span></span> <br>
                <small></small>
            </div>
            <div class="col-md-8">
                @if(!empty($app->vehicleinfo->necessity_to_use))
                <textarea type="text" id="necessity_to_use"  name="necessity_to_use" class="form-control in-form" >{{$app->vehicleinfo->necessity_to_use}}</textarea>
                <div id="err_msg_necessity" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_necessity"> </span>
                </div>
                @else
                <textarea type="text" id="necessity_to_use" value="" name="necessity_to_use" class="form-control in-form" ></textarea>
                <div id="err_msg_necessity" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_necessity"> </span>
                </div>
                @endif
            </div>
                        <!-- <div class="col-md-1 offset-md-5">
                            <button type="button" class="btn btn-secondary  custm-btn" id="E-p-btn1">Previous</button>
                        </div> -->
                        <div class="col-md-2 offset-md-5">
                            <button type="submit" class="btn btn-primary next_btn custm-btn" id="E-n-btn2">Update & Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane " id="driver" role="tabpanel" aria-labelledby="driver-tab">
            <div class="container-fluid">
                <form id="driver_detail_form_Edit" data-id="{{$app->id}}" class="form Applycationform" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="row">
                    <div class="col-md-2 offset-md-1">
                        <label for="" class="label-form">Is Vehicle Self Driven?</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8">
                        @if(!empty($app->driverinfo->driver_is_owner) && $app->driverinfo->driver_is_owner == 1)
                        <input type="checkbox" id="self_driven_checkbox" value="1"  name="self_driven" checked class="self_driven"  style="margin-top: 3px;" >
                        @else
                        <input type="checkbox" id="self_driven_checkbox" value="1"  name="self_driven" class="self_driven"  style="margin-top: 3px;" >
                        @endif
                    </div>

                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Driver's name</label> <span>*</span> <br>
                        <small></small>
                    </div>

                    <div class="col-md-8 not_self_driven" hidden>
                        @if(!empty($app->driverinfo->name))
                        <input type="text"  name="name" id="driver_name" class="form-control in-form" value="{{$app->driverinfo->name}}">
                        <div id="err_msg_drivername" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_drivername"> </span>
                        </div>
                        @else
                        <input type="text"  name="name" id="driver_name" class="form-control in-form">
                        <div id="err_msg_drivername" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_drivername"> </span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Driver's photo</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        @if(!empty($app->driverinfo->photo))
                        <div>
                            <img src="{{url('')}}{{$app->driverinfo->photo}}"  id="prev_image10_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                        </div>
                        <input type="file" id="image10_b_exist" accept="image/png, image/jpg, image/jpeg"  name="photo" class="form-control in-form" disabled>
                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{!empty($app->driverinfo->photo)?url($app->driverinfo->photo):''}}">Change </button>
                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                        @else
                        <div>
                            <img src=""  id="prev_image10_b" alt="preview application" hidden>
                        </div>
                        <input type="file" id="image10_b" accept="image/png, image/jpg, image/jpeg"  name="photo" class="form-control in-form" placeholder="" >
                        <div id="err_msg_driverphoto" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverphoto"> </span>
                        </div>
                        @endif

                    </div>
                    <?php $driver_address=null; ?>
                    @if(!empty($app->driverinfo->address))
                    <?php $driver_address = json_decode($app->driverinfo->address, true);   ?>
                    @endif
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <p style="margin-bottom: 0px; margin-top: 30px;"><b>Present Address</b></p> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        <input type="text" name="dri_pre_flat" id="dri_pre_flat" class="driver_pre_flat form-control in-form"  value="{{!empty($driver_address['present']['flat'])?$driver_address['present']['flat']:''}}">
                        <div id="err_msg_driverflat" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverflat"> </span>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">House No.</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        <input type="text" name="dri_pre_house" id="dri_pre_house" class="driver_pre_house form-control in-form"  value="{{!empty($driver_address['present']['house'])?$driver_address['present']['house']:''}}">
                        <div id="err_msg_driverhouse" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverhouse"> </span>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        <input type="text" name="dri_pre_road" id="dri_pre_road" class="driver_pre_road form-control in-form" placeholder=""  value="{{!empty($driver_address['present']['road'])?$driver_address['present']['road']:''}}">
                        <div id="err_msg_driverroad" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverroad"> </span>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        <input type="text" name="dri_pre_block" id="dri_pre_block" class="driver_pre_block form-control in-form" placeholder=""  value="{{!empty($driver_address['present']['block'])?$driver_address['present']['block']:''}}">
                        <div id="err_msg_driverblock" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverblock"> </span>
                        </div>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Area</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        <input type="text" name="dri_pre_area" id="dri_pre_area" class="driver_pre_area form-control in-form" placeholder=""  value="{{!empty($driver_address['present']['area'])?$driver_address['present']['area']:''}}">
                        <div id="err_msg_driverarea" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverarea"> </span>
                        </div>
                    </div>


                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <p style="margin-bottom: 0px; margin-top: 30px;"><b>Permanent Address</b></p> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>


                        @if( (isset($driver_address['permanent']) !='') && (isset($driver_address['present']['house'] )== isset($driver_address['permanent']['p_flat'])) && (isset($driver_address['present']['flat'] )== isset($driver_address['permanent']['p_house'])) && (isset($driver_address['present']['road']) == isset($driver_address['permanent']['p_road'])) && (isset($driver_address['present']['block']) == isset($driver_address['permanent']['p_block'])) && (isset($driver_address['present']['area']) == isset($driver_address['permanent']['p_area'])))
                        <input type="checkbox"  name="driver_address_same_as_present" id="driver_address_same_as_present" class="driver_address_same_as_present" checked style="margin-top: 3px;width:16px;height:16px;" >
                        @else
                        <input type="checkbox"  name="driver_address_same_as_present" id="driver_address_same_as_present" class="driver_address_same_as_present"  style="margin-top: 3px;width:16px;height:16px;" >
                        @endif
                        <label for="driver_address_same_as_present" style="display: inline-block; margin-bottom: 0px; margin-top: 30px;cursor: pointer;"  title="Use present address">Same as present address</label>
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Flat No.</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                        <input type="text" name="dri_per_flat" id="dri_per_flat" class="driver_per_flat form-control in-form" placeholder="" value="{{!empty($driver_address['permanent']['p_flat'])? $driver_address['permanent']['p_flat'] :''}}" >
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">House No.</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                        <input type="text" name="dri_per_house" id="dri_per_house" class="driver_per_house form-control in-form" placeholder="" value="{{!empty($driver_address['permanent']['p_house'])? $driver_address['permanent']['p_house'] :''}}" >
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden >
                        <label for="" class="label-form">Road No.</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                        <input type="text" name="dri_per_road" id="dri_per_road" class="driver_per_road form-control in-form" placeholder="" value="{{!empty($driver_address['permanent']['p_road'])? $driver_address['permanent']['p_road'] :''}}">
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Block/Section</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                        <input type="text" name="dri_per_block" id="dri_per_block" class="driver_per_block form-control in-form" placeholder="" value="{{!empty($driver_address['permanent']['p_block'])? $driver_address['permanent']['p_block'] :''}}">
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">Area</label> <span></span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                        <input type="text" name="dri_per_area" id="dri_per_area" class="driver_per_area  form-control in-form" placeholder="" value="{{!empty($driver_address['permanent']['p_area'])? $driver_address['permanent']['p_area'] :''}}">
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">National ID number</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        @if(!empty($app->driverinfo->nid_number))
                        <input type="number" name="nid_number" id="drivernid_number" class="form-control in-form mandatory" placeholder="5654445454"  value="{{$app->driverinfo->nid_number}}">
                        <div id="err_msg_driverNid" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverNid"> </span>
                        </div>
                        @else
                        <input type="number" name="nid_number" id="drivernid_number" class="form-control in-form mandatory" placeholder="5654445454" >
                        <div id="err_msg_driverNid" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverNid"> </span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-2 offset-md-1 not_self_driven" hidden>
                        <label for="" class="label-form">NID copy</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8 not_self_driven" hidden>
                        @if(!empty($app->driverinfo->nid_photo))
                        <div>
                            <img src="{{url('')}}{{$app->driverinfo->nid_photo}}" id="prev_image11_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                        </div>
                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_exist"  name="nid_photo" class="form-control  in-form" disabled>
                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_exists"  name="nid_photo" class="form-control  in-form" disabled>
                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{!empty($app->driverinfo->nid_photo)?url($app->driverinfo->nid_photo):''}}">Change </button>

                        @else
                        <div>
                            <img src="" id="prev_image11_b" alt="preview application" hidden>
                        </div>
                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b"  name="nid_photo" class="form-control mandatory in-form" >
                        <div id="err_msg_driverNidcopy" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverNidcopy"> </span>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-2 offset-md-1">
                        <label for="" class="label-form">Driving license copy</label> <span>*</span> <br>
                        <small></small>
                    </div>
                    <div class="col-md-8" >
                        @if(!empty($app->driverinfo->licence_photo))
                        <div>
                            <img src="{{url('')}}{{$app->driverinfo->licence_photo}}" id="prev_image12_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                        </div>
                        <input type="file" id="image12_b_exist" accept="image/png, image/jpg, image/jpeg"  name="licence_photo" class="form-control in-form mandatory" disabled>
                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{!empty($app->driverinfo->licence_photo)?url($app->driverinfo->licence_photo):''}}">Change </button>
                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                        <div id="err_msg_driverlicence" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverlicence"> </span>
                        </div>
                        @else
                        <div>
                            <img src="" id="prev_image12_b" alt="preview application" hidden>
                        </div>
                        <input type="file" id="image12_b" accept="image/png, image/jpg, image/jpeg"  name="licence_photo" class="form-control in-form mandatory" >
                        <div id="err_msg_driverlicence" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id="err_driverlicence"> </span>
                        </div>
                        @endif
                    </div>
                    
                       <!--  <div class="col-md-1 offset-md-5">
                          <button type="button" class="btn btn-secondary custm-btn" id="E-p-btn2">Previous</button>
                      </div> -->
                      <div class="col-md-2 offset-md-5">
                        <button type="submit"  class="btn btn-primary  custm-btn" id="E-n-btn3" >Update & Save</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="tab-pane " id="document" role="tabpanel" aria-labelledby="documents-tab">
        <div class="container-fluid">
          <form id="document_form_Edit" data-id="{{$app->id}}" class="form Applycationform" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="row">
                <div class="col-md-2 offset-md-1 ">
                    <label for="" class="label-form">School Certificate: (If your Child Studying Proyash School/Collgeg.)</label> <span></span> <br>
                    <small></small>
                </div>
                <div class="col-md-8 ">
                    @if(!empty($app->document->school_cert))
                    <div>
                        <img src="{{url('')}}{{$app->document->school_cert}}" id="prev_image11_b_school_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                    </div>
                    <input type="file" id="image11_b_school_exist" accept="image/png, image/jpg, image/jpeg"  name="school_cert_photo" class="form-control in-form mandatory" >
                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>
                    @else
                    <div>
                        <img src="" id="prev_image11_b_school" alt="preview application" hidden>
                    </div>
                    <input type="file" id="image11_b_school" accept="image/png, image/jpg, image/jpeg"  name="school_cert_photo" class="form-control in-form mandatory" >
                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>

                    @endif
                </div>
                <div class="col-md-2 offset-md-1 ">
                    <label for="" class="label-form">Civil Service ID : (If you are serving inside cantt.)</label> <span></span> <br>
                    <small></small>
                </div>
                <div class="col-md-8 ">
                    @if(!empty($app->document->civil_service_id))
                    <div>
                        <img src="{{url('')}}{{$app->document->civil_service_id}}" id="prev_image11_b_civil_service_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                    </div>
                    <input type="file" id="image11_b_civil_service_exist" accept="image/png, image/jpg, image/jpeg"  name="civil_service_photo" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>
                    @else
                    <div>
                        <img src="" id="prev_image11_b_civil_service" alt="preview application" hidden>
                    </div>
                    <input type="file" id="image11_b_civil_service" accept="image/png, image/jpg, image/jpeg"  name="civil_service_photo" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>

                    @endif


                </div>                                        
                <div class="col-md-2 offset-md-1 ">
                    <label for="" class="label-form">Job Certificate: (If you are asking for Transit Pass.)</label> <span></span> <br>
                    <small></small>
                </div>
                <div class="col-md-8 ">
                    @if(!empty($app->document->job_cert))
                    <div>
                        <img src="{{url('')}}{{$app->document->job_cert}}" id="prev_image11_b_job_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                    </div>
                    <input type="file" id="image11_b_job_exist" accept="image/png, image/jpg, image/jpeg"  name="job_cert_photo" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>
                    @else
                    <div>
                        <img src="" id="prev_image11_b_job" alt="preview application" hidden>
                    </div>
                    <input type="file" id="image11_b_job" accept="image/png, image/jpg, image/jpeg"  name="job_cert_photo" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>

                    @endif

                </div>
                <div class="col-md-2 offset-md-1 ">
                    <label for="" class="label-form">House Owner/CEO Certificate: (If you are staying inside cantt.)</label> <span></span> <br>
                    <small></small>
                </div>
                <div class="col-md-8 ">
                    @if(!empty($app->document->house_owner_cert))
                    <div>
                        <img src="{{url('')}}{{$app->document->house_owner_cert}}" id="prev_image11_b_house_owner_ceo_cert_photo_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                    </div>
                    <input type="file" id="image11_b_house_owner_ceo_cert_photo_exist" accept="image/png, image/jpg, image/jpeg"  name="house_owner_cert" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>
                    @else
                    <div>
                        <img src="" id="prev_image11_b_house_owner_ceo_cert_photo" alt="preview application" hidden>
                    </div>
                    <input type="file" id="image11_b_house_owner_ceo_cert_photo" accept="image/png, image/jpg, image/jpeg"  name="house_owner_cert" class="form-control in-form mandatory" >

                    <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                    </div>

                    @endif

                </div>
                <div class="col-md-2 offset-md-1 ">
                    <label for="" class="label-form">Ward Commissioner Certificate: (If you are asking for transit pass.)</label> <span></span> <br>
                    <small></small>
                </div>
                <div class="col-md-8 ">
                 @if(!empty($app->document->ward_comm_cert))
                 <div>
                    <img src="{{url('')}}{{$app->document->ward_comm_cert}}" id="prev_image11_b_wardCom_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                </div>
                <input type="file" id="image11_b_wardCom_exist" accept="image/png, image/jpg, image/jpeg"  name="ward_com_cert" class="form-control in-form mandatory" >

                <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                </div>
                @else
                <div>
                    <img src="" id="prev_image11_b_wardCom" alt="preview application" hidden>
                </div>
                <input type="file" id="image11_b_wardCom" accept="image/png, image/jpg, image/jpeg"  name="ward_com_cert" class="form-control in-form mandatory" >

                <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                </div>

                @endif
            </div>
            <div class="col-md-2 offset-md-1 ">
                <label for="" class="label-form"> Authorised Certificate : </label> <span></span> <br>
                <small></small>
            </div>
            <div class="col-md-8 ">
              @if(!empty($app->document->auth_cert))
              <div>
                <img src="{{url('')}}{{$app->document->auth_cert}}" id="prev_image11_b_auth_cert_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
            </div>
            <input type="file" id="image11_b_auth_cert_exist" accept="image/png, image/jpg, image/jpeg"  name="auth_cert_photo" class="form-control in-form mandatory" >

            <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
            </div>
            @else
            <div>
                <img src="" id="prev_image11_b_auth_cert" alt="preview application" hidden>
            </div>
            <input type="file" id="image11_b_auth_cert" accept="image/png, image/jpg, image/jpeg"  name="auth_cert_photo" class="form-control in-form mandatory" >

            <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
            </div>

            @endif
        </div>
        <div class="col-md-2 offset-md-1 ">
            <label for="" class="label-form"> Marriage Certificate Copy: </label> <span></span> <br>
            <small></small>
        </div>
        <div class="col-md-8 ">
          @if(!empty($app->document->marriage_cert))
          <div>
            <img src="{{url('')}}{{$app->document->marriage_cert}}" id="prev_image11_b_marriage_cert_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
        </div>
        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_marriage_cert_exist"  name="marriage_cert_photo" class="form-control in-form" >
        <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
        </div>
        @else

        <div>
          <img src="" id="prev_image11_b_marriage_cert" alt="preview application" hidden>
      </div>
      <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_marriage_cert"  name="marriage_cert_photo" class="form-control in-form" >
      <div id="" class="err_msg" hidden> <i  class="fas fa-exclamation-triangle"></i> <span id=""> </span>
      </div>
      @endif
  </div>
     <!--  <div class="col-md-1 offset-md-5">
        <button type="button" class="btn btn-secondary custm-btn" id="E-p-btn3">Previous</button>
    </div> -->
    <div class="col-md-2 offset-md-5">
        <button type="submit" id="submit-btn" class="btn btn-primary submit-btn custm-btn">Update & Save</button>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- <div class="applicant-dtl-loading-progress"></div>
<div class="vehicle-dtl-loading-progress"></div>
<div class="driver-dtl-loading-progress"></div>
<div class="doc-loading-progress"></div>
-->
<div id="ajax-loader" hidden>
 <div>
     <img src="{{ url('assets/images/loading_spinner.gif') }}" />
     <div>Please wait for a while</div>
 </div>
</div>