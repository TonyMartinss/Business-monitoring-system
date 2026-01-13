<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoles extends Model
{
//
public function isAdmin()
{
    return $this->role === 'admin';
}
}
