<?php

namespace DurianSoftware\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Delatbabel\Elocrypt\Elocrypt;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, Elocrypt;

    protected $table = "dim_users";

    protected $appends = ['user_status'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'client_id',
        'birth_date_id',
        'register_date_id',
        'member_number',
        'password',
        'first_name',
        'last_name',
        'nick_name',
        'gender',
        'email',
        'phone',
        'image1',
        'image2',
        'image_show',
        'description_status',
        'is_block',
        'user_right',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $encrypts = [
        'member_number',
        'first_name',
        'last_name',
        'nick_name',
        'email',
        'phone',
    ];

    public function birthDate()
    {
        return $this->hasOne('DurianSoftware\Models\Date', 'id', 'birth_date_id');
    }

    public function registerDate()
    {
        return $this->hasOne('DurianSoftware\Models\Date', 'id', 'register_date_id');
    }

    public function getUserStatusAttribute()
    {
        if ($this->is_block == 'block') {
            return 'BLOCK';
        } else {
            return 'NORMAL';
        }
    }
    /**
     * Decrypt encrypted data before it is processed by cast attribute
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        return parent::castAttribute($key, $this->doDecryptAttribute($key, $value));
    }

    public function getDirty()
    {
        $dirty = [];

        foreach ($this->attributes as $key => $value) {
            if (! $this->originalIsEquivalent($key, $value)) {
                        $dirty[$key] = $value;
            }
        }

        return $dirty;
    }
}
