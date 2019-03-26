<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1关联数据表
    public $table='user';
//    2主键
    public $primaryKey='user_id';
//    3 允许批量操作的字段
    public $guarded=[];
//    4 是否维护crated_at和updated_at字段
    public $timestamps=false;
    //    添加动态属性 ,关联角色属性
    public function role()
    {
        return $this->belongsToMany('App\Model\Role','user_role','user_id','role_id');
    }
}
