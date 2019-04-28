<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserPost;
use Illuminate\Validator\Rule;
use App\Model\Users;
use Illuminate\Support\Facades\Auth; //门面获取登录用户
use DB;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        Auth::user();   //获取当前认证用户


        /***************模拟****练习session**************/
        request()->session()->put('name','张三');           //设置session
        $name = request()->session()->get('name','222');  //获取session
        session(['name'=>'李四']);          //全局辅助函数 设置 session
        $name = session('name');           // 获取
        $data = request()->session()->all();  //获取session中所有数据

        request()->session()->forget('key');   //删除单条
        request()->session()->flush();   //删除所有
        $value = request()->session()->pull('key', 'default');  //获取值后 删除数据

        // echo $name;
        /*********************************************/

        // $data=DB::select('select * from user');   //原生SQL
        $query=request()->all();
        // dd($query);
        $where=[];
        $name=$query['name']??'';
        if ($name) {
            $where[]=['name','like',"%$name%"];
        }
        $age=$query['age']??'';
        if ($age) {
            $where['age']=$age;
        }

        $pagesize=config('app.pageSize',8);
        $data= DB::table('user')->orderBy('id','desc')->where($where)->paginate($pagesize);
        // dd($data);
        return view('users/list',compact('data','name','age','query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*第二种*/
    // public function store(StoreUserPost $request)
    public function store(Request $request)
    {
        // $request->input();
        $post=$request->except('_token');        //except 返回集合中除了指定键的所有集合项
        // $post=$request->only('name','age');        //only 方法返回集合中指定键的集合项：
        // dd($post);
        /***第一种****/
        // $request->validate([
        //     'name'=>'required|unique:user|max:20|min:3',
        //     'age'=>'required|integer',
        // ],[
        //     'name.required'=>'用户名不能为空',
        //     'name.unique'=>'用户名已存在',
        //     'name.max'=>'用户名最多20位',
        //     'name.min'=>'用户名最少3位',
        //     'age.required'=>'年龄不能为空',
        //     'age.integer'=>'年龄必须为整数',
        // ]);
        /****第三种*****/

        $validator=\Validator::make($post, [
            'name'=>'required|unique:user|max:20|min:3',
            'age'=>'required|integer',
        ],[
            'name.required'=>'用户名不能为空',
            'name.unique'=>'用户名已存在',
            'name.max'=>'用户名最多20位',
            'name.min'=>'用户名最少3位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须为整数',

        ]);

        if ($validator->fails()) {
            return redirect('user/add')
            ->withErrors ($validator)
            ->withInput();
        }

        if ($request->hasFile('head')) {         //判断文件是否存在
            $post['head'] = $this->upload($request,'head');
        }
        // dd($post);
       // unset($post['_token']);         /*和 excepy  only 一个性质 */
       
       // $res= DB::insert('insert into user (name,age) values(?,?)',[$post['name'],$post['age']]);   //原生
       // $res=DB::table('user')->insert($post);        //构造器
        $res = Users::create($post);

       // dd($res);
       if ($res) {
            // echo "<script>alert('成功');location.href='/user/list'</script>";
           return redirect('user/list');   //->with('msg','添加成功');
       }
    }

    /*判断用户名是否存在*/
    public function checkName(){
       $name = request()->name;
        if (!$name) {
            return ['code'=>0,'msg'=>'请输入用户名'];
        }

        $count = DB::table('user')->where('name',$name)->count();
        if ($count) {
            return ['code'=>0,'msg'=>'用户名已存在'];
        }else{
            return ['code'=>1,'msg'=>'用户名可用'];
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
            // $data=DB::select('select * from user where id=?',[$id]);  //原生sql
            // $data=DB::table('user')->where('id',$id)->first(); // DB 类
            
            $data=Users::find($id);   //model 类
            if (!$data) {
                return redirect('users/list'); 
            }
            return view('users/edit',['data'=>$data]);  
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
        if ($request->hasFile('edit_head')) {         //判断文件是否存在
            
            
            $post['head'] = $this->upload($request,'edit_head');
            // 删除原来图片
            unset($post['edit_head']);
        }
        
       /* 原生sql 更新*/
        // $res = DB::update('update user set name=:name,age=:age,head=:head where id='.$id,['name'=>$post['name'],'age'=>$post['age'],'head'=>$post['head'] ]);
        
        /*查询构造器*/
        // $res = DB::table('user')
        //         ->where('id',$id)
        //         ->update($post);

        /* ORM */
        $res = Users::where('id',$id)->update($post);
        // $users=Users::find($id);
        // $users->name=$post['name'];
        // $users->age=$post['age'];
        // $users->head=$post['head'];
        // $res = $users->save();
        
        if ($res) {
            return redirect('user/list');
        }

        // dd($res);
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
            /*原生 SQL*/
            // $res=DB::delete('delete from user where id='.$id);
            /*查询构造器*/
            // $res = DB::table('user')->where('id',$id)->delete();
            // $res = DB::table('user')->delete($id);   //适用于主键字段是id的

            /* ORM */
            $res = Users::destroy($id);
            // $res = Users::where('id',$id)->destroy($id);
            if ($res) {
                 return redirect('user/list');
            }
        }
    }

    /*登录处理*/
    public function login(){
        // $data=request()->all();
        $name=request()->name;
        $password=request()->password;
        // dd(Auth::attempt(['name' => $name, 'password' => $password]));
        if (Auth::attempt(['name' => $name, 'password' => $password])) {
            // 认证通过...
            return redirect()->intended('/link/list');
        }
    }

    /*找回密码***发送邮箱*/
    public function send(){
        $email = request()->email;
        $name = request()->name;
        if ($email) {
            /* emailcon 发送的内容 */
            Mail::send('emailcon',['name'=>$name],function($message)use($email){
                $message->subject('找回密码');  //邮箱标题
                $message->to($email);          //接收方
            });
        }
    }
    // f52b34208026489d9638151b95b96212
    /*发送短信验证*/
    public function sendSms()
    {
            $host = "http://dingxin.market.alicloudapi.com";
            $path = "/dx/sendSms";
            $method = "POST";
            $appcode = "f52b34208026489d9638151b95b96212";
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);
            $rand = rand(100000,999999);
            $querys = "mobile=13653671225&param=code%3A".$rand."&tpl_id=TP1711063";
            $bodys = "";
            $url = $host . $path . "?" . $querys;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            if (1 == strpos("$".$host, "https://"))
            {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            var_dump(curl_exec($curl));
    }

    // public function show(){
    //     //
    // }

}
