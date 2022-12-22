<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'release_date' => $this->release_date,
            'rating'       => $this->rating,
            'ticket_price' => $this->ticket_price,
            'slug'         => $this->country,
            'country'      => $this->country,
            'genre'        => $this->genre,
            'photo'        => $this->photo
        ];
    }
}
