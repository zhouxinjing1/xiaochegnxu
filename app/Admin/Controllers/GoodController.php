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
            ->header('车辆信息')
            ->description('展示')
            ->body($this->grid());
    }


    public function show($id, Content $content)
    {
        return $content
            ->header('展示')
            ->description('详情展示')
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

    protected function form()
    {
        $form = new Form(new Good());

        return $form;
    }

    protected function grid()
    {
        $grid = new Grid(new Good);

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('user.name', '用户名');
            $filter->like('city', '车辆所在地');
            $filter->gt('money', '保留价');
            $filter->equal('type', '发布方式')->select(['0' => '免费发布', '1' => '拍卖']);
            $filter->equal('reco', '是否推荐')->radio([
                ''   => '全部',
                1    => '推荐',
                0    => '不推荐',
            ]);
        });


        $grid->model()->where('status', '=', 1);
        $grid->model()->orderBy('created_at', 'desc');

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
        });

        $grid->disableCreateButton();

        $grid->id('ID')->sortable();
        $grid->user()->name('用户名');
        $grid->brand('车辆品牌及类型');
        $grid->city('车辆所在地方')->label('default');
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];
        $grid->type('发布方式')->label('success');
        $grid->money('保留价')->display(function ($value){
            if (empty($value)) {
                return '无';
            }
            return $value;
        })->label('danger');
        $grid->bond('保证金')->display(function ($value){
            if (empty($value)) {
                return '无';
            }
            return $value;
        })->label('warning');
        $grid->reco('是否推荐')->switch($states);
        $grid->orders('排序')->editable('text');
        $grid->created_at('创建时间');
        return $grid;
    }


    protected function detail($id)
    {
        $show = new Show(Good::findOrFail($id));

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });;

        $show->brand('车辆品牌及类型');
        $show->displacement('汽车排量');
        $show->transmission('变速箱类型')->as(function ($value) {
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
        });;
        $show->year('年限');
        $show->city('车辆所在地方');
        $show->change_number('过户次数');
        $show->overview('车主自述');
        $show->user_id('用户id');
        $show->type('发布类型');
        $show->money('保留价');
        $show->bond('保证金');
        $show->price('是否设置保留价')->as(function ($value){
            switch ($value) {
                case 1:
                    return '是';
                case 0:
                    return '否';
            }
        });
        $show->reco('是否推荐')->as(function ($value){
            switch ($value) {
                case 1:
                    return '是';
                case 0:
                    return '否';
            }
        });
        $show->created_at('创建时间');


        $show->car_is('车辆正面')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_right('车辆右面')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_left('车辆左面')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_after('车辆后面')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_engine('车辆发动机')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_backup('车辆后备')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_central('车辆中控台')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_front('车辆前排')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->car_back('车辆后排')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_license('行驶证')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_tire('轮胎')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_headlight('大灯')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_report('报告')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_left('车辆左后侧')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        $show->choose_right('车辆右后侧')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' style='height: 150px;width: 150px;'/>";
        });
        return $show;
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
