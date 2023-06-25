<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           
            'applicant_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'applicant_Def_id_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'applicant_nid_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            
            'vehicle_reg_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'insurance_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'tax_token_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'fitness_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'road_permit_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            
            'licence_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'nid_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'org_id_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            
            'school_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'civil_service_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'job_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'auth_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'ward_com_cert' => 'image|mimes:jpeg,png,jpg|max:300',
            'house_owner_cert' => 'image|mimes:jpeg,png,jpg|max:300',
            'marriage_cert_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'father_testm_photo' => 'image|mimes:jpeg,png,jpg|max:300',
            'mother_testm_photo' => 'image|mimes:jpeg,png,jpg|max:300'
            
        ];
    }
}