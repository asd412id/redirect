<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Links extends Model
{
    protected $table = 'link_lists';

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getSlAttribute()
    {
        return $this->attributes['shortlink'];
    }

    public function getCsAttribute()
    {
        return $this->attributes['case_sensitive'];
    }

    public function getActAttribute()
    {
        return $this->attributes['active'];
    }

    public function getShortlinkAttribute($value)
    {
        return '<button class="btn badge badge-primary get-link" title="Klik untuk menyalin Link">' . url($value ?? "/") . '</button>';
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getCaseSensitiveAttribute($value)
    {
        return $value ? '<span class="badge badge-warning">YA</span>' : '<span class="badge badge-secondary">TIDAK</span>';
    }

    public function getActiveAttribute($value)
    {
        $status = '<span class="badge badge-danger">Tidak Aktif</span>';
        if ($value) {
            $status = '<span class="badge badge-success">Aktif</span>';
        }
        return $status;
    }
}
