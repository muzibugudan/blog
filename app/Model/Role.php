<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //1关联数据表
    public $table='role';
//    2主键
    public $primaryKey='id';
//    3 允许批量操作的字段
    public $guarded=[];
//    4 是否维护crated_at和updated_at字段
    public $timestamps=false;
//    添加动态属性 ,关联权限属性
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permission','role_permission','role_id','permission_id');
    }
}
