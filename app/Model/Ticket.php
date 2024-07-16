<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\RapidXUser;
use App\Model\ServiceType;

class Ticket extends Model
{
    protected $table = 'tickets';

    public function requestor_info() {
        return $this->hasOne(RapidXUser::class, 'id', 'requestor');
    }

    public function assignee_info() {
        return $this->hasOne(RapidXUser::class, 'id', 'assignee');
    }

    public function second_assignee_info() {
        return $this->hasOne(RapidXUser::class, 'id', 'second_assignee');
    }

    public function service_type_info() {
        return $this->hasOne(ServiceType::class, 'id', 'service_type_id');
    }
}
