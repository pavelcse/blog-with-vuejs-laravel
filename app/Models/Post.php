<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class Post extends Model
{
    use SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        $authUser = Auth::user();

        static::creating(function ($model) use ($authUser) {
            if (Schema::hasColumn($model->getTable(), 'user_id')) {
                $model->user_id = $authUser->id;
            }
        });

        /*static::updating(function ($model) use ($authUser) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $authUser->id;
            }
        });

        static::deleting(function ($model) use ($authUser) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                $model->deleted_by = $authUser->id;
            }
        });*/
    }
}
