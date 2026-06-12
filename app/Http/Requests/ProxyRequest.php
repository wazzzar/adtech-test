<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProxyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:128',
            'address' => 'required|ipv4',
            'status' => 'string|max:16',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => empty($this->status) ? 'inactive' : $this->status,
        ]);
    }
}
