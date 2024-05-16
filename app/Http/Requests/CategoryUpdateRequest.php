<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Traits\ApiValidationErrorsTrait;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $this->checkUnknownKey($this->keys(), ['name','_token','_method']);

        return [
            'name' => ['required','string',Rule::unique('categories','name')->ignore($this->category->id)]
        ];
    }


}


