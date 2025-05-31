<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url'
    ];
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getUrlAttribute($value)
    {
        return $value;
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = strtolower($value);
    }

    public static function setSocials(string $name, string $url): void
    {
        $name = strtolower($name);
        $social = static::where('name', $name)->first();

        if ($social) {
            $social->url = $url;
            $social->save();
        }
        else
        {
            static::create([
                'name' => $name,
                'url' => $url
            ]);
        }
    }
}
