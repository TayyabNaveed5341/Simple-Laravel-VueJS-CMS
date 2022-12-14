<?php

namespace App\Models;

use App\Services\PageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'title', 'slug', 'content'];

    public static function boot() {
        parent::boot();

        static::creating(function($page) {            

            $page->full_slug_path = (new PageService)->generateFullPath($page);

        });
    }
    //r
    public function childPages(){
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }
    public function parent(){
        return $this->belongsTo(Page::class, 'parent_id', 'id');
    }

    //s
    public function scopeRootPages($q){
        $q->whereNull('parent_id');
    }
}
