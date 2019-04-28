<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;

class ZhoukaoController extends Controller
{
    public function index()
    {	
    	// Cache::flush();       //删除全部缓存   需要引入门面 
    	$query=request()->all();
    	$where=[];
    	$where[]=[
    		'is_del','=',1
    	];
    	$name = $query['goods_name']??'';
    	if ($name) {
    		$where[]=['goods_name','like',"%$name%"];
    	}
    	$description=$query['description']??'';
    	if ($description) {
    		$where[]=['description','like',"%$description%"];
    	}
    	// $paginate=config('app.pageSize','8');
    	$data = DB::table('goods')->where($where)->paginate(6);
    	return view('zk/list',compact('data','name','description','query'));
    }

    public function info($id)
    {
    
    	if (!$id) {
    		exit('非法请求');
    	}
    	$data = cache('data_'.$id);
    	
    	if (!$data) {
    		echo '查询数据库';
    		$data = DB::table('goods')->where('goods_id',$id)->first();
    		
    		cache(['data_'.$id=>$data],60*24);

    	}
    	// dd($data);
    	return view('zk/info',compact('data'));
    }

    public function edit($id)
    {	
    
    	if ($id) {
    		$data = DB::table('goods')->where('goods_id',$id)->first();
    		// dd($data);
    	}
    	return view('zk/edit',['data'=>$data]);
    }

    public function update(Request $request,$id)
    {
    	if (!$id) {
    		exit('非法请求');
    	}
    	$data =$request->except(['_token']);
    	if ($request->hasFile('goods_img')) { 

            $data['goods_img'] = $this->upload($request,'goods_img');
            // 删除原来图片
            unset($data['goods_img']);
        }
        $res = DB::table('goods')->where('goods_id',$id)->update($data);

        if ($res==0) {
        	return redirect('zk');
        }else{

        	$data = DB::table('goods')->where('goods_id',$id)->first();
        	cache(['data_'.$id=>$data],60*24);
        	return redirect('zk');
        }

    }


     public function del($id)
    {
    	if ($id) {
    		$res = DB::table('goods')->where('goods_id',$id)->update(['is_del'=>2]);
    		if ($res) {
    			return redirect('zk');
    		}
    	}
    	Cache::forget('data_'.$id);  //删除单个缓存  需要引入门面 


    }

}
