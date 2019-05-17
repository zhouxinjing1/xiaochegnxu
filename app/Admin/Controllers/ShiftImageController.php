<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

use App\Model\ShiftImage;
use Illuminate\Http\Request;
use App\Tool\ImageTool;
use App\Tool\UploadTool;

class ShiftImageController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('轮播图')
            ->description('小程序Banner切换效果展示')
            ->body($this->grid());
    }


    public function edit($id, Content $content, Request $request)
    {
        return $content
            ->header('编辑')
            ->description('切换图片')
            ->body($this->form()->edit($id));
    }


    public function update(Request $request, $id)
    {

        if($request->get('_editable') == 1){
            $this->updateTitle($request, $id);
        }

        if ($request->get('url') == '_file_del_'){
            return $this->delUrl($id, $request);
        }

        if (isset($request->all()['url'])) {
            $this->addUrl($request, $id);
            admin_toastr('操作成功');
        }

        return redirect('/admin/system/shift-image');
    }

    public function addUrl($request, $id)
    {
        $array = UploadTool::upload_many($request, 'url');

        $si = ShiftImage::find($id);
        $si->url = ImageTool::addJson($si->url, $array);
        $si->save();
    }


    public function delUrl($id, $request)
    {
        $si = ShiftImage::find($id);
        $si->url = ImageTool::deleteJson($si->url, $request->key);
        $si->save();
        return (String)true;
    }


    public function updateTitle($request, $id)
    {
        $si  = ShiftImage::find($id);
        $si->title = $request->value;
        $si->save();
    }


    protected function grid()
    {
        $grid = new Grid(new ShiftImage);

        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableFilter();
        $grid->disableExport();
        $grid->disableRowSelector();

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->id('ID')->sortable();
        $grid->url('图片组')->image(80, 80);
        $grid->type('类型')->display(function ($type){
            switch ($type) {
                case 1:
                    return  '<span class="label label-warning">首页</span>';
                case 2:
                    return  '<span class="label label-danger">卖车</span>';
                case 3:
                    return  '<span class="label label-success">买车</span>';
                case 4:
                    return  '<span class="label label-default">新闻</span>';
            }
        });
        $grid->title('备注')->editable();
        $grid->created_at('创建时间');
        $grid->updated_at('修改时间');

        return $grid;
    }


    protected function form()
    {
        $form = new Form(new ShiftImage());

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        $form->hidden('id');
        $form->multipleImage('url','图片组')->removable()->sortable();
        return $form;
    }
}
