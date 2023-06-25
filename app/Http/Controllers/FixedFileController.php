<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FixedFile;

class FixedFileController extends Controller
{
    public function add(Request $request)
    {
        $fixed_file = FixedFile::first();
        return view('fixed_file.add', compact('fixed_file'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "graveyard_allotment" => "image|nullable|mimes:jpg,jpeg,png",
            "bus_service" => "image|nullable|mimes:jpg,jpeg,png",
            "mp_checkpost" => "image|nullable|mimes:jpg,jpeg,png",
            "shuttle_service" => "image|nullable|mimes:jpg,jpeg,png",
            "contact_info" => "image|nullable|mimes:jpg,jpeg,png",
            "helpline" => "image|nullable|mimes:jpg,jpeg,png",
            "sticker_policy" => "mimes:pdf",
            "graveyard_policy" => "mimes:pdf",
            "sign_up_tutorial" => "mimes:pdf",
            "sticker_tutorial" => "mimes:pdf",
        ]);
        $data = $request->all();
        $path = 'assets/images/fixed_files';
        $fixed_file = FixedFile::first();
        if ($fixed_file) {
            if ($request->hasFile('graveyard_allotment')) {
                if ($fixed_file->graveyard_allotment) {
                    $file = $path . '/' . $fixed_file->graveyard_allotment;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $graveyard_allotment = $request->file('graveyard_allotment');
                $data['graveyard_allotment'] = md5($graveyard_allotment->getClientOriginalName() . time()) . "." .  $graveyard_allotment->getClientOriginalExtension();
                $graveyard_allotment->move($path, $data['graveyard_allotment']);
            }
            if ($request->hasFile('bus_service')) {
                if ($fixed_file->bus_service) {
                    $file = $path . '/' . $fixed_file->bus_service;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $bus_service = $request->file('bus_service');
                $data['bus_service'] = md5($bus_service->getClientOriginalName() . time()) . "." .  $bus_service->getClientOriginalExtension();
                $bus_service->move($path, $data['bus_service']);
            }
            if ($request->hasFile('private_car')) {
                if ($fixed_file->private_car) {
                    $file = $path . '/' . $fixed_file->private_car;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $private_car = $request->file('private_car');
                $data['private_car'] = md5($private_car->getClientOriginalName() . time()) . "." .  $private_car->getClientOriginalExtension();
                $private_car->move($path, $data['private_car']);
            }
            if ($request->hasFile('anti_malaria_drive')) {
                if ($fixed_file->anti_malaria_drive) {
                    $file = $path . '/' . $fixed_file->anti_malaria_drive;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $anti_malaria_drive = $request->file('anti_malaria_drive');
                $data['anti_malaria_drive'] = md5($anti_malaria_drive->getClientOriginalName() . time()) . "." .  $anti_malaria_drive->getClientOriginalExtension();
                $anti_malaria_drive->move($path, $data['anti_malaria_drive']);
            }
            if ($request->hasFile('drainage_and_cleaning')) {
                if ($fixed_file->drainage_and_cleaning) {
                    $file = $path . '/' . $fixed_file->drainage_and_cleaning;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $drainage_and_cleaning = $request->file('drainage_and_cleaning');
                $data['drainage_and_cleaning'] = md5($drainage_and_cleaning->getClientOriginalName() . time()) . "." .  $drainage_and_cleaning->getClientOriginalExtension();
                $drainage_and_cleaning->move($path, $data['drainage_and_cleaning']);
            }
            if ($request->hasFile('disposal_of_garbage')) {
                if ($fixed_file->disposal_of_garbage) {
                    $file = $path . '/' . $fixed_file->disposal_of_garbage;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $disposal_of_garbage = $request->file('disposal_of_garbage');
                $data['disposal_of_garbage'] = md5($disposal_of_garbage->getClientOriginalName() . time()) . "." .  $disposal_of_garbage->getClientOriginalExtension();
                $disposal_of_garbage->move($path, $data['disposal_of_garbage']);
            }
            if ($request->hasFile('other_services')) {
                if ($fixed_file->other_services) {
                    $file = $path . '/' . $fixed_file->other_services;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $other_services = $request->file('other_services');
                $data['other_services'] = md5($other_services->getClientOriginalName() . time()) . "." .  $other_services->getClientOriginalExtension();
                $other_services->move($path, $data['other_services']);
            }
            if ($request->hasFile('mp_checkpost')) {
                if ($fixed_file->mp_checkpost) {
                    $file = $path . '/' . $fixed_file->mp_checkpost;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $mp_checkpost = $request->file('mp_checkpost');
                $data['mp_checkpost'] = md5($mp_checkpost->getClientOriginalName() . time()) . "." .  $mp_checkpost->getClientOriginalExtension();
                $mp_checkpost->move($path, $data['mp_checkpost']);
            }
            if ($request->hasFile('shuttle_service')) {
                if ($fixed_file->shuttle_service) {
                    $file = $path . '/' . $fixed_file->shuttle_service;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $shuttle_service = $request->file('shuttle_service');
                $data['shuttle_service'] = md5($shuttle_service->getClientOriginalName() . time()) . "." .  $shuttle_service->getClientOriginalExtension();
                $shuttle_service->move($path, $data['shuttle_service']);
            }
            if ($request->hasFile('contact_info')) {
                if ($fixed_file->contact_info) {
                    $file = $path . '/' . $fixed_file->contact_info;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $contact_info = $request->file('contact_info');
                $data['contact_info'] = md5($contact_info->getClientOriginalName() . time()) . "." .  $contact_info->getClientOriginalExtension();
                $contact_info->move($path, $data['contact_info']);
            }
            if ($request->hasFile('helpline')) {
                if ($fixed_file->helpline) {
                    $file = $path . '/' . $fixed_file->helpline;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $helpline = $request->file('helpline');
                $data['helpline'] = md5($helpline->getClientOriginalName() . time()) . "." .  $helpline->getClientOriginalExtension();
                $helpline->move($path, $data['helpline']);
            }
            if ($request->hasFile('sticker_policy')) {
                if ($fixed_file->sticker_policy) {
                    $file = $path . '/' . $fixed_file->sticker_policy;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $sticker_policy = $request->file('sticker_policy');
                $data['sticker_policy'] = md5($sticker_policy->getClientOriginalName() . time()) . "." .  $sticker_policy->getClientOriginalExtension();
                $sticker_policy->move($path, $data['sticker_policy']);
            }
            if ($request->hasFile('graveyard_policy')) {
                if ($fixed_file->graveyard_policy) {
                    $file = $path . '/' . $fixed_file->graveyard_policy;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $graveyard_policy = $request->file('graveyard_policy');
                $data['graveyard_policy'] = md5($graveyard_policy->getClientOriginalName() . time()) . "." .  $graveyard_policy->getClientOriginalExtension();
                $graveyard_policy->move($path, $data['graveyard_policy']);
            }
            if ($request->hasFile('graveyard_application')) {
                if ($fixed_file->graveyard_application) {
                    $file = $path . '/' . $fixed_file->graveyard_application;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $graveyard_application = $request->file('graveyard_application');
                $data['graveyard_application'] = md5($graveyard_application->getClientOriginalName() . time()) . "." .  $graveyard_application->getClientOriginalExtension();
                $graveyard_application->move($path, $data['graveyard_application']);
            }
            if ($request->hasFile('sign_up_tutorial')) {
                if ($fixed_file->sign_up_tutorial) {
                    $file = $path . '/' . $fixed_file->sign_up_tutorial;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $sign_up_tutorial = $request->file('sign_up_tutorial');
                $data['sign_up_tutorial'] = md5($sign_up_tutorial->getClientOriginalName() . time()) . "." .  $sign_up_tutorial->getClientOriginalExtension();
                $sign_up_tutorial->move($path, $data['sign_up_tutorial']);
            }
            if ($request->hasFile('sticker_tutorial')) {
                if ($fixed_file->sticker_tutorial) {
                    $file = $path . '/' . $fixed_file->sticker_tutorial;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
                $sticker_tutorial = $request->file('sticker_tutorial');
                $data['sticker_tutorial'] = md5($sticker_tutorial->getClientOriginalName() . time()) . "." .  $sticker_tutorial->getClientOriginalExtension();
                $sticker_tutorial->move($path, $data['sticker_tutorial']);
            }
            $fixed_file->update($data);
        } else {
            if ($request->hasFile('graveyard_allotment')) {
                $graveyard_allotment = $request->file('graveyard_allotment');
                $data['graveyard_allotment'] = md5($graveyard_allotment->getClientOriginalName() . time()) . "." .  $graveyard_allotment->getClientOriginalExtension();
                $graveyard_allotment->move($path, $data['graveyard_allotment']);
            }
            if ($request->hasFile('bus_service')) {
                $bus_service = $request->file('bus_service');
                $data['bus_service'] = md5($bus_service->getClientOriginalName() . time()) . "." .  $bus_service->getClientOriginalExtension();
                $bus_service->move($path, $data['bus_service']);
            }
            if ($request->hasFile('private_car')) {
                $private_car = $request->file('private_car');
                $data['private_car'] = md5($private_car->getClientOriginalName() . time()) . "." .  $private_car->getClientOriginalExtension();
                $private_car->move($path, $data['private_car']);
            }
            if ($request->hasFile('anti_malaria_drive')) {
                $anti_malaria_drive = $request->file('anti_malaria_drive');
                $data['anti_malaria_drive'] = md5($anti_malaria_drive->getClientOriginalName() . time()) . "." .  $anti_malaria_drive->getClientOriginalExtension();
                $anti_malaria_drive->move($path, $data['anti_malaria_drive']);
            }
            if ($request->hasFile('drainage_and_cleaning_show')) {
                $drainage_and_cleaning_show = $request->file('drainage_and_cleaning_show');
                $data['drainage_and_cleaning_show'] = md5($drainage_and_cleaning_show->getClientOriginalName() . time()) . "." .  $drainage_and_cleaning_show->getClientOriginalExtension();
                $drainage_and_cleaning_show->move($path, $data['drainage_and_cleaning_show']);
            }
            if ($request->hasFile('disposal_of_garbage')) {
                $disposal_of_garbage = $request->file('disposal_of_garbage');
                $data['disposal_of_garbage'] = md5($disposal_of_garbage->getClientOriginalName() . time()) . "." .  $disposal_of_garbage->getClientOriginalExtension();
                $disposal_of_garbage->move($path, $data['disposal_of_garbage']);
            }
            if ($request->hasFile('mp_checkpost')) {
                $mp_checkpost = $request->file('mp_checkpost');
                $data['mp_checkpost'] = md5($mp_checkpost->getClientOriginalName() . time()) . "." .  $mp_checkpost->getClientOriginalExtension();
                $mp_checkpost->move($path, $data['mp_checkpost']);
            }
            if ($request->hasFile('shuttle_service')) {
                $shuttle_service = $request->file('shuttle_service');
                $data['shuttle_service'] = md5($shuttle_service->getClientOriginalName() . time()) . "." .  $shuttle_service->getClientOriginalExtension();
                $shuttle_service->move($path, $data['shuttle_service']);
            }
            if ($request->hasFile('other_services')) {
                $other_services = $request->file('other_services');
                $data['other_services'] = md5($other_services->getClientOriginalName() . time()) . "." .  $other_services->getClientOriginalExtension();
                $other_services->move($path, $data['other_services']);
            }
            if ($request->hasFile('contact_info')) {
                $contact_info = $request->file('contact_info');
                $data['contact_info'] = md5($contact_info->getClientOriginalName() . time()) . "." .  $contact_info->getClientOriginalExtension();
                $contact_info->move($path, $data['contact_info']);
            }
            if ($request->hasFile('helpline')) {
                $helpline = $request->file('helpline');
                $data['helpline'] = md5($helpline->getClientOriginalName() . time()) . "." .  $helpline->getClientOriginalExtension();
                $helpline->move($path, $data['helpline']);
            }
            if ($request->hasFile('sticker_policy')) {
                $sticker_policy = $request->file('sticker_policy');
                $data['sticker_policy'] = md5($sticker_policy->getClientOriginalName() . time()) . "." .  $sticker_policy->getClientOriginalExtension();
                $sticker_policy->move($path, $data['sticker_policy']);
            }
            if ($request->hasFile('graveyard_policy')) {
                $graveyard_policy = $request->file('graveyard_policy');
                $data['graveyard_policy'] = md5($graveyard_policy->getClientOriginalName() . time()) . "." .  $graveyard_policy->getClientOriginalExtension();
                $graveyard_policy->move($path, $data['graveyard_policy']);
            }
            if ($request->hasFile('graveyard_application')) {
                $graveyard_application = $request->file('graveyard_application');
                $data['graveyard_application'] = md5($graveyard_application->getClientOriginalName() . time()) . "." .  $graveyard_application->getClientOriginalExtension();
                $graveyard_application->move($path, $data['graveyard_application']);
            }
            if ($request->hasFile('sign_up_tutorial')) {
                $sign_up_tutorial = $request->file('sign_up_tutorial');
                $data['sign_up_tutorial'] = md5($sign_up_tutorial->getClientOriginalName() . time()) . "." .  $sign_up_tutorial->getClientOriginalExtension();
                $sign_up_tutorial->move($path, $data['sign_up_tutorial']);
            }
            if ($request->hasFile('sticker_tutorial')) {
                $sticker_tutorial = $request->file('sticker_tutorial');
                $data['sticker_tutorial'] = md5($sticker_tutorial->getClientOriginalName() . time()) . "." .  $sticker_tutorial->getClientOriginalExtension();
                $sticker_tutorial->move($path, $data['sticker_tutorial']);
            }
            FixedFile::create($data);
        }

        return redirect()->back()->with('success', 'Fixed files updated successfull.');
    }
}
