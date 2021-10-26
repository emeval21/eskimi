<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaign extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'daily_budget' => $this->daily_budget,
            'total_budget' => $this->total_budget,
            'from' => $this->from,
            'to' => $this->to,
            'campaign_image' => $this->campaign_image
        ];
    }

    public function with($request){
        return [
            'version' => '1.0.0',
            'author' => 'Emeka Val Okoye',
            'author_url' => url('https://linkedin.com/in/emeka-val-okoye')
        ];
    }
}
