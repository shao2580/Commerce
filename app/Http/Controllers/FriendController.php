<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLinkPost;
use \DB;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = request()->all();

        $where=[];
        $name=$query['name']??'';
        if ($name) {
            $where[]=['name','like',"%$name%"];
        }
        
        $pagesize=config('app.pageSize',8);
        $data = DB::table('friend')->orderBy('id','desc')->where($where)->paginate($pagesize);

        // dd($data);
        return view('links/list',compact('data','name','query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLinkPost $request)
    {
       $post = $request->except('_token');
       // dd($post);
       if ($request->hasFile('logo')) {         //判断文件是否存在
            $post['logo'] = $this->upload($request,'logo');
        }
        // dd($post);
        $res = DB::table('friend')->insert($post);
        if ($res) {
            return redirect('link/list');
        }
    }

     /*判断用户名是否存在*/
    public function checkName(){
       $name = request()->name;
        if (!$name) {
            return ['code'=>0,'msg'=>'请输入用户名'];
        }

        $count = DB::table('friend')->where('name',$name)->count();
        if ($count) {
            return ['code'=>0,'msg'=>'用户名已存在'];
        }else{
            return ['code'=>1,'msg'=>'用户名可用'];
        }

    }

     public function checkNamet(){
        $name=request()->name;
        $id=request()->id;
        // dd($id);
        $where=[
            ['id','!=',$id],
            ['name','=',$name]
        ];

        $count=DB::table('friend')->where($where)->count();
        // dd($count);
        if($count){
            return ['code'=>0,'msg'=>'用户名已存在'];

        }
    }


    /*上传图片*/
    public function upload(Request $request,$name){
         if ($request->file($name)->isValid()) {      //判断文件上传中是否出错
        $photo = $request->file($name);              //获取上传的文件 
        // dd($photo);  
        $extension = $photo->extension();               //文件后缀
        // $store_result = $photo->store(date('Ymd'));  //随机生成带后缀的文件名  在app下根据时间
        $store_result = $photo->storeAs(date('Ymd'),date('His').rand(100,999).'.'.$extension);
                            //  手动生成    路径      文件名     后缀名
        // print_r($store_result);die;
        return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if ($id) {
            $data=DB::table('friend')->where('id',$id)->first(); // DB 类
            // $data=Users::find($id);   //model 类
            if (!$data) {
                return redirect('links/list'); 
            }
            return view('links/edit',['data'=>$data]);  
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $post = $request->except(['_token']);
        // dd($data);
        // 删除原来图片
            unset($post['logo']);
        if ($request->hasFile('logo')) {         //判断文件是否存在
            
            
            $post['logo'] = $this->upload($request,'logo');
            
        }
         /*查询构造器*/
        $res = DB::table('friend')
                ->where('id',$id)
                ->update($post);

      // 
        // if ($res) {
            return redirect('link/list');
        // }


        //  $data=request()->post();
        // unset($data['_token']);
        // $id=$data['id'];
        // // dd($data)
        // if(request()->hasFile('logo')){
        //     $store_result=$this->upload('logo');
        //     $data['logo']=$store_result;
        //     $logo=DB::table('friend')->where('id',$id)->first();
        //     // dd($img);
        //     $path=$logo->logo;
        //     $path=storage_path('app/uploads/'.$path);
        //     unlink($path);
        //     $res=DB::table('friend')->where('id',$id)->update($data);
        //     if($res){
        //         echo "<script>alert('修改成功');location.href='/iink/index'</script>";
        //     }else{
        //         echo "<script>alert('修改失败');location.href='/link/update'</script>";
        //     }   
        // }else{
        //     $res=DB::table('friend')->where('id',$id)->update($data);
        //     if($res){
        //         echo "<script>alert('修改成功');location.href='/link/index'</script>";
        //     }else{
        //         echo "<script>alert('未修改');location.href='/link/index'</script>";
        //     }   
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // echo $id;
        if ($id) {
            /*查询构造器*/
            $res = DB::table('friend')->where('id',$id)->delete();
            // $res = DB::table('user')->delete($id);   //适用于主键字段是id的

            /* ORM */
            // $res = Users::destroy($id);
            // $res = Users::where('id',$id)->destroy($id);
            if ($res) {
                 return redirect('link/list');
            }
        }
    }
}
