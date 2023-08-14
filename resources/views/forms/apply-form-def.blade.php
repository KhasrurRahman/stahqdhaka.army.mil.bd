<style>
    .form-personal_info {

        /* display: flex;
        padding: 10px;
        margin: 10px; */
        background-color: #F5F5F5;
        padding: 30px 10px;
        margin: 10px;
        border-radius: 5px;
        border: 1px solid lightgray;
    }

    .form-personal_info .row {
        margin-top: 10px;
    }

    .details-container {
        width: 100%;
    }

    .vehicle-details-container {
        width: 100%;
        background-color: #F5F5F5;
        padding: 30px 10px;
        margin: 10px;
        border-radius: 5px;
        border: 1px solid lightgray;
    }

    .driver-details-container {
        width: 100%;
        background-color: #F5F5F5;
        padding: 30px 10px;
        margin: 10px;
        border-radius: 5px;
        border: 1px solid lightgray;
    }

    .doc-details-container {
        width: 100%;
        background-color: #F5F5F5;
        padding: 30px 10px;
        margin: 10px;
        border-radius: 5px;
        border: 1px solid lightgray;
    }
</style>
<div class="content-area" id="app-content-area" style="position: relative;">
    <div id="content-heading">
        <h4>Cantonment User's Vehicle Sticker
            @if (!empty($allocated_sticker))
            Renew
            @endif
            Application Form for Defence
        </h4>
    </div>

    <?php $vehicleInfo_exist = null;
    $driverInfo_exist = null; ?>
    @if (
    !empty(auth()->guard('applicant')->user()->applicantDetail->app_id
    ))
    <?php
    $vehicleInfo_exist = App\VehicleInfo::where(
        'application_id',
        auth()
            ->guard('applicant')
            ->user()->applicantDetail->app_id,
    )->first();
    $driverInfo_exist = App\DriverInfo::where(
        'application_id',
        auth()
            ->guard('applicant')
            ->user()->applicantDetail->app_id,
    )->first();
    $documentInfo_exist = App\Document::where(
        'application_id',
        auth()
            ->guard('applicant')
            ->user()->applicantDetail->app_id,
    )->first();
    ?>
    @endif
    <ul class="nav nav-tabs" id="E-myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="app-info-tab" data-toggle="tab" href="#app-info" role="tab" aria-controls="app-info" aria-selected="true">Applicant's Details</a>
        </li>
        <li class="nav-item">
            <a class="{{ !empty(auth()->guard('applicant')->user()->applicantDetail->app_id)? 'nav-link': 'nav-link not-active' }}" id="vehicle-tab" data-toggle="tab" href="#vehicle" role="tab" aria-controls="vehicle" aria-selected="false">Vehicle Details</a>
        </li>
        <li class="nav-item">
            <a class="{{ !empty($vehicleInfo_exist) ? 'nav-link' : 'nav-link not-active' }}" id="driver-tab" data-toggle="tab" href="#driver" role="tab" aria-controls="driver" aria-selected="false">Driver's
                Details</a>
        </li>
        <li class="nav-item">
            <a class="{{ !empty($driverInfo_exist) ? 'nav-link' : 'nav-link not-active' }}" id="documents-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Documents</a>
        </li>
    </ul>
    @if (
    !empty(auth()->guard('applicant')->user()->applicantDetail->app_id
    ))
    <?php
    $runningApp = App\Application::findOrFail(
        auth()
            ->guard('applicant')
            ->user()->applicantDetail->app_id,
    );
    ?>
    @endif
    <div id="" class="Applycationform">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show fade active" id="app-info" role="tabpanel" aria-labelledby="app-info-tab">
                <div class="container-fluid">
                    <form id="applicant_detail_form-DEF" class="form Applycationform" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="details-container">
                                <div class="form-personal_info">
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Applicant's full name</label>
                                            <br>
                                            <small>As per national ID card</small>
                                        </div>
                                        @if (!empty($allocated_sticker))
                                        <div class="col-md-8">
                                            <input type="text" id="applicant_name" value="{{ auth()->guard('applicant')->user()->name }}" name="applicant_name" class="form-control in-form mandatory" required>
                                        </div>
                                        @else
                                        <div class="col-md-8">
                                            <input type="text" id="applicant_name" value="{{ auth()->guard('applicant')->user()->name }}" name="applicant_name" class="form-control in-form mandatory" placeholder="" required>
                                            <div id="err_msg_applicantName" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantName">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    @if (
                                    !empty(auth()->guard('applicant')->user()->applicantDetail->applicant_photo
                                    ) || !empty($runningApp->applicant->applicantDetail->applicant_photo))
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Change Applicant's photo</label>
                                            <span>*</span> <br>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <img id="prev_image1exist_e" src="{{ !empty(auth()->guard('applicant')->user()->applicantDetail->applicant_photo)? url(auth()->guard('applicant')->user()->applicantDetail->applicant_photo): url($runningApp->applicant->applicantDetail->applicant_photo) }}" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                                <span class="file_error"></span>
                                            </div>
                                            <input type="file" id="image1exist_e" accept="image/png, image/jpg, image/jpeg" name="applicant_photo" class="form-control in-form mandatory" placeholder="" value="" disabled="">
                                            <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty(auth()->guard('applicant')->user()->applicantDetail->applicant_photo)? url(auth()->guard('applicant')->user()->applicantDetail->applicant_photo): url($runningApp->applicant->applicantDetail->applicant_photo) }}">Change
                                            </button>
                                            <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>

                                            <div id="err_msg_applicantPhoto" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhoto">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @else
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Applicant's photo</label> <span>*</span>
                                            <br>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <img src="" id="prev_image1_e" alt="preview application" hidden>
                                                <span class="file_error"></span>
                                            </div>
                                            <input type="file" id="image1_e" accept="image/png, image/jpg, image/jpeg" name="applicant_photo" class="form-control in-form mandatory" placeholder="" value="" required>
                                            <div id="err_msg_applicantPhoto" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhoto">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Mobile number</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ auth()->guard('applicant')->user()->phone }}" name="applicant_phone" id="applicant_phone" class="form-control in-form mandatory" placeholder="" required>
                                            <div id="err_msg_applicantPhone" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPhone">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">
                                                @if (isset(auth()->guard('applicant')->user()->applicantDetail->father_name) &&
                                                auth()->guard('applicant')->user()->applicantDetail->father_name != '')
                                                <input type="radio" checked name="guardian" value="1"> Father
                                                <input type="radio" name="guardian" value="0"> Husband's name
                                                @elseif(isset(auth()->guard('applicant')->user()->applicantDetail->husband_name) &&
                                                auth()->guard('applicant')->user()->applicantDetail->husband_name != '')
                                                <input type="radio" name="guardian" value="1"> Father
                                                <input type="radio" checked name="guardian" value="0"> Husband's name
                                                @else
                                                <input type="radio" checked name="guardian" value="1"> Father
                                                <input type="radio" name="guardian" value="0"> Husband's name
                                                @endif

                                            </label> <span>*</span> <br>
                                            <small>As per national ID card</small>
                                        </div>
                                        <div class="col-md-8">
                                            @if (isset(auth()->guard('applicant')->user()->applicantDetail->father_name) &&
                                            auth()->guard('applicant')->user()->applicantDetail->father_name != '')
                                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder="" required value="{{ auth()->guard('applicant')->user()->applicantDetail->father_name }}">
                                            @elseif(
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->husband_name
                                            ))
                                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder="" required value="{{ auth()->guard('applicant')->user()->applicantDetail->husband_name }}">
                                            @else
                                            <input type="text" name="f_h_name" id="f_h_name" class="form-control in-form mandatory" placeholder="" required>
                                            @endif
                                            <div id="err_msg_applicantFather" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantFather">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if (
                                    !empty(auth()->guard('applicant')->user()->applicantDetail->is_spouseOrChild
                                    ) &&
                                    auth()->guard('applicant')->user()->applicantDetail->is_spouseOrChild == true)
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <p class="label-form" style="margin-bottom: 0px; margin-top: 30px;">If Applicant
                                                is Spouse/Child</p>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="checkbox" checked name="applicant_spouse_Or_child" id="applicant_spouse_child" style="margin-top: 3px;width: 16px; height: 16px;" value="1">
                                            <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;">&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child ">
                                            <label for="" class="label-form">Spouse's/Parent's BA No.</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_BA_no
                                            ))
                                            <input type="text" value="{{ auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_BA_no }}" id="spouse_parent_BA_no" name="spouse_parent_BA_no" class="form-control in-form mandatory" placeholder="">
                                            <div id="err_msg_applicant_spouse_parent_BA_no" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_spouse_parent_BA_no"> </span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child">
                                            <label for="" class="label-form">Spouse's/Parent's Rank</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child mt-2">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_Rank_id
                                            ))
                                            <select name="spouse_parents_rank" id="spouse_parents_rank" class="form-control in-form mandatory">
                                                <option selected value="{{ auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_Rank_id }}">
                                                    {{ auth()->guard('applicant')->user()->applicantDetail->spouseOrParentRank->name }}
                                                </option>
                                                @if (isset($ranks) && count($ranks) > 0)
                                                @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                            <div id="err_msg_spouse_parents_rank" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_spouse_parents_rank"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child ">
                                            <label for="" class="label-form">Spouse's/Parent's Name</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child ">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_Name
                                            ))
                                            <input type="text" value="{{ auth()->guard('applicant')->user()->applicantDetail->spouseOrParent_Name }}" id="spouse_parent_name" name="spouse_parent_name" class="form-control in-form mandatory" placeholder="">
                                            <div id="err_msg_applicant_spouse_parent_name" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_spouse_parent_name"> </span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child ">
                                            <label for="" class="label-form">Spouse's/Parent's Unit</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child mt-2">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->spouse_parents_units_id
                                            ))

                                            <select name="spouse_parents_unit" id="spouse_parents_unit" class="form-control in-form mandatory">
                                                <option selected value="{{ auth()->guard('applicant')->user()->applicantDetail->spouse_parents_units_id }}">
                                                    {{ auth()->guard('applicant')->user()->applicantDetail->spouseParentUnit->name }}
                                                </option>
                                                @if (isset($units) && count($units) > 0)
                                                @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @endif
                                            <div id="err_msg_spouse_parents_unit" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_spouse_parents_unit"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child " hidden>
                                            <label for="" class="label-form">BA Number</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 not_applicant_spouse_child" hidden>
                                            <input type="text" class="form-control in-form" value="" placeholder="" name="BA_no" id="BA_no">
                                            <div id="err_msg_applicant_BA_no" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_BA_no">
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child" hidden>
                                            <label for="" class="label-form">Rank</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 mt-2 not_applicant_spouse_child" hidden>

                                            <select name="applicant_rank" id="applicant_rank" class="form-control in-form mandatory">
                                                <option selected value="" disabled>--Select Unit--</option>
                                                @if (isset($ranks) && count($ranks) > 0)
                                                @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>

                                            <div id="err_msg_applicant_rank" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_rank">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child" hidden>
                                            <p class="label-form" style="margin-bottom: 0px; margin-top: 30px;">Is Retired</p>
                                        </div>
                                        <div class="col-md-8 not_applicant_spouse_child" hidden>

                                            <input type="checkbox" name="is_retired" id="is_retired" style="margin-top: 3px;width: 16px; height: 16px;" value="1">
                                            <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;">&nbsp;</span>
                                        </div>
                                    </div>

                                    @else
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <p class="label-form" style="margin-bottom: 0px; margin-top: 30px;">If Applicant
                                                is Spouse/Child</p>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="checkbox" name="applicant_spouse_Or_child" id="applicant_spouse_child" style="margin-top: 3px;width: 16px; height: 16px;" value="1">
                                            <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;">&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child " hidden>
                                            <label for="" class="label-form">Spouse's/Parent's BA No.</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child" hidden>
                                            <input type="text" value="" id="spouse_parent_BA_no" name="spouse_parent_BA_no" class="form-control in-form mandatory" placeholder="">
                                            <div id="err_msg_applicant_spouse_parent_BA_no" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_spouse_parent_BA_no"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child " hidden>
                                            <label for="" class="label-form">Spouse's/Parent's Rank</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child mt-2" hidden>
                                            <select name="spouse_parents_rank" id="spouse_parents_rank" class="form-control in-form mandatory">
                                                <option selected value="" disabled>--Select Rank--</option>
                                                @if (isset($ranks) && count($ranks) > 0)
                                                @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <div id="err_msg_spouse_parents_rank" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_spouse_parents_rank"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child " hidden>
                                            <label for="" class="label-form">Spouse's/Parent's Name</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child " hidden>

                                            <input type="text" value="" id="spouse_parent_name" name="spouse_parent_name" class="form-control in-form mandatory" placeholder="">
                                            <div id="err_msg_applicant_spouse_parent_name" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_spouse_parent_name"> </span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 applicant_spouse_child " hidden>
                                            <label for="" class="label-form">Spouse's/Parent's Unit</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 applicant_spouse_child mt-2" hidden>
                                            <select name="spouse_parents_unit" id="spouse_parents_unit" class="form-control in-form mandatory">
                                                <option selected value="" disabled>--Select Unit--</option>
                                                @if (isset($units) && count($units) > 0)
                                                @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <div id="err_msg_spouse_parents_unit" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_spouse_parents_unit"> </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child">
                                            <label for="" class="label-form">BA Number</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 not_applicant_spouse_child">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->applicant_BA_no
                                            ))
                                            <input type="text" class="form-control in-form" value="{{ auth()->guard('applicant')->user()->applicantDetail->applicant_BA_no }}" placeholder="" name="BA_no" id="BA_no">
                                            @else
                                            <input type="text" class="form-control in-form" value="" placeholder="" name="BA_no" id="BA_no">
                                            @endif
                                            <div id="err_msg_applicant_BA_no" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_BA_no">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child">
                                            <label for="" class="label-form">Rank</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 mt-2 not_applicant_spouse_child">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->rank_id
                                            ))
                                            <select name="applicant_rank" id="applicant_rank" class="form-control in-form mandatory">

                                                @if (isset($ranks) && count($ranks) > 0)
                                                @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}" @if (auth()->guard('applicant')->user()->applicantDetail->rank_id == $rank->id) selected @endif>
                                                    {{ $rank->name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @else
                                            <select name="applicant_rank" id="applicant_rank" class="form-control in-form mandatory">
                                                <option selected value="">--Select Rank--</option>
                                                @if (isset($ranks) && count($ranks) > 0)
                                                @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>

                                            @endif
                                            <div id="err_msg_applicant_rank" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicant_rank">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 not_applicant_spouse_child">
                                            <p class="label-form" style="margin-bottom: 0px; margin-top: 30px;">Is Retired</p>
                                        </div>
                                        <div class="col-md-8 not_applicant_spouse_child">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->is_applicant_retired
                                            ))
                                            <input type="checkbox" checked name="is_retired" id="is_retired" style="margin-top: 3px;width: 16px; height: 16px;" value="1">
                                            <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;">&nbsp;</span>
                                            @else
                                            <input type="checkbox" name="is_retired" id="is_retired" style="margin-top: 3px;width: 16px; height: 16px;" value="1">
                                            <span style="display: inline-block; margin-bottom: 0px; margin-top: 30px;">&nbsp;</span>
                                            @endif
                                        </div>
                                    </div>


                                    @endif


                                    <div class="row">
                                        <div class="col-md-3 offset-md-1 ">
                                            <label for="" class="label-form">Applicant's profession</label> <span></span>
                                            <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8 ">
                                            <input type="text" value="{{ isset(auth()->guard('applicant')->user()->applicantDetail->profession) &&auth()->guard('applicant')->user()->applicantDetail->profession != ''? auth()->guard('applicant')->user()->applicantDetail->profession: '' }}" name="profession" class="form-control in-form mandatory" placeholder="">
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Applicant's company name</label>
                                            <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ isset(auth()->guard('applicant')->user()->applicantDetail->company_name) &&auth()->guard('applicant')->user()->applicantDetail->company_name != ''? auth()->guard('applicant')->user()->applicantDetail->company_name: '' }}" name="ap_company_name" class="form-control in-form mandatory" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Applicant's designation</label> <span></span>
                                            <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ isset(auth()->guard('applicant')->user()->applicantDetail->designation) &&auth()->guard('applicant')->user()->applicantDetail->designation != ''? auth()->guard('applicant')->user()->applicantDetail->designation: '' }}" name="designation" class="form-control in-form mandatory" placeholder="">
                                        </div>
                                    </div>

                                </div>
                                <?php $app_address = null; ?>

                                @if (isset(auth()->guard('applicant')->user()->applicantDetail->address))
                                <?php $app_address = json_decode(
                                    auth()
                                        ->guard('applicant')
                                        ->user()->applicantDetail->address,
                                    true,
                                ); ?>
                                @endif
                                <div class="form-personal_info">
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <p style="margin-bottom: 0px; margin-top: 30px;"><b>Office Address</b></p>
                                        </div>
                                        <div class="col-md-8">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Flat No.</label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_o_flat" id="applicant_o_flat" class="form-control in-form mandatory" value="{{ isset($app_address['office']['o_flat']) ? $app_address['office']['o_flat'] : '' }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">House No.</label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_o_house" id="applicant_o_house" class="form-control in-form mandatory" value="{{ isset($app_address['office']['o_house']) ? $app_address['office']['o_house'] : '' }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Road No.</label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_o_road" id="applicant_o_road" class=" form-control in-form mandatory" value="{{ isset($app_address['office']['o_road']) ? $app_address['office']['o_road'] : '' }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Block/Section</label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_o_block" id="applicant_o_block" class=" form-control in-form mandatory" placeholder="" value="{{ isset($app_address['office']['o_block']) ? $app_address['office']['o_block'] : '' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Area</label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_o_area" id="applicant_o_area" class=" form-control in-form mandatory" placeholder="" value="{{ isset($app_address['office']['o_area']) ? $app_address['office']['o_area'] : '' }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-personal_info">

                                    <div class="col-md-3 offset-md-1">
                                        <p style="margin-bottom: 0px; margin-top: 30px;"><b>Present Address</b></p>
                                    </div>
                                    <div class="col-md-8">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_flat" id="app_pre_flat" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['present']['flat']) ? $app_address['present']['flat'] : '' }}" required>
                                            <div id="err_msg_applicantFlat" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantFlat"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_house" id="app_pre_house" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['present']['house']) ? $app_address['present']['house'] : '' }}" required>
                                            <div id="err_msg_applicantHouse" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantHouse">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_road" id="app_pre_road" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['present']['road']) ? $app_address['present']['road'] : '' }}" required>
                                            <div id="err_msg_applicantRoad" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantRoad"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_block" id="app_pre_block" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['present']['block']) ? $app_address['present']['block'] : '' }}" required>
                                            <div id="err_msg_applicantBlock" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantBlock">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Area</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="app_pre_area" name="applicant_area" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['present']['road']) ? $app_address['present']['area'] : '' }}" required>
                                            <div id="err_msg_applicantArea" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantArea"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <p style="margin-bottom: 0px; margin-top: 30px;"><b>Permanent Address</b></p>
                                        </div>
                                        <div class="col-md-8">
                                            @if (isset($app_address['permanent']) != '' &&
                                            isset($app_address['present']['flat']) == isset($app_address['permanent']['p_flat']) &&
                                            isset($app_address['present']['house']) == isset($app_address['permanent']['p_house']) &&
                                            isset($app_address['present']['road']) == isset($app_address['permanent']['p_road']) &&
                                            isset($app_address['present']['block']) == isset($app_address['permanent']['p_block']) &&
                                            isset($app_address['present']['area']) == isset($app_address['permanent']['p_area']))
                                            <input type="checkbox" checked name="app_address_same_as_present" id="app_address_same_as_present" style="margin-top: 3px;">
                                            @else
                                            <input type="checkbox" name="app_address_same_as_present" id="app_address_same_as_present" style="margin-top: 3px;">
                                            @endif

                                            <label for="app_address_same_as_present" style="display: inline-block; margin-bottom: 0px; margin-top: 30px;" title="Use present address as permanent address">Same as present address</label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_p_flat" id="app_per_flat" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['permanent']['p_flat']) ? $app_address['permanent']['p_flat'] : '' }}" required>
                                            <div id="err_msg_applicantPFlat" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPFlat">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_p_house" id="app_per_house" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['permanent']['p_house']) ? $app_address['permanent']['p_house'] : '' }}" required>
                                            <div id="err_msg_applicantPHouse" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPHouse">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_p_road" id="app_per_road" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['permanent']['p_road']) ? $app_address['permanent']['p_road'] : '' }}" required>
                                            <div id="err_msg_applicantPRoad" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPRoad">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="applicant_p_block" id="app_per_block" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['permanent']['p_block']) ? $app_address['permanent']['p_block'] : '' }}" required>
                                            <div id="err_msg_applicantPBlock" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPBlock">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Area</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="app_per_area" name="applicant_p_area" class="form-control in-form mandatory" placeholder="" value="{{ isset($app_address['permanent']['p_area']) ? $app_address['permanent']['p_area'] : '' }}" required>
                                            <div id="err_msg_applicantPArea" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantPArea">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">--Residence Type--</label> <span>*</span>
                                            <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <select name="residence_type" id="residence_type" class="form-control in-form">
                                                <option selected value="{{ !empty(auth()->guard('applicant')->user()->applicantDetail->residence_type)? auth()->guard('applicant')->user()->applicantDetail->residence_type: '' }}">
                                                    {{ !empty(auth()->guard('applicant')->user()->applicantDetail->residence_type)? auth()->guard('applicant')->user()->applicantDetail->residence_type: '--Select One--' }}
                                                </option>
                                                <option value="Own">Own</option>
                                                <option value="Rental">Rental</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div id="err_msg_restype" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_restype"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Email</label> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ auth()->guard('applicant')->user()->email? auth()->guard('applicant')->user()->email: '' }}" name="applicant_email" class="form-control in-form" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Tin</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ !empty(auth()->guard('applicant')->user()->applicantDetail->tin)? auth()->guard('applicant')->user()->applicantDetail->tin: '' }}" name="applicant_tin" id="applicant_tin" class="form-control in-form required mandatory" placeholder="" required>
                                            <div id="err_msg_applicantTin" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantTin"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">National ID number</label> <span>*</span>
                                            <br>
                                            <small></small>
                                        </div>
                                        @if (!empty($allocated_sticker))
                                        <div class="col-md-8 mt-2">
                                            <input type="number" value="{{ isset(auth()->guard('applicant')->user()->applicantDetail->nid_number) &&auth()->guard('applicant')->user()->applicantDetail->nid_number != ''? auth()->guard('applicant')->user()->applicantDetail->nid_number: '' }}" name="applicant_nid" id="applicant_nid" class="form-control in-form" required>
                                        </div>
                                        @else
                                        <div class="col-md-8 mt-2">
                                            <input type="number" value="{{ isset(auth()->guard('applicant')->user()->applicantDetail->nid_number) &&auth()->guard('applicant')->user()->applicantDetail->nid_number != ''? auth()->guard('applicant')->user()->applicantDetail->nid_number: '' }}" name="applicant_nid" id="applicant_nid" class="form-control in-form" placeholder="" required>

                                            <div id="err_msg_applicantNid" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_applicantNid">
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>




                                    <?php

                                    if (
                                        $file_name_nid = auth()
                                        ->guard('applicant')
                                        ->user()->applicantDetail
                                    ) {
                                        $file_name_nid = auth()
                                            ->guard('applicant')
                                            ->user()->applicantDetail->nid_photo;
                                        $slash = substr($file_name_nid, 1);
                                    } else {
                                        $slash = '';
                                    }

                                    ?>

                                    @if (is_file($slash) || !empty($runningApp->applicant->applicantDetail->nid_photo))
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Change NID copy</label> <span>*</span>
                                            <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <img src="{{ !empty($runningApp->applicant->applicantDetail->nid_photo)? url($runningApp->applicant->applicantDetail->nid_photo): url(auth()->guard('applicant')->user()->applicantDetail->nid_photo) }}" id="prev_image2exist_e" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                            </div>
                                            <input type="file" id="image2exist_e" accept="image/png, image/jpg, image/jpeg" name="applicant_nid_photo" class="form-control in-form mandatory" disabled="">
                                            <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($runningApp->applicant->applicantDetail->nid_photo)? url($runningApp->applicant->applicantDetail->nid_photo): url(auth()->guard('applicant')->user()->applicantDetail->nid_photo) }}">Change</button>
                                            <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>

                                            <div id="err_msg_appNidCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_appNidCopy">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @else
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">NID copy</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <img src="" id="prev_image2_e" alt="preview application" hidden>
                                            </div>
                                            <input type="file" id="image2_e" accept="image/png, image/jpg, image/jpeg" name="applicant_nid_photo" class="form-control in-form mandatory" required>
                                            <div id="err_msg_appNidCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_appNidCopy">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Def Id card/Rtd ID/Cro Book Copy</label>
                                            <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            @if (
                                            !empty(auth()->guard('applicant')->user()->applicantDetail->defIdCopy
                                            ) || !empty($runningApp->applicant->applicantDetail->defIdCopy))
                                            <div>
                                                <img src="{{ !empty($runningApp->applicant->applicantDetail->defIdCopy)? url($runningApp->applicant->applicantDetail->defIdCopy): url(auth()->guard('applicant')->user()->applicantDetail->defIdCopy) }}" id="prev_image2_e_def_id_Exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                            </div>
                                            <input type="file" id="image2_e_def_id_Exist" accept="image/png, image/jpg, image/jpeg" name="applicant_Def_id_photo" class="form-control in-form mandatory" disabled="">
                                            <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($runningApp->applicant->applicantDetail->defIdCopy)? url($runningApp->applicant->applicantDetail->defIdCopy): url(auth()->guard('applicant')->user()->applicantDetail->defIdCopy) }}">Change</button>
                                            <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                            <div id="err_msg_def_id" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_def_id"> </span>
                                            </div>
                                            @else
                                            <div>
                                                <img src="" id="prev_image2_e_def_id" alt="preview application" hidden>
                                            </div>
                                            <input type="file" id="image2_e_def_id" accept="image/png, image/jpg, image/jpeg" name="applicant_Def_id_photo" class="form-control in-form mandatory" required>
                                            <div id="err_msg_def_id" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_def_id"> </span>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Number Of Sticker allocated to
                                                applicant/applicant's family 2018</label> <span>*</span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" id="app_sticker_num" value='0' name="sticker_num_to_self_family" class="form-control in-form mandatory" required>
                                            <div id="err_msg_app_sticker_num" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_app_sticker_num">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Currently allocated Sticker Types </label>
                                            <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="current_sticker_type" name="current_sticker_type" class="form-control in-form mandatory">
                                            <div id="err_msg_app_currentstickertype" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_app_currentstickertype"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Currently allocated Sticker No </label>
                                            <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" id="current_sticker_no" name="current_sticker_no" class="form-control in-form mandatory">
                                            <div id="err_msg_app_currentstickerno" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_app_currentstickerno">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 offset-md-1">
                                            <label for="" class="label-form">Applicant Remarks </label> <span></span> <br>
                                            <small></small>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea id="applicant_remarks" name="applicant_remarks" class="form-control in-form"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-2 offset-md-5">
                                    <button type="submit" class="btn btn-primary custm-btn" id="def-E-n-btn1">Save &
                                        Continue</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="vehicle" role="tabpanel" aria-labelledby="vehicle-tab">
                <div class="container-fluid">
                    <form id="vehicle_detail_form" class="form Applycationform" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="old_application_id" value="@isset($old_application_id) {{ $old_application_id }} @endisset">
                        <div class="row">
                            <div class="vehicle-details-container">
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Vehicle type</label> <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    @if (!empty($allocated_sticker))
                                    <div class="col-md-8">
                                        <select name="vehicle_type" id="vehicle_type" class="form-control-sm mandatory" required>
                                            <option selected value="{{ $allocated_sticker->application->vehicleType->id }}">
                                                {{ $allocated_sticker->application->vehicleType->name }}
                                            </option>
                                        </select>

                                    </div>
                                    @else
                                    <div class="col-md-8">

                                        <select name="vehicle_type" id="vehicle_type" class="form-control-sm mandatory" required>
                                            @if (!empty($runningApp->vehicleType->id))
                                            <option value="{{ $runningApp->vehicleType->id }}" selected>
                                                {{ $runningApp->vehicleType->name }}
                                            </option>
                                            @else
                                            <option selected="" disabled> Select A Vehicle</option>
                                            @endif
                                            @if (isset($vehicleTypes))
                                            @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>

                                        <div id="err_msg_vehicletype" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i>
                                            <span id="err_vehicletype"> </span>
                                        </div>
                                    </div>

                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Vehicle registration number</label>
                                        <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    @if (!empty($allocated_sticker))
                                    <div class="col-md-8">
                                        <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" class="form-control in-form" value="{{ $allocated_sticker->reg_number }}" required>
                                    </div>
                                    @else
                                    <div class="col-md-8">
                                        <input type="text" name="vehicle_reg_no" id="vehicle_reg_no" class="form-control in-form mandatory" placeholder="5654445454" required value="{{ !empty($runningApp->vehicleinfo->reg_number) ? $runningApp->vehicleinfo->reg_number : '' }}">
                                        <div id="err_msg_vehiclereg" class="err_msg" hidden><i class="fas fa-exclamation-triangle"></i>
                                            <span id="err_vehiclereg"> </span>
                                        </div>
                                    </div>

                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Registration certificate copy</label>
                                        <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        @if (!empty($allocated_sticker))

                                        <div>
                                            <img src="{{ url('') }}{{ $allocated_sticker->application->vehicleinfo->reg_cert_photo }}" id="prev_image2_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image2_b_exist" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" name="vehicle_reg_photo" required disabled="">
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ url('') }}{{ $allocated_sticker->application->vehicleinfo->reg_cert_photo }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        @else
                                        @if (!empty($runningApp->vehicleinfo->reg_cert_photo))
                                        <div>
                                            <img src="{{ url('') }}{{ $runningApp->vehicleinfo->reg_cert_photo }}" id="prev_image2_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image2_b_exist" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" name="vehicle_reg_photo" required disabled="">
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ url('') }}{{ $runningApp->vehicleinfo->reg_cert_photo }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        @else
                                        <div>
                                            <img src="" id="prev_image2_b" alt="preview application" hidden style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image2_b" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" name="vehicle_reg_photo" required>
                                        <div id="err_msg_vehicleregphoto" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_vehicleregphoto"> </span>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Loan Taken</label> <span></span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8 mt-2">
                                        @if (!empty($runningApp->vehicleinfo->loan_taken) || !empty($allocated_sticker->application->vehicleinfo->loan_taken))
                                        <input type="checkbox" checked name="loan_taken" class="loan_taken" value="1" style="margin-top: 3px;">
                                        @else
                                        <input type="checkbox" name="loan_taken" class="loan_taken" value="1" style="margin-top: 3px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Owner name</label><span>*</span><br>
                                        <small></small>
                                    </div>
                                    @if (!empty($allocated_sticker))
                                    <div class="col-md-8">
                                        <input type="text" name="owner_name" id="owner_name" class="form-control in-form mandatory" value="{{ $allocated_sticker->application->vehicleowner->owner_name }}" required>
                                    </div>
                                    @else
                                    <div class="col-md-8">

                                        <input type="text" name="owner_name" id="owner_name" class="form-control in-form mandatory" value="{{ !empty($runningApp->vehicleowner->owner_name) ? $runningApp->vehicleowner->owner_name : '' }}" required>
                                        <div id="err_msg_ownername" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_ownername"> </span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if (
                                !empty($allocated_sticker->application->vehicleowner->company_name) ||
                                !empty($runningApp->vehicleowner->company_name))
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">If owner is a company</label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8 mt-2">
                                        <input type="checkbox" name="owner_is_company" checked class="owner_is_company" value="1" style="margin-top: 3px;">
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">Name Of Company</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="company_name" id="company_name" class="form-control in-form" value="{{ !empty($allocated_sticker->application->vehicleowner->company_name) ? $allocated_sticker->application->vehicleowner->company_name : $runningApp->vehicleowner->company_name }}">
                                    </div>
                                </div>
                                <?php $com_address = json_decode(!empty($allocated_sticker->application->vehicleowner->company_address) ? $allocated_sticker->application->vehicleowner->company_address : $runningApp->vehicleowner->company_address, true); ?>
                                <div class="col-md-3 offset-md-1 company_info_field">
                                    <p style="margin-bottom: 0px; margin-top: 30px;"><b>Company's Address:</b></p> <br>
                                    <small></small>
                                </div>
                                <div class="col-md-8 company_info_field">
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="c_flat" id="c_flat" class="c_flat form-control in-form" value="{{ $com_address['flat'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="c_house" id="c_house" class="c_house form-control in-form" value="{{ $com_address['house'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="c_road" id="c_road" class="c_road form-control in-form" value="{{ $com_address['road'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">Block/Section</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="c_block" id="c_block" class="c_block form-control in-form" value="{{ $com_address['block'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field">
                                        <label for="" class="label-form">Area</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field">
                                        <input type="text" name="c_area" id="c_area" class="c_area form-control in-form" value="{{ $com_address['area'] }}">
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">If owner is a company</label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 mt-2">

                                        <input type="checkbox" name="owner_is_company" class="owner_is_company" value="1" style="margin-top: 3px;">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">Name Of Company</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="company_name" id="company_name" class="form-control in-form" value="">
                                        <div id="err_msg_companyname" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyname">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>

                                        <p style="margin-bottom: 0px; margin-top: 30px;"><b>Company's Address:</b></p>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="c_flat" id="c_flat" class="c_flat form-control in-form" placeholder="">
                                        <div id="err_msg_companyflat" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyflat">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="c_house" id="c_house" class="c_house form-control in-form" placeholder="">

                                        <div id="err_msg_companyhouse" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyhouse">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="c_road" id="c_road" class="c_road form-control in-form" placeholder="">

                                        <div id="err_msg_companyroad" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyroad">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">Block/Section</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="c_block" id="c_block" class="c_block form-control in-form" placeholder="">

                                        <div id="err_msg_companyblock" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyblock">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 company_info_field" hidden>
                                        <label for="" class="label-form">Area</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 company_info_field" hidden>
                                        <input type="text" name="c_area" id="c_area" class="c_area form-control in-form" placeholder="">

                                        <div id="err_msg_companyarea" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_companyarea">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Tax paid upto</label> <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->tax_token_validity) ||
                                        !empty($runningApp->vehicleinfo->tax_token_validity))
                                        <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="{{ !empty($allocated_sticker->application->vehicleinfo->tax_token_validity) ? $allocated_sticker->application->vehicleinfo->tax_token_validity : $runningApp->vehicleinfo->tax_token_validity }}" name="tax_paid_upto" id="tax_paid_upto" class="form-control in-form mandatory" required>
                                        <div id="err_msg_taxVal" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_taxVal"> </span>
                                        </div>
                                        @else
                                        <input type="date" data-date="" data-date-format="DD MMMM YYYY" value="" name="tax_paid_upto" id="tax_paid_upto" class="form-control in-form mandatory" required>
                                        <div id="err_msg_taxVal" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_taxVal"> </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Tax token copy</label> <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->tax_token_photo) ||
                                        !empty($runningApp->vehicleinfo->tax_token_photo))
                                        <div>

                                            <img src="{{ !empty($allocated_sticker->application->vehicleinfo->tax_token_photo) ? url($allocated_sticker->application->vehicleinfo->tax_token_photo) : url($runningApp->vehicleinfo->tax_token_photo) }}" id="prev_image4_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>


                                        <input type="file" id="image4_b_exist" accept="image/png, image/jpg, image/jpeg" name="tax_token_photo" class="form-control in-form mandatory" disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->vehicleinfo->tax_token_photo) ? url($allocated_sticker->application->vehicleinfo->tax_token_photo) : url($runningApp->vehicleinfo->tax_token_photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_taxCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_taxCopy"> </span>
                                        </div>
                                        @else
                                        <div>
                                            <img src="" id="prev_image4_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" id="image4_b" accept="image/png, image/jpg, image/jpeg" name="tax_token_photo" class="form-control in-form mandatory" required>
                                        <div id="err_msg_taxCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_taxCopy"> </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Fitness validity</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->fitness_validity) ||
                                        !empty($runningApp->vehicleinfo->fitness_validity))
                                        <input type="date" value="{{ !empty($allocated_sticker->application->vehicleinfo->fitness_validity) ? $allocated_sticker->application->vehicleinfo->fitness_validity : $runningApp->vehicleinfo->fitness_validity }}" name="fitnness_validity" id="fitnness_validity" class="form-control in-form mandatory" required>

                                        <div id="err_msg_fitnessVal" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_fitnessVal">
                                            </span>
                                        </div>
                                        @else
                                        <input type="date" value="" name="fitnness_validity" id="fitnness_validity" class="form-control in-form mandatory" required>
                                        <div id="err_msg_fitnessVal" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_fitnessVal">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Fitness certificate copy</label>
                                        <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->fitness_cert_photo) ||
                                        !empty($runningApp->vehicleinfo->fitness_cert_photo))
                                        <div>
                                            <img src="{{ !empty($allocated_sticker->application->vehicleinfo->fitness_cert_photo) ? url($allocated_sticker->application->vehicleinfo->fitness_cert_photo) : url($runningApp->vehicleinfo->fitness_cert_photo) }}" id="prev_image5_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image5_b_exist" name="fitness_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->vehicleinfo->fitness_cert_photo) ? url($allocated_sticker->application->vehicleinfo->fitness_cert_photo) : url($runningApp->vehicleinfo->fitness_cert_photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_fitnessCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_fitnessCopy">
                                            </span>
                                        </div>
                                        @else
                                        <div>
                                            <img src="" id="prev_image5_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" id="image5_b" name="fitness_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form mandatory" required>
                                        <div id="err_msg_fitnessCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_fitnessCopy">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Insurance validity</label> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">

                                        <input type="date" value="" name="insurance_validity" id="insurance_validity" class="form-control in-form">
                                        <div id="err_msg_insuranceValidity" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_insuranceValidity">
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Insurance certificate copy</label> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->insurance_cert_photo) ||
                                        !empty($runningApp->vehicleinfo->insurance_cert_photo))
                                        <div>
                                            <img src="{{ !empty($allocated_sticker->application->vehicleinfo->insurance_cert_photo) ? url($allocated_sticker->application->vehicleinfo->insurance_cert_photo) : url($runningApp->vehicleinfo->insurance_cert_photo) }}" id="prev_image6_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image6_b_exist" name="insurance_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form" disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->vehicleinfo->insurance_cert_photo) ? url($allocated_sticker->application->vehicleinfo->insurance_cert_photo) : url($runningApp->vehicleinfo->insurance_cert_photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_insuranceCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_insuranceCopy">
                                            </span>
                                        </div>
                                        @else
                                        <div>
                                            <img src="" id="prev_image6_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" id="image6_b" name="insurance_cert_photo" accept="image/png, image/jpg, image/jpeg" class="form-control in-form">
                                        <div id="err_msg_insuranceCopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_insuranceCopy">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1" id="Necessity-div">
                                        <label for="" class="label-form">Necessity of using Cantonment gate</label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->vehicleinfo->necessity_to_use) ||
                                        !empty($runningApp->vehicleinfo->necessity_to_use))
                                        <textarea type="text" id="necessity_to_use" name="necessity_to_use" class="form-control in-form">{{ !empty($allocated_sticker->application->vehicleinfo->necessity_to_use) ? $allocated_sticker->application->vehicleinfo->necessity_to_use : $runningApp->vehicleinfo->necessity_to_use }}</textarea>

                                        <div id="err_msg_necessity" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_necessity">
                                            </span>
                                        </div>
                                        @else
                                        <textarea type="text" id="necessity_to_use" value="" name="necessity_to_use" class="form-control in-form"></textarea>
                                        <div id="err_msg_necessity" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_necessity">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if (
                                (!empty($allocated_sticker->application->vehicleinfo->glass_type) &&
                                $allocated_sticker->application->vehicleinfo->glass_type != 'transparent') ||
                                (!empty($runningApp->vehicleinfo->glass_type) && $runningApp->vehicleinfo->glass_type != 'transparent'))
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Type of Glass(if not
                                            transparent)</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="checkbox" checked id="is_transparent" value="0" name="is_not_transparent" class="is_transparent" style="margin-top: 3px;width: 16px; height: 16px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 is_transparent_hide">
                                        <label for="" class="label-form">Glass Type</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 is_transparent_hide">
                                        <select name="glass_type" id="glass_type" class="form-control in-form mandatory">

                                            <option selected value="{{ !empty($allocated_sticker->application->vehicleinfo->glass_type) ? $allocated_sticker->application->vehicleinfo->glass_type : $runningApp->vehicleinfo->glass_type }}">
                                                {{ !empty($allocated_sticker->application->vehicleinfo->glass_type) ? $allocated_sticker->application->vehicleinfo->glass_type : $runningApp->vehicleinfo->glass_type }}
                                            </option>

                                            <option value="Normal-Transparent">Transparent Normal Glass </option>
                                            <option value="Semi-Black"> Semi-Black </option>
                                            <option value="Black">Black</option>
                                        </select>
                                        <div id="err_msg_glasstype" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i>
                                            <span id="err_glasstype"> </span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Type of Glass(if not
                                            transparent)</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="checkbox" id="is_transparent" value="0" name="is_not_transparent" class="is_transparent" style="margin-top: 3px;width: 16px; height: 16px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 is_transparent_hide" hidden>
                                        <label for="" class="label-form">Glass Type</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 is_transparent_hide" hidden>
                                        <select name="glass_type" id="glass_type" class="form-control in-form mandatory">
                                            <option selected disabled>Select Glass Type </option>
                                            <option value="Normal-Transparent">Transparent Normal Glass </option>
                                            <option value="Semi-Black"> Semi-Black </option>
                                            <option value="Black">Black</option>
                                        </select>
                                        <div id="err_msg_glasstype" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i>
                                            <span id="err_glasstype"> </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">In/Out Gate</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        @if (!empty($allocated_sticker->application->vehicleinfo->in_out_gate) || !empty($runningApp->vehicleinfo->in_out_gate))
                                        <textarea name="in_out_gate" id="in_out_gate" class="form-control in-form">{{ !empty($allocated_sticker->application->vehicleinfo->in_out_gate) ? $allocated_sticker->application->vehicleinfo->in_out_gate : $runningApp->vehicleinfo->in_out_gate }}</textarea>
                                        @else
                                        <textarea name="in_out_gate" id="in_out_gate" class="form-control in-form"></textarea>
                                        @endif
                                        <div id="err_msg_inOut_Gate" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_inOut_Gate"> </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">In/Out Time</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        @if (!empty($allocated_sticker->application->vehicleinfo->in_out_time) || !empty($runningApp->vehicleinfo->in_out_time))
                                        <input type="time" name="in_out_time" id="in_out_time" class="form-control in-form" value="{{ !empty($allocated_sticker->application->vehicleinfo->in_out_time) ? $allocated_sticker->application->vehicleinfo->in_out_time : $runningApp->vehicleinfo->in_out_time }}">
                                        @else
                                        <input type="time" name="in_out_time" id="in_out_time" class="form-control in-form">
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-1 offset-md-5">
                                <button type="button" class="btn btn-secondary  custm-btn" id="E-p-btn1">Previous</button>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary next_btn custm-btn" id="E-n-btn2">Save & Continue</button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane " id="driver" role="tabpanel" aria-labelledby="driver-tab">
                <div class="container-fluid">
                    <form id="driver_detail_form" class="form Applycationform" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="old_application_id" value="@isset($old_application_id) {{ $old_application_id }} @endisset">

                        <div class="row">
                            <div class="driver-details-container">
                                <div class="row">

                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Is Vehicle Self Driven?</label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        @if (
                                        (!empty($allocated_sticker->application->driverinfo->driver_is_owner) &&
                                        $allocated_sticker->application->driverinfo->driver_is_owner == 1) ||
                                        (!empty($runningApp->driverinfo->driver_is_owner) && $runningApp->driverinfo->driver_is_owner == 1))
                                        <input type="checkbox" id="self_driven_checkbox" value="1" name="self_driven" checked class="self_driven" style="margin-top: 3px;width: 16px; height: 16px;">
                                        @else
                                        <input type="checkbox" id="self_driven_checkbox" value="1" name="self_driven" class="self_driven" style="margin-top: 3px;width: 16px; height: 16px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Driver's name</label> <span>*</span> <br>
                                        <small></small>
                                    </div>

                                    <div class="col-md-8 not_self_driven" hidden>
                                        @if (!empty($allocated_sticker->application->driverinfo->name) || !empty($runningApp->driverinfo->name))
                                        <input type="text" name="name" id="driver_name" class="form-control in-form" required="false" value="{{ !empty($allocated_sticker->application->driverinfo->name) ? $allocated_sticker->application->driverinfo->name : $runningApp->driverinfo->name }}">
                                        <div id="err_msg_drivername" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_drivername">
                                            </span>
                                        </div>
                                        @else
                                        <input type="text" name="name" id="driver_name" class="form-control in-form" required="false">

                                        <div id="err_msg_drivername" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_drivername">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Driver's photo</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        @if (!empty($allocated_sticker->application->driverinfo->photo) || !empty($runningApp->driverinfo->photo))
                                        <div>
                                            <img src="{{ !empty($allocated_sticker->application->driverinfo->photo) ? url($allocated_sticker->application->driverinfo->photo) : url($runningApp->driverinfo->photo) }}" id="prev_image10_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image10_b_exist" accept="image/png, image/jpg, image/jpeg" name="photo" class="form-control in-form" placeholder="" disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->driverinfo->photo) ? url($allocated_sticker->application->driverinfo->photo) : url($runningApp->driverinfo->photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_driverphoto" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverphoto">
                                            </span>
                                        </div>
                                        @else
                                        <div>

                                            <img src="" id="prev_image10_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" id="image10_b" accept="image/png, image/jpg, image/jpeg" name="photo" class="form-control in-form" placeholder="" required>
                                        <div id="err_msg_driverphoto" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverphoto">
                                            </span>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <?php $driver_address = null; ?>
                                @if (!empty($allocated_sticker->application->driverinfo->address) || !empty($runningApp->driverinfo->address))
                                <?php $driver_address = json_decode(!empty($allocated_sticker->application->driverinfo->address) ? $allocated_sticker->application->driverinfo->address : $runningApp->driverinfo->address, true); ?>
                                @endif
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <p style="margin-bottom: 0px; margin-top: 30px;">Present address</p> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Flat No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        <input type="text" name="dri_pre_flat" id="dri_pre_flat" class="driver_pre_flat form-control in-form" required value="{{ !empty($driver_address['present']['flat']) ? $driver_address['present']['flat'] : '' }}">
                                        <div id="err_msg_driverflat" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverflat"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">House No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        <input type="text" name="dri_pre_house" id="dri_pre_house" class="driver_pre_house form-control in-form" required value="{{ !empty($driver_address['present']['house']) ? $driver_address['present']['house'] : '' }}">
                                        <div id="err_msg_driverhouse" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverhouse"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Road No.</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        <input type="text" name="dri_pre_road" id="dri_pre_road" class="driver_pre_road form-control in-form" placeholder="" required value="{{ !empty($driver_address['present']['road']) ? $driver_address['present']['road'] : '' }}">
                                        <div id="err_msg_driverroad" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverroad"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Block/Section</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        <input type="text" name="dri_pre_block" id="dri_pre_block" class="driver_pre_block form-control in-form" placeholder="" required value="{{ !empty($driver_address['present']['block']) ? $driver_address['present']['block'] : '' }}">
                                        <div id="err_msg_driverblock" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverblock"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Area</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        <input type="text" name="dri_pre_area" id="dri_pre_area" class="driver_pre_area form-control in-form" placeholder="" required value="{{ !empty($driver_address['present']['area']) ? $driver_address['present']['area'] : '' }}">
                                        <div id="err_msg_driverarea" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverarea"> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <p style="margin-bottom: 0px; margin-top: 30px;">Permanent address</p> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>


                                        @if (isset($driver_address['permanent']) != '' &&
                                        isset($driver_address['present']['flat']) == isset($driver_address['permanent']['p_flat']) &&
                                        isset($driver_address['present']['house']) == isset($driver_address['permanent']['p_house']) &&
                                        isset($driver_address['present']['road']) == isset($driver_address['permanent']['p_road']) &&
                                        isset($driver_address['present']['block']) == isset($driver_address['permanent']['p_block']) &&
                                        isset($driver_address['present']['area']) == isset($driver_address['permanent']['p_area']))
                                        <input type="checkbox" name="driver_address_same_as_present" id="driver_address_same_as_present" class="driver_address_same_as_present" checked style="margin-top: 3px;width: 16px; height: 16px;">
                                        @else
                                        <input type="checkbox" name="driver_address_same_as_present" id="driver_address_same_as_present" class="driver_address_same_as_present" style="margin-top: 3px;width: 16px; height: 16px;">
                                        @endif
                                        <label for="driver_address_same_as_present" style="display: inline-block; margin-bottom: 0px; margin-top: 30px;" title="Use present address">Same as present address</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Flat No.</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                                        <input type="text" name="dri_per_flat" id="" class="driver_per_flat form-control in-form" placeholder="" value="{{ !empty($driver_address['permanent']['p_flat']) ? $driver_address['permanent']['p_flat'] : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">House No.</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                                        <input type="text" name="dri_per_house" id="" class="driver_per_house form-control in-form" placeholder="" value="{{ !empty($driver_address['permanent']['p_house']) ? $driver_address['permanent']['p_house'] : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Road No.</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                                        <input type="text" name="dri_per_road" id="" class="driver_per_road form-control in-form" placeholder="" value="{{ !empty($driver_address['permanent']['p_road']) ? $driver_address['permanent']['p_road'] : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Block/Section</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                                        <input type="text" name="dri_per_block" id="" class="driver_per_block form-control in-form" placeholder="" value="{{ !empty($driver_address['permanent']['p_block']) ? $driver_address['permanent']['p_block'] : '' }}">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">Area</label> <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven driver_perm" hidden>
                                        <input type="text" name="dri_per_area" id="" class="driver_per_area  form-control in-form" placeholder="" value="{{ !empty($driver_address['permanent']['p_area']) ? $driver_address['permanent']['p_area'] : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">National ID number</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        @if (!empty($allocated_sticker->application->driverinfo->nid_number) || !empty($runningApp->driverinfo->nid_number))
                                        <input type="number" name="nid_number" id="drivernid_number" class="form-control in-form mandatory" placeholder="5654445454" required value="{{ !empty($allocated_sticker->application->driverinfo->nid_number) ? $allocated_sticker->application->driverinfo->nid_number : $runningApp->driverinfo->nid_number }}">
                                        <div id="err_msg_driverNid" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverNid">
                                            </span>
                                        </div>
                                        @else
                                        <input type="number" name="nid_number" id="drivernid_number" class="form-control in-form mandatory" placeholder="5654445454" required>

                                        <div id="err_msg_driverNid" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverNid">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 not_self_driven" hidden>
                                        <label for="" class="label-form">NID copy</label> <span>*</span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 not_self_driven" hidden>
                                        @if (!empty($allocated_sticker->application->driverinfo->nid_photo) || !empty($runningApp->driverinfo->nid_photo))
                                        <div>
                                            <img src="{{ !empty($allocated_sticker->application->driverinfo->nid_photo) ? url($allocated_sticker->application->driverinfo->nid_photo) : url($runningApp->driverinfo->nid_photo) }}" id="prev_image11_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_exist" name="nid_photo" class="form-control mandatory in-form" required disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->driverinfo->nid_photo) ? url($allocated_sticker->application->driverinfo->nid_photo) : url($runningApp->driverinfo->nid_photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_driverNidcopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverNidcopy">
                                            </span>
                                        </div>
                                        @else
                                        <div>
                                            <img src="" id="prev_image11_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b" name="nid_photo" class="form-control mandatory in-form" required>
                                        <div id="err_msg_driverNidcopy" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverNidcopy">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1">
                                        <label for="" class="label-form">Driving license copy</label> <span>*</span>
                                        <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8">
                                        @if (
                                        !empty($allocated_sticker->application->driverinfo->licence_photo) ||
                                        !empty($runningApp->driverinfo->licence_photo))
                                        <div>
                                            <img src="{{ !empty($allocated_sticker->application->driverinfo->licence_photo) ? url($allocated_sticker->application->driverinfo->licence_photo) : url($runningApp->driverinfo->licence_photo) }}" id="prev_image12_b_exist" alt="preview application" style="display: inline-block; height: auto; padding: 10px 0px; max-width: 70%; width: auto; max-height: 200px;">
                                        </div>
                                        <input type="file" id="image12_b_exist" accept="image/png, image/jpg, image/jpeg" name="licence_photo" class="form-control in-form mandatory" required disabled>
                                        <button type="button" name="" class="btn btn-info change-btn" data-photo="{{ !empty($allocated_sticker->application->driverinfo->licence_photo) ? url($allocated_sticker->application->driverinfo->licence_photo) : url($runningApp->driverinfo->licence_photo) }}">Change</button>
                                        <button type='button' class='btn btn-warning cancel-btn' hidden="">Cancel</button>
                                        <div id="err_msg_driverlicence" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverlicence">
                                            </span>
                                        </div>
                                        @else
                                        <div>
                                            <img src="" id="prev_image12_b" alt="preview application" hidden>
                                        </div>
                                        <input type="file" id="image12_b" accept="image/png, image/jpg, image/jpeg" name="licence_photo" class="form-control in-form mandatory" required>
                                        <div id="err_msg_driverlicence" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id="err_driverlicence">
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 offset-md-5">
                                <button type="button" class="btn btn-secondary custm-btn" id="E-p-btn2">Previous</button>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary  custm-btn" id="E-n-btn3">Save &
                                    Continue</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="tab-pane " id="document" role="tabpanel" aria-labelledby="documents-tab">
                <div class="container-fluid">
                    <form id="document_form" class="form Applycationform" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="old_application_id" value="@isset($old_application_id) {{ $old_application_id }} @endisset">

                        <div class="row">
                            <div class="doc-details-container">
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 ">
                                        <label for="" class="label-form">Father's Testimonial: </label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 ">

                                        <div>
                                            <img src="" id="prev_image11_b_father_test" alt="preview application" hidden>
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_father_test" name="father_testm_photo" class="form-control mandatory in-form">

                                        <div id="" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 ">
                                        <label for="" class="label-form">Mother's Testimonial: </label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 ">

                                        <div>
                                            <img src="" id="prev_image11_b_mother_test" alt="preview application" hidden>
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_mother_test" name="mother_testm_photo" class="form-control mandatory in-form">

                                        <div id="" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 ">
                                        <label for="" class="label-form"> Authorized Certificate : </label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 ">

                                        <div>
                                            <img src="" id="prev_image11_b_auth_cert" alt="preview application" hidden>
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_auth_cert" name="auth_cert_photo" class="form-control in-form">

                                        <div id="" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 offset-md-1 ">
                                        <label for="" class="label-form"> Marriage Certificate Copy: </label>
                                        <span></span> <br>
                                        <small></small>
                                    </div>
                                    <div class="col-md-8 ">

                                        <div>
                                            <img src="" id="prev_image11_b_marriage_cert" alt="preview application" hidden>
                                        </div>
                                        <input type="file" accept="image/png, image/jpg, image/jpeg" id="image11_b_marriage_cert" name="marriage_cert_photo" class="form-control in-form">

                                        <div id="" class="err_msg" hidden> <i class="fas fa-exclamation-triangle"></i> <span id=""> </span>
                                        </div>
                                        @if (!empty($allocated_sticker))
                                        <input type="hidden" name="renew_app" class="form-control in-form" value="yes">
                                        <input type="hidden" name="app_id" class="form-control in-form" value="{{ $allocated_sticker->application->id }}">
                                        @endif

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-1 offset-md-5">
                                <button type="button" class="btn btn-secondary custm-btn" id="E-p-btn3">Previous</button>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" id="submit-btn" class="btn btn-success submit-btn custm-btn">Save & Finish</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div id="ajax-loader" hidden>
 <div>
   <img src="{{ url('assets/images/loading_spinner.gif') }}" />
   <div>Please wait for a while</div>
 </div>
</div> -->