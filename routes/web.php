<?php

Route::get('/rhythm','HomeController@rhythm');
// front-pages
Route::get('/','FrontController@index')->name('index');
Route::get('/about-station-headquarters','FrontController@about')->name('about');
Route::get('/single_major/{id}/{name}','FrontController@major')->name('major');
Route::get('/policy','FrontController@policy')->name('policy');
Route::get('/graveyard','FrontController@graveyard')->name('graveyard');
Route::get('/bus','FrontController@bus')->name('bus');
Route::get('/private','FrontController@private')->name('private');
Route::get('/anti-malaria-drive','FrontController@anti_malaria_drive')->name('anti_malaria_drive');
Route::get('/drainage-and-cleaning','FrontController@drainage_and_cleaning')->name('drainage_and_cleaning');
Route::get('/disposal-of-garbage','FrontController@disposal_of_garbage')->name('disposal_of_garbage');
Route::get('/mp-checkpost','FrontController@mp_checkpost')->name('mp_checkpost');
Route::get('/shuttle-service','FrontController@shuttle_service')->name('shuttle_service');
Route::get('/other-services','FrontController@other_services')->name('other_services');
Route::get('/contact-info','FrontController@contact_info')->name('contact_info');
Route::get('/helpline','FrontController@helpline')->name('helpline');
Route::get('/notice-details/{slug}','FrontController@noticeDetails')->name('notice_details');

Route::get('/sticker-notice', function () { 
	return view('front-pages.sticker-notice');
});
Route::get('/tender-foot-over-bridge', function () { 
	return view('front-pages.tender-foot-over-bridge');
});
Route::get('/tender-lighting-gate-signal', function () { 
	return view('front-pages.tender-lighting-gate-signal');
});
Route::get('/tender-notice', function () { 
	return view('front-pages.tender-notice');
});



Route::get('/major-md-amjad-hossain-sso-2', function () {
	return view('officers.major-md-amjad-hossain-sso-2'); 
});
Route::get('/major-maj-md-shahed-meher-sso-3', function () {
	return view('officers.major-maj-md-shahed-meher-sso-3'); 
});
Route::get('/major-maj-abu-russell-sso-4', function () {
	return view('officers.major-maj-abu-russell-sso-4'); 
});
Route::get('/major-md-nazmul-haque-sto', function () {
	return view('officers.major-md-nazmul-haque-sto'); 
});

