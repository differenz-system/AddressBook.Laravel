<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'work_email' => ['nullable', 'email', 'max:255'],
            'work_phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'url', 'max:255'],
            'birthday' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'is_favorite' => ['boolean'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'first_name.max' => 'First name must not be greater than 255 characters',
            'last_name.required' => 'Last name is required',
            'last_name.max' => 'Last name must not be greater than 255 characters',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not be greater than 255 characters',
            'phone.max' => 'Phone number must not be greater than 50 characters',
            'address.max' => 'Address must not be greater than 500 characters',
            'city.max' => 'City must not be greater than 255 characters',
            'state.max' => 'State must not be greater than 255 characters',
            'country.max' => 'Country must not be greater than 255 characters',
            'postal_code.max' => 'Postal code must not be greater than 20 characters',
            'job_title.max' => 'Job title must not be greater than 255 characters',
            'company.max' => 'Company must not be greater than 255 characters',
            'department.max' => 'Department must not be greater than 255 characters',
            'work_email.email' => 'Work email must be a valid email address',
            'work_email.max' => 'Work email must not be greater than 255 characters',
            'work_phone.max' => 'Work phone must not be greater than 50 characters',
            'website.url' => 'Website must be a valid URL',
            'website.max' => 'Website must not be greater than 255 characters',
            'birthday.date' => 'Birthday must be a valid date',
            'is_favorite.boolean' => 'Favorite field must be true or false',
        ];
    }
}
