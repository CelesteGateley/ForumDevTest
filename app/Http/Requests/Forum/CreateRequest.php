<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property string $description
 */
class CreateRequest extends FormRequest
{
    public function getData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:forums,name',
            'description' => 'required',
        ];
    }
}
