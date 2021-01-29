<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    use HasFactory;

    protected $guarded = [ 'id' ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string'
    ];

    public function roles()  {
        return $this->belongsToMany(Role::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

}
