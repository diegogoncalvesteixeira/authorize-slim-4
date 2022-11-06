<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cake\Utility\Hash;
use App\Traits\HelperTrait;


class User extends Model
{
    use HelperTrait;

    protected $fillable = [
        'id',
        'name',
        'email'
    ];

    protected $guarded = [
        'password'
    ];

    public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
      return $this->hasMany('App\UserRequest');
    }

    public function setPasswordAttribute($value)
    {
      $this->attributes['password'] = $this->encrypt($value);
    }

}
