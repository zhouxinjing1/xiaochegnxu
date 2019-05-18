<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

use App\Model\User;
use Illuminate\Http\Request;
use App\Tool\UploadTool;

class UserController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('客户')
            ->description('查看相关信息')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('客户')
            ->description('查看相关信息')
            ->body($this->detail($id));
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('客户相关信息')
            ->body($this->form($id)->edit($id));
    }

    public function update($id, Request $request)
    {
        if (isset($request->status)) {
            $this->setStatus($id, $request->status);
            return response()->json(['message' => '操作成功']);
        }

        if (isset($request->phone) && isset($request->email)) {
            $this->setUserInfo($id, $request);
            admin_toastr('操作成功');
            return redirect('/admin/user');
        }

    }

    public function setUserInfo($id, $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sex   = $request->sex;
        $user->phone = $request->phone;
        $user->city  = $request->city;
        if (!empty($request->password)) {
            $user->password = $request->password;
        }
        if (!empty($request->img)) {
            $user->img   = UploadTool::upload_once($request, 'img');
        }
        $user->save();
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->img  = UploadTool::upload_once($request, 'img');
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->sex  = $request->sex;
        $user->city =$request->city;
        $user->save();

        admin_toastr('操作成功');
        return  redirect('/admin/user');
    }


    public function setStatus($id, $status)
    {
        $status = $status == 'on' ? 1 : 0;
        $user = User::find($id);
        $user->status = $status;
        $user->save();
    }

    public function create(Content $content)
    {
        return $content
            ->header('客户')
            ->description('创建入驻客户')
            ->body($this->form());
    }

    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('email', '邮箱号');
            $filter->equal('phone', '手机号');
            $filter->equal('status', '状态')->select(['0' => '关闭', '1' => '打开']);

            $filter->scope('A', '入驻客户')->where('type', 1);
            $filter->scope('B', '授权客户')->where('type', 2);
        });

        $states = [
            'on'  => ['value' => 1, 'text' => '打开', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
        ];

        $grid->id('ID')->sortable();
        $grid->name('昵称');
        $grid->img('头像')->image(35, 35);
        $grid->email('邮箱号');
        $grid->phone('手机号');
        $grid->sex('性别')->using(['2' => '女', '1' => '男']);
        $grid->city('城市');
        $grid->money('余额')->label('danger')->sortable();
        $grid->type('来源')->display(function ($data){
            return $data[1];
        });
        $grid->status('状态')->switch($states);
        $grid->created_at('创建时间');
        return $grid;
    }


    protected function form($id = false)
    {
        $form = new Form(new User);

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
        });

        $form->text('name','昵称');
        $form->image('img','头像')->required();
        $form->email('email', '邮箱号')->required()->rules('unique:users');
        $form->mobile('phone','手机号')->required()->rules('unique:users');

        if ($id) {
            $form->password('password','密码')->placeholder('不修改 则为空')->rules('min:6');
        }else{
            $form->password('password','密码')->required()->rules('min:6');
        }

        $form->radio('sex','性别')->options(['1' => '男', '2'=> '女'])->default('1');
        $form->text('city','城市');

        return $form;
    }
}
