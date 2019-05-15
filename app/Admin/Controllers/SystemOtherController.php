<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;



use App\Model\SystemOther;
use Illuminate\Http\Request;

class SystemOtherController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('系统设置')
            ->description('关于小程序中相关配置')
            ->body($this->form()->edit(1));
    }


    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    public function update(Request $request)
    {
        $so = SystemOther::find($request->id);
        $so->toastr = $request->toastr;
        $so->save();

        admin_toastr('操作成功');
        return redirect('/admin/system/system-other');
    }


    protected function form()
    {
        $form = new Form(new SystemOther);
        $form->setAction('system-other');

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
            $tools->disableList();
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        $form->hidden('id');
        $form->text('toastr', '系统通知');

        return $form;
    }
}
