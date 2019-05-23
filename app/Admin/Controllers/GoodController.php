<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

use App\Model\Good;
use Illuminate\Http\Request;


class GoodController extends Controller
{
    use HasResourceActions;


    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }


    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    public function update($id, Request $request)
    {
        if (isset($request->reco)) {
            $this->setReco($id, $request->reco);
            return response()->json(['message' => '操作成功']);
        }

        if($request->get('_editable') == 1){
            $this->setOrder($request, $id);
        }

    }


    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }


    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }


    protected function grid()
    {
        $grid = new Grid(new Good);
        $grid->disableCreateButton();

        $grid->id('ID')->sortable();
        $grid->user()->name('用户名');
        $grid->brand('test1');
        $grid->displacement('test2')->display(function ($value){
            return $value .' L';
        })->label('default');
        $grid->transmission('test5')->label('default');
        $grid->mileage('test5')->display(function ($value){
            return $value . ' 公里';
        })->label('default');
        $grid->change_number('test5')->display(function ($value){
            return $value . ' 次';
        })->label('default');
        $grid->year('test3')->display(function ($value){
            return $value . ' 年';
        })->label('default');
        $grid->city('test4')->label('default');
        $grid->orders('排序')->editable('text');
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];
        $grid->reco()->switch($states);
        $grid->created_at('创建时间');
        return $grid;
    }


    protected function detail($id)
    {
        $show = new Show(Good::findOrFail($id));

        $show->id('ID');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }


    protected function form()
    {
        $form = new Form(new Good);

        $form->display('id', 'ID');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }


    public function setReco($id, $reco)
    {
        $reco = $reco == 'on' ? 1 : 0;
        $good = Good::find($id);
        $good->reco = $reco;
        $good->save();
    }

    public function setOrder($request, $id)
    {
        $good  = Good::find($id);
        $good->orders = $request->value;
        $good->save();
    }

}
