<?php

namespace App\Http\Resources\Employee;

use App\Enums\Employee\Status;
use App\Enums\Gender;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{

    public function toArray($request)
    {
        try {
            return [
                'id' => $this->id,
                'uuid' => $this->uuid,
                'name' => $this->name,
                'code_number' => $this->code_number,
                'department' => $this->department_name ?? '-',
                'designation' => $this->designation_name ?? '-',
                'photo' => $this->photo_url,
                'category' => $this->category_name ?? null,
                'category_name' => ucwords($this->category_name ?? ''),
            ];
        } catch (\Throwable $th) {
            return ['message' => $th->getMessage()];
        }
    }
}
