<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [

        'name',
        'event_slug',

        'image',
        'short_description'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($event) {
    //         $event->event_slug = Str::slug($event->name, '-');
    //     });
    // }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['event_slug'] = Str::slug($value, '-');

        // Ensure that the slug is unique
        $slugCount = static::where('event_slug', $this->attributes['event_slug'])
            ->where('id', '!=', $this->id ?? 0)
            ->count();

        if ($slugCount > 0) {
            $this->attributes['event_slug'] .= '-' . ($slugCount + 1);
        }
    }
}
