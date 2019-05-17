<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

use App\Model\News;
use Illuminate\Http\Request;
use App\Tool\UploadTool;

class NewController extends Controller
{
    use HasResourceActions;


    public function index(Content $content)
    {
        return $content
            ->header('新闻资讯')
            ->description('相关信息')
            ->body($this->grid());
    }


    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }


    public function edit($id, Content $content)
    {
        return $content
            ->header('新闻资讯')
            ->description('相关信息')
            ->body($this->form()->edit($id));
    }


    public function create(Content $content)
    {
        return $content
            ->header('新闻资讯')
            ->description('相关信息')
            ->body($this->form());
    }

    public function store(Request $request)
    {
        $new = new News();
        $new->title   = $request->title;
        $new->summary = $request->summary;
        $new->contents = $request->contents;

        if (!empty($request->image)) {
            $new->image   = UploadTool::upload_once($request, 'image');
        }
        $new->save();

        admin_toastr('操作成功');
        return  redirect('/admin/new');
    }

    public function update($id, Request $request)
    {
        $new = News::find($id);
        $new->title   = $request->title;
        $new->summary = $request->summary;
        $new->contents= $request->contents;

        if (!empty($request->image)) {
            $new->image   = UploadTool::upload_once($request, 'image');
        }
        $new->save();

        admin_toastr('操作成功');
        return  redirect('/admin/new');
    }


    protected function grid()
    {
        $grid = new Grid( new News());
        $grid->disableExport();
        $grid->disableFilter();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->id('ID');
        $grid->title('标题');
        $grid->image('图片')->image(60, 60);
        $grid->summary('简介')->limit(20);
        $grid->created_at('创建时间')->sortable();
        return $grid;
    }


    protected function form()
    {
        $form = new Form(new News);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
        });

        $form->text('title', '标题')->required();
        $form->image('image','图片')->required();
        $form->textarea('summary', '简介')->rows(3);
        $form->simditor('contents','内容');

        return $form;
    }
}
