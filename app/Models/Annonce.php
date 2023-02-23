<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Localisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'address',
        'price',
        'content',
        'user_id',
        'localisation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getShortContentAttribute()
    {
        return preg_replace('/^(.{80}).*$/s', '\\1 ...', $this->content);
    }
}
