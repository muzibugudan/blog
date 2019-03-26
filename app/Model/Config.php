<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //1关联数据表
    public $table='config';
//    2主键
    public $primaryKey='conf_id';
//    3 允许批量操作的字段
    public $guarded=[];
//    4 是否维护crated_at和updated_at字段
    public $timestamps=false;
}
