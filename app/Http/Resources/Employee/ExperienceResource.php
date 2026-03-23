<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\MediaResource;
use App\Http\Resources\OptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'headline' => $this->headline,
            'title' => $this->title,
            'organization_name' => $this->organization_name,
            'location' => $this->location,
            'job_profile' => $this->job_profile,
            'employment_type' => OptionResource::make($this->whenLoaded('employmentType')),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'media_token' => $this->getMeta('media_token'),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'created_at' => \Cal::dateTime($this->created_at),
            'updated_at' => \Cal::dateTime($this->updated_at),
        ];
    }
}
