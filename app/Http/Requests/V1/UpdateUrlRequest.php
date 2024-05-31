<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Example of authorization conditions for API requests
        // Proper tokens with varying permissions should be generated and assigned to each user for correct authorization
        // For simplicity in testing, this has been omitted in this application
        // However, in a real production environment, robust authorization rules and policies must be implemented for API users
        // if (request()->is('api/*')) {
        //     $user = $this->user();
        //     return $user != null && $user->tokenCan('create');
        // }

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
            'original_url' => 'required|url'
        ];
    }
}