// front-pages ended
Route::group(['middleware' => 'prevent_back_history'],function(){
	Route::get('/application/edit/applicant/{appNumber}', 'ApplicationController@applicationEditApplicant')->middleware('applicant');
	Route::get('/application/view/applicant/{appNumber}', 'ApplicationController@viewApplication')->middleware('applicant');
	Route::get('/renew/sticker/{stickerID}','VehicleStickerController@renewRequest')->middleware('applicant');
	Route::post('/applicant-details/store','ApplicantDetailController@storeApplicantDetails')->middleware('applicant');
	Route::post('/vehicle-detail/store','VehicleInfoController@storeVehicleDetails')->middleware('applicant');
	Route::post('/driver-details/store','DriverInfoController@storeDriverDetails')->middleware('applicant');
	Route::post('/document/store','DriverInfoController@storeDocuments')->middleware('applicant');
	Route::post('/send-submission-sms/success/{id}','ApplicationController@submissionSmsSend')->middleware('applicant');
	Route::post('/send-submission-renew-sms/success/{id}','ApplicationController@submissionSmsSendRenew')->middleware('applicant');
	Route::get('/applied-applications', 'ApplicantController@showAppliedForms')->middleware('applicant');
	Route::get('/alocated-stickers', function () {
		return view('layouts.alocated-sticker');
	})->middleware('applicant');
	Route::get('/about/customer', function () {
		return view('layouts.about-customer');
	})->middleware('applicant');
	Route::get('/customer/home', 'ApplicantController@applyForm')->middleware('applicant');
	Route::post('/applicant-detail/update/{app_id}','ApplicantDetailController@updateApplicantDetail')->middleware('anyauth');
	Route::post('/vehicle-detail/update/{app_id}','VehicleInfoController@vehicleInfoUpdate')->middleware('anyauth');
	Route::post('/driver-detail/update/{app_id}','DriverInfoController@driverInfoUpdate')->middleware('anyauth');
	Route::post('/document/update/{app_id}','DriverInfoController@updateDocument')->middleware('anyauth');
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/application/pending/{def}', 'HomeController@pendingApp')->name('pendingApp');
	Route::get('/application/hold/{def}', 'HomeController@holdingApp')->name('holdingApp');
	Route::get('/application/retake/{def}', 'HomeController@retakeApp')->name('retakeApp');
	// all pending datatable
	Route::get('all-pending/datatable', 'HomeController@allPendingDatatable')->name('all_pending.datatable');

    // all holding datatable
    Route::get('all-holding/datatable', 'HomeController@allHoldingDatatable')->name('all_holding.datatable');
    // all pending datatable
    Route::get('all-retake/datatable', 'HomeController@allRetakeDatatable')->name('all_retake.datatable');


    // all approved datatable
	Route::get('all-approved/datatable', 'HomeController@allApprovedDatatable')->name('all_approved.datatable');
	// all delevered datatable
	Route::get('all-delevered/datatable', 'HomeController@allDeleveredDatatable')->name('all_delevered.datatable');
	// all rejected datatable
	Route::get('all-rejected/datatable', 'HomeController@allRejectedDatatable')->name('all_rejected.datatable');
	// all expired datatable
	Route::get('all-expired/datatable', 'HomeController@allExpiredDatatable')->name('all_expired.datatable');
	// approved datatable
	Route::get('approved_apps/datatable', 'HomeController@approvedAppsDatatable')->name('approved_apps.datatable');
	// issued datatable
	Route::get('issued_apps/datatable', 'HomeController@issuedAppsDatatable')->name('issued_apps.datatable');
	//Route::get('approved_apps/datatable', 'HomeController@approvedAppsDatatable')->name('approved_apps.datatable');
	// All Apps datatable
	Route::get('all_apps/datatable', 'HomeController@allAppsDatatable')->name('all_apps.datatable');
	// Forwared datatable
	Route::get('forwarded_apps/datatable', 'HomeController@forwardedAppsDatatable')->name('forwarded_apps.datatable');
	// Invoice datatable
	Route::get('invoice/datatable', 'InvoiceController@invoiceDatatable')->name('invoice.datatable');

	Route::get('/application/approved/{def}', 'HomeController@approvedApp')->name('approvedApp');
	Route::get('/application/delivered/{def}', 'HomeController@deliveredApp')->name('deliveredApp');
	Route::get('/application/rejected/{def}', 'HomeController@rejectedApp')->name('rejectedApp');
	Route::get('/sticker/expired/{def}', 'HomeController@expiredSticker')->name('expiredSticker');

	Route::get('/application-review/{app_number}', 'HomeController@applicationReview')->name('application.review');
	Route::get('/application/approve', 'HomeController@applicationApprove');
	Route::get('/application/reject', 'HomeController@applicationReject');
	Route::get('/application/edit/{appNumber}', 'HomeController@applicationEdit');
	Route::get('/application/delete', 'HomeController@applicationDelete');
	Route::get('/application/forward', 'HomeController@applicationForward');
	Route::get('/application/forwarded-list', 'HomeController@applicationForwardedList');
	Route::post('/admin-search', 'UserController@adminSearch');
	Route::post('/sticker/issue', 'HomeController@issueSticker');
	Route::get('/def/sticker/expired', 'HomeController@expiredSticker');
	Route::post('/all-applications', 'HomeController@allStickerApplications');

	Route::get('/invoice/{id}','InvoiceController@printInvoice');
	Route::get('/invoice-list','InvoiceController@allInvoice');
	Route::get('/invoice-report','InvoiceController@invoiceReport');
	Route::post('/search/invoice','InvoiceController@searchInvoice');
	Route::post('/search/invoice/report','InvoiceController@searchInvoiceReport');

	Route::get('/application-review-from-notfication/{app_number}/{not_id}',
		'HomeController@applicationRevewFromNotification');
	Route::post('/send/sms','HomeController@notify');
	Route::get('/bank-deposit','HomeController@bankDeposit');
	Route::get('/application/undo','HomeController@undoApplication');
	Route::post('/application/hold','HomeController@HoldApplication');
	Route::post('/add/bank/deposit','HomeController@storeBankDeposit');
	Route::get('/delivery-report','HomeController@deliveryReport');
	Route::get('/all-approved/application','HomeController@allApproveApps');
	Route::post('/search/sticker/report','HomeController@searchStickerReport');
	Route::post('/search/inspection','HomeController@searchInspecList');
	Route::get('/admin-list','HomeController@adminsList')->middleware('super-admin');
	Route::post('/add/admin','HomeController@addAdmin')->middleware('super-admin');
	Route::post('update/admin/{id}','HomeController@updateAdmin')->middleware('super-admin');
	Route::post('/delete/admin','HomeController@deleteAdmin')->middleware('super-admin');
	Route::get('/sticker-list','HomeController@stickerTypes')->middleware('super-admin');
	Route::post('/add/sticker','HomeController@addSticker')->middleware('super-admin');
	Route::post('/update/sticker/{id}','HomeController@updateSticker')->middleware('super-admin');
	Route::post('/delete/sticker','HomeController@deleteSticker')->middleware('super-admin');
	Route::get('/sms-panel','SmsController@smsPanel');
	Route::post('/add/sms','SmsController@smsAdd');
	Route::post('/update/sms/{id}','SmsController@smsUpdate');
	Route::post('/delete/sms','SmsController@smsDelete');
	Route::get('/send-sms/retry/{id}','SmsController@retrySendSms')->middleware('auth');
	Route::post('/change/password','UserController@changePassword')->middleware('auth');
	Route::get('/customer-list','UserController@clientsList')->middleware('auth');
	Route::post('/update/client/{clientId}','UserController@updateClient')->middleware('auth');
	Route::post('/search/forwarded-list','HomeController@searchForwardedList')->middleware('auth');
	Route::post('/search/issued','HomeController@searchIssuedList')->middleware('auth');
	Route::get('/all-issued/application','HomeController@allIssuedList')->middleware('auth');
	Route::post('/fetch_clients_records', 'HomeController@DataTableClientFetch')->middleware('auth');
	Route::post('/fetch_apps_records', 'UserController@DataTableAppsFetch')->middleware('auth');
	Route::post('/fetch_issued_apps_records', 'HomeController@DataTableIssuedAppsFetch')->middleware('auth')->name('fetch_issued_apps_records');
	Route::get('/home/allapps', 'HomeController@allapps')->middleware('auth');
	Route::get('/issued/allapps', 'HomeController@allIssuedList')->middleware('auth');
	Route::get('/send-queued-sms/{queue_status}', 'SmsController@sendQueueSms')->middleware('auth');
	
	// Website Related Routs
	Route::get('header_footer', 'HeaderFooterController@headerFooter')->name('header_footer')->middleware('super-admin');
	Route::post('header_footer', 'HeaderFooterController@headerFooterStore')->name('header_footer_store')->middleware('super-admin');


    // Website Notice
    Route::get('notices', 'NoticeController@index')->name('website_notice')->middleware('super-admin');
    Route::get('notices/add', 'NoticeController@add')->name('website_notice.add')->middleware('super-admin');
    Route::post('notices/add', 'NoticeController@addPost')->middleware('super-admin');

    Route::get('notices/edit/{notice}', 'NoticeController@edit')->name('website_notice.edit')->middleware('super-admin');
    Route::post('notices/edit/{notice}', 'NoticeController@editPost')->middleware('super-admin');
    Route::get('notices/delete/{id}', 'NoticeController@delete')->name('website_notice.delete')->middleware('super-admin');


    // Slider Routes
	Route::get('slider/list', 'SliderController@list')->name('slider.list')->middleware('super-admin');
	Route::get('slider/add', 'SliderController@add')->name('slider.add')->middleware('super-admin');
	Route::post('slider/add', 'SliderController@store')->name('slider.store')->middleware('super-admin');
	Route::get('slider/edit/{id}', 'SliderController@edit')->name('slider.edit')->middleware('super-admin');
	Route::post('slider/update/{id}', 'SliderController@update')->name('slider.update')->middleware('super-admin');
	Route::get('slider/delete/{id}', 'SliderController@delete')->name('slider.delete')->middleware('super-admin');
	// Present Commander Routes
	Route::get('present_commander/add', 'PresentCommanderController@add')->name('present_commander.add')->middleware('super-admin');
	Route::post('present_commander/add', 'PresentCommanderController@store')->name('present_commander.store')->middleware('super-admin');
	// Major Routes
	Route::get('major/list', 'MajorController@list')->name('major.list')->middleware('super-admin');
	Route::get('major/add', 'MajorController@add')->name('major.add')->middleware('super-admin');
	Route::post('major/add', 'MajorController@store')->name('major.store')->middleware('super-admin');
	Route::get('major/edit/{id}', 'MajorController@edit')->name('major.edit')->middleware('super-admin');
	Route::post('major/update/{id}', 'MajorController@update')->name('major.update')->middleware('super-admin');
	Route::get('major/delete/{id}', 'MajorController@delete')->name('major.delete')->middleware('super-admin');
	// Photo Gallery Routes
	Route::get('photo_gallery/list', 'PhotoGalleryController@list')->name('photo_gallery.list')->middleware('super-admin');
	Route::get('photo_gallery/add', 'PhotoGalleryController@add')->name('photo_gallery.add')->middleware('super-admin');
	Route::post('photo_gallery/add', 'PhotoGalleryController@store')->name('photo_gallery.store')->middleware('super-admin');
	Route::get('photo_gallery/edit/{id}', 'PhotoGalleryController@edit')->name('photo_gallery.edit')->middleware('super-admin');
	Route::post('photo_gallery/edit/{id}', 'PhotoGalleryController@update')->name('photo_gallery.update')->middleware('super-admin');
	Route::get('photo_gallery/delete/{id}', 'PhotoGalleryController@delete')->name('photo_gallery.delete')->middleware('super-admin');
	// PDF File Routes
	Route::get('pdf_file/list', 'PdfFileController@list')->name('pdf_file.list')->middleware('super-admin');
	Route::get('pdf_file/add', 'PdfFileController@add')->name('pdf_file.add')->middleware('super-admin');
	Route::post('pdf_file/add', 'PdfFileController@store')->name('pdf_file.store')->middleware('super-admin');
	Route::get('pdf_file/edit/{id}', 'PdfFileController@edit')->name('pdf_file.edit')->middleware('super-admin');
	Route::post('pdf_file/update/{id}', 'PdfFileController@update')->name('pdf_file.update')->middleware('super-admin');
	Route::get('pdf_file/delete/{id}', 'PdfFileController@delete')->name('pdf_file.delete')->middleware('super-admin');
	// Fixed File Routes
	Route::get('fixed_file/add', 'FixedFileController@add')->name('fixed_file.add')->middleware('super-admin');
	Route::post('fixed_file/add', 'FixedFileController@store')->name('fixed_file.store')->middleware('super-admin');
	// Slogan Routes
	Route::get('slogan/add', 'SloganController@add')->name('slogan.add')->middleware('super-admin');
	Route::post('slogan/add', 'SloganController@store')->name('slogan.store')->middleware('super-admin');

	//payment gateway
	
	
});

