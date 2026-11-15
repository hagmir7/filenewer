<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocaleRequest extends FormRequest
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
            'locale' => ['required', 'string', Rule::in(array_keys(config('app.supported_locales')))],
            'return_to' => ['bail', 'required', 'string', 'max:2048', function (string $attribute, mixed $value, \Closure $fail): void {
                if (! str_starts_with($value, '/') || str_starts_with($value, '//') || preg_match('/[\\\\\x00-\x20\x7f]/', $value)) {
                    $fail(__('validation.url', ['attribute' => $attribute]));
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'locale.in' => __('Please choose a supported language.'),
        ];
    }
}
