<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiValidationErrorsTrait
{
     /**
     * We have this function to overwrite the failedValidation function and make sure it won't redirect and properly
     * handle the json error response here.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(collect($validator->errors())->toArray()));
    }

    /**
     * @param array $errors
     * @return JsonResponse
     */
    private function response(array $errors)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function checkUnknownKey(array $actual_keys, array $expected_keys)
    {

        $unknownKeys = array_diff($actual_keys, $expected_keys);

        if (!empty($unknownKeys)) {
            $validator = \Illuminate\Support\Facades\Validator::make([], []); // Create an empty validator instance

            // Add a validation error message
            $validator->errors()->add('unknown_keys', 'Unknown keys are passed: ' . implode(', ', $unknownKeys));

            // Throw a ValidationException with the errors
            throw new ValidationException($validator, response()->json(['errors' => $validator->errors()], 422));
        }
    }
}