Auth::routes();
Route::group(['prefix'=>'customer'],function (){

	Route::get('login', 'CustomerAuth\LoginController@showLoginForm')->middleware('not-auth')->name('customer.login');
	Route::post('login/verify', 'CustomerAuth\LoginController@verifyLogin')->name('customer.login.verify');
	Route::post('login', 'CustomerAuth\LoginController@login')->middleware('not-auth')->name('customer.login');
// Registration Routes...
	Route::get('register', 'CustomerAuth\RegisterController@showRegistrationForm')->middleware('not-auth')->name('customer.register');
	Route::post('register', 'CustomerAuth\RegisterController@register')->middleware('not-auth');

	Route::post('logout', 'CustomerAuth\LoginController@logout')->name('customer.logout');

    // Password Reset SMS Routes...
    Route::get('password/reset/sms', 'CustomerAuth\ForgotPasswordSMSController@index')->name('customer.password.sms.index')->middleware('not-auth');
    Route::post('password/reset/sms/send/verification_code', 'CustomerAuth\ForgotPasswordSMSController@sendVerificationCode')->name('customer.password.sms.send.verification_code')->middleware('not-auth');
    Route::get('password/reset/sms/verify', 'CustomerAuth\ForgotPasswordSMSController@verify')->name('customer.password.sms.verify')->middleware('not-auth');
    Route::post('password/reset/sms/verify', 'CustomerAuth\ForgotPasswordSMSController@verifyPost')->name('customer.password.sms.verify.post')->middleware('not-auth');
    Route::get('password/reset/sms/reset', 'CustomerAuth\ForgotPasswordSMSController@reset')->name('customer.password.sms.reset')->middleware('not-auth');
    Route::post('password/reset/sms/reset', 'CustomerAuth\ForgotPasswordSMSController@resetPost')->name('customer.password.sms.reset.post')->middleware('not-auth');
    Route::get('password/reset/sms/success', 'CustomerAuth\ForgotPasswordSMSController@success')->name('customer.password.sms.success')->middleware('not-auth');

// Password Reset Routes...
	//Route::get('password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('customer.password.request')->middleware('not-auth');
	//Route::post('password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email')->middleware('not-auth');
	//Route::get('password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm')->name('customer.password.reset')->middleware('not-auth');
	//Route::post('password/reset', 'CustomerAuth\ResetPasswordController@reset')->middleware('not-auth');


});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::post('twoait/getsmscheck', 'HomeController@twoait_getsmscheck');


Route::get('test', 'HomeController@rhythm');
Route::get('renew/sms', 'VehicleStickerController@renewSMS');
Route::post('renew/sms', 'VehicleStickerController@sendRenewSMS');

Route::get('previous-remark-update', 'FrontController@previousRemarkUpdate');



 // Route::post('applicationForm/store','ApplicationController@applicationFormStore')->middleware('applicant');



