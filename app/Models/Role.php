<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public function specs()
    {
        return $this->belongsToMany(Spec::class, 'spec_role_user');
    }
}
