<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'status',
        'user_id',
        'folder_id',
        'short_description',
        'long_description',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function privilages()
    {
        return $this->hasMany(FilePrivilage::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'file_privilages', 'file_id', 'user_id');
    }
}
