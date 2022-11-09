<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public static $wrap = 'page';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'full_path'=>route('page.show', $this->full_slug_path),
            'content'=>$this->content,
            'parent'=>new PageResource($this->whenLoaded('parent')),
            'children'=>PageResource::collection($this->whenLoaded('childPages'))

        ];
    }

    public function with($request){
        return['message'=>'Page retreived successfully.'];
    }
}
