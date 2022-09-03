<?php

namespace App\Http\Requests\Forum;

use App\Http\Requests\AuthenticatedRequest;

/**
 * @property string $name
 * @property string $description
 */
class CreateRequest extends AuthenticatedRequest
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
            ...parent::rules(),
        ];
    }
}
