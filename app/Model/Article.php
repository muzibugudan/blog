<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //1关联数据表
    public $table='article';
//    2主键
    public $primaryKey='art_id';
//    3 允许批量操作的字段
    public $guarded=[];
//    4 是否维护crated_at和updated_at字段
    public $timestamps=false;
    public function cate()
    {
        return $this->belongsTo('App\Model\Cate','cate_id','cate_id');
    }
}
