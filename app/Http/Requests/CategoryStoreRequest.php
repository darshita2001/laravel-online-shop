<?php

namespace App\Http\Requests;

use App\Traits\ApiValidationErrorsTrait;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    use ApiValidationErrorsTrait;

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
        $this->checkUnknownKey($this->keys(), ['name','_token']);

        return [
            'name' => ['required','string',Rule::unique('categories','name')]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Category name',
        ];
    }
}
