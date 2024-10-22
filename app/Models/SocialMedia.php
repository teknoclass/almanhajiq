<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function item()
    {
        return $this->hasOne('App\Models\FrontSocialMedia', 'social_id', 'id');
    }

    public function updateItem($link)
    {
        if (!isset($this->item)) {
            $item = FrontSocialMedia::create([
                'social_id' => $this->id,
                'link' => isset($link) ? $link : '#',
            ]);
            return (isset($item)) ? true : false;
        }
        return $this->item->update(['link' => isset($link) ? $link : '#']);
    }

    public function hasLink()
    {
        return isset($this->item);
    }

    public function getLink()
    {
        return $this->hasLink() ? $this->item->link : '';
    }
}
