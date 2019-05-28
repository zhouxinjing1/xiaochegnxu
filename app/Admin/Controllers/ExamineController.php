<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

use App\Model\Good;
use Illuminate\Http\Request;
use App\Tool\UploadTool;
use App\Admin\Extensions\CheckRow;

class ExamineController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('车辆信息')
            ->description('审核')
            ->body($this->grid());
    }


    public function edit($id, Content $content)
    {
        return $content
            ->header('车辆信息')
            ->description('审核修改')
            ->body($this->form()->edit($id));
    }


    protected function grid()
    {
        $grid = new Grid(new Good);

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('user.name', '用户名');
            $filter->equal('type', '发布方式')->select(['0' => '免费发布', '1' => '拍卖']);
            $filter->equal('year', '年限')->year();
        });

        $grid->model()->where('status', '=', 0);
        $grid->model()->orderBy('created_at', 'desc');

        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->append(new CheckRow($actions->getKey()));
        });

        $grid->id('ID')->sortable();
        $grid->user()->name('用户名');
        $grid->brand('车辆品牌及类型');
        $grid->displacement('汽车排量')->display(function ($value){
            return $value .' L';
        })->label('default');
        $grid->transmission('变速箱类型')->display(function ($value){
            switch ($value) {
                case 1:
                    return '手动变速箱';
                case 2:
                    return '自动变速箱';
                case 3:
                    return '手自一体';
                case 4:
                    return '无极变速箱';
                case 5:
                    return 'DSG变速箱';
                case 6:
                    return '序列变速箱';
            }
        })->label('default');
        $grid->mileage('行驶里程')->display(function ($value){
            return $value . ' 公里';
        })->label('default');
        $grid->change_number('过户次数')->display(function ($value){
            return $value . ' 次';
        })->label('default');
        $grid->year('年限')->display(function ($value){
            return $value . ' 年';
        })->label('default');
        $grid->city('车辆所在地方')->label('default');
        $grid->type('发布方式')->label('default');
        $grid->created_at('创建时间');
        return $grid;
    }


    public function update($id, Request $request)
    {
        $good = Good::find($id);
        $good->brand = $request->brand;
        $good->displacement = $request->displacement;
        $good->transmission = $request->transmission;
        $good->year = $request->year;
        $good->mileage = $request->mileage;
        $good->city = $request->city;
        $good->change_number = $request->change_number;
        $good->overview = $request->overview;

        if (!empty($request->car_is)) {
            $good->car_is   = UploadTool::upload_once($request, 'car_is');
        }
        if (!empty($request->car_right)) {
            $good->car_right   = UploadTool::upload_once($request, 'car_right');
        }
        if (!empty($request->car_left)) {
            $good->car_left   = UploadTool::upload_once($request, 'car_left');
        }
        if (!empty($request->car_after)) {
            $good->car_after   = UploadTool::upload_once($request, 'car_after');
        }
        if (!empty($request->car_engine)) {
            $good->car_engine   = UploadTool::upload_once($request, 'car_engine');
        }
        if (!empty($request->car_backup)) {
            $good->car_backup   = UploadTool::upload_once($request, 'car_backup');
        }
        if (!empty($request->car_central)) {
            $good->car_central   = UploadTool::upload_once($request, 'car_central');
        }
        if (!empty($request->car_front)) {
            $good->car_front   = UploadTool::upload_once($request, 'car_front');
        }
        if (!empty($request->car_back)) {
            $good->car_back   = UploadTool::upload_once($request, 'car_back');
        }
        if (!empty($request->choose_license)) {
            $good->choose_license   = UploadTool::upload_once($request, 'choose_license');
        }
        if (!empty($request->choose_tire)) {
            $good->choose_tire   = UploadTool::upload_once($request, 'choose_tire');
        }
        if (!empty($request->choose_headlight)) {
            $good->choose_headlight   = UploadTool::upload_once($request, 'choose_headlight');
        }
        if (!empty($request->choose_report)) {
            $good->choose_report   = UploadTool::upload_once($request, 'choose_report');
        }
        if (!empty($request->choose_right)) {
            $good->choose_right   = UploadTool::upload_once($request, 'choose_right');
        }
        if (!empty($request->choose_left)) {
            $good->choose_left   = UploadTool::upload_once($request, 'choose_left');
        }

        $good->save();

        admin_toastr('操作成功');
        return  redirect('/admin/examine');
    }


    protected function form()
    {
        $form = new Form(new Good);
        $form->disableEditingCheck();
        $form->disableCreatingCheck();
        $form->disableViewCheck();
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->hidden('id');
        $form->text('brand', '车辆品牌及类型')->required();
        $form->select('transmission','变数箱类型')->options([
            1 => '手动变速箱',
            2 => '自动变速箱',
            3 => '手自一体',
            4 => '无极变速箱',
            5 => 'DSG变速箱',
            6 => '序列变速箱'
        ])->required();
        $form->datetime('year','年限')->format('YYYY')->required();
        $form->text('city','车辆所在地')->required();
        $form->number('mileage', '行驶里程')->required();
        $form->number('displacement', '汽车排量')->required();
        $form->number('change_number', '过户次数')->required();
        $form->textarea('overview','车主自述')->rows(3)->required();

        $form->image('car_is','车辆正面')->required();
        $form->image('car_right','车辆右面')->required();
        $form->image('car_left','车辆左面')->required();
        $form->image('car_after','车辆后面')->required();
        $form->image('car_engine','车辆发动机')->required();
        $form->image('car_backup','车辆后备')->required();
        $form->image('car_central','车辆中控台')->required();
        $form->image('car_front','车辆前排')->required();
        $form->image('car_back','车辆后排')->required();


        $form->image('choose_license','行驶证');
        $form->image('choose_tire','轮胎');
        $form->image('choose_headlight','大灯');
        $form->image('choose_report','报告');
        $form->image('choose_right','车辆右后侧');
        $form->image('choose_left','车辆左后侧');

        return $form;
    }

    public function adopt($id)
    {
        return  Good::where('id', $id)->update(['status' => 1]);
    }
}
