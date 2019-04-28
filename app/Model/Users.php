<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
   	protected $table ='user';
   	protected $primaryKey = 'id';   //primary  主要的
   	public $timestamps = false;     //timestamp 时间戳

   	protected $fillable = ['name','age','head'];   //fillable 可填充的
}
