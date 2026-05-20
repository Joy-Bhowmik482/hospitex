<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\AutoCreatedBy;

class BaseModel extends Model
{
    use AutoCreatedBy;
}
