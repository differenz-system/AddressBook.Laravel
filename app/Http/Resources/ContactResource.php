<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'department' => $this->department,
            'work_email' => $this->work_email,
            'work_phone' => $this->work_phone,
            'website' => $this->website,
            'birthday' => $this->birthday,
            'notes' => $this->notes,
            'is_favorite' => $this->is_favorite,
            'photo_path' => $this->photo_path,
            'photo_url' => $this->photo_path ? asset('storage/' . $this->photo_path) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
