<?php
/**
 * 公司--控制器
 * author：yzs
 * create：2017.8.15
 */
namespace app\controller;

use app\model\Data;
use think\Db;

class Company extends Common{

    public $exportCols = ['id', 'name', 'introduce','C_500','W_500','CL_500','T_100','NEEQ_rank',
        'businessareas','businessmodel','companystate','maincustomer','businessscope',
        'maintrade','mainproduct','valueofexport','brandname','bankaccount','factoryarea',
        'recentlyinspection','legalperson','registryauthority','registeredfund','turnover',
        'companytype','valueofimport','productionpurchase','monthlyoutput','operatingperiod',
        'employeenumber','qualitycontrol','offerOEM','depositbank','accountholder','establishedtime',
        'companyemail','companypostcode','companyphone','companyfax','companywebsite',
        'administrativeareas','companyareas'];

    public $colsText = ['序号', '企业名称', '企业介绍','中国500强排名','世界500强排名','中国上市500强排名','跨国100强',
    '新三板排名','主营地区','经营模式','企业状态','主要客户群','经营范围', '主营行业','主营产品','年营出口额',
    '品牌名称','银行账号','factoryarea',
    'recentlyinspection','legalperson','registryauthority','registeredfund','turnover',
    'companytype','valueofimport','productionpurchase','monthlyoutput','operatingperiod',
    'employeenumber','qualitycontrol','offerOEM','depositbank','accountholder','establishedtime',
    'companyemail','companypostcode','companyphone','companyfax','companywebsite',
    'administrativeareas','companyareas'];

    /**
     * 公司首页
     * @return \think\response\View
     */
    public function index(){
        $data = input('get.');
        $c_name = input('get.name', '');
        $tag_id = input('get.tag_id',-1);
        $keywords = input('get.keywords', '');
        $order = input('get.sortCol', '');
        $data['limit'] = -1;
        $tags = D('Tag')->getList(['section' => 5]);
        $cond_or = [];
        $cond_and = [];
        if(!$order){
            $data['sortCol'] = 'id asc';
        }
        if($c_name){
            $cond_and['name'] = ['like','%' . $c_name . '%'];
        }
        if($tag_id!=-1){
            $cond = D('Tag')->getCompanyTag($tag_id);
            $cond_and = array_merge($cond_and,$cond);
        }
        if($keywords){
            $cond_or['name'] = ['like', '%' . $keywords . '%'];
            $cond_or['legalperson'] = ['like', '%' . $keywords . '%'];
            $cond_or['establishedtime'] = ['like', '%' . $keywords . '%'];
            $cond_or['maintrade'] = ['like', '%' . $keywords . '%'];
            $cond_or['registeredfund'] = ['like', '%' . $keywords . '%'];
            $cond_or['operatingperiod'] = ['like', '%' . $keywords . '%'];
            $cond_or['companystate'] = ['like', '%' . $keywords . '%'];
            $cond_or['companyareas'] = ['like', '%' . $keywords . '%'];
            $cond_or['companyphone'] = ['like', '%' . $keywords . '%'];
            $cond_or['companyfax'] = ['like', '%' . $keywords . '%'];
            $cond_or['companywebsite'] = ['like', '%' . $keywords . '%'];
        }
        $list = D('Company')->getCompanyCondition($cond_or,$cond_and,$order);
        for($i = 0;$i<count($list);$i++){
            switch ($tag_id){
                case 0:
                    $cond['C_500']=['<>',0];
                    $list[$i]['tag'] = '中国500强';
                    break;
                case 1:
                    $cond['W_500']=['<>',0];
                    $list[$i]['tag'] = '世界500强';
                    break;
                case 2:
                    $cond['CL_500']=['<>',0];
                    $list[$i]['tag'] = '中国上市500强';
                    break;
                case 3:
                    $cond['T_100']=['<>',0];
                    $list[$i]['tag'] = '跨国100强';
                    break;
                case 4:
                    $list[$i]['tag'] = '';
                    $cond['NEEQ_rank']=['<>',0];
                    break;
                default :
                    $list[$i]['tag'] = '无';
            }
            isset($list[$i]['establishedtime']) && $list[$i]['establishedtime'] = $list[$i]['establishedtime'] ? strtotime($list[$i]['establishedtime']) : 0;
        }
        return view('', ['list' => $list, 'tags' => $tags,'cond' => $data]);
    }

    /**
     * 企业排名
     */
    public function companyRankInfo(){
        $ret = ['errorcode' => 0, 'data' => [], 'msg' => ''];
        //$list = D('Company')->getRadarList();
        $list = [];
        $list[0] = ['item' => '世界企业500强', 'c_count' => 19];
        $list[1] = ['item' => '中国企业500强', 'c_count' => 30];
        $list[2] = ['item' => '新三板500强', 'c_count' => 19];
        $list[3] = ['item' => '中国跨国100强', 'c_count' => 90];
        $list[4] = ['item' => '中国上市500强', 'c_count' => 109];

        $ret['data'] = $list;
        $this->jsonReturn($ret);
    }

    /**
     * 企业增加
     */
    public function create(){
        $data = input('post.');
        $tags = D('Tag')->getList(['section' => 5]);
        if(!empty($data)){
            $res = D('Company')->addData($data);
            if (!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data,'tags'=>$tags]);
            else {
                $url = PRO_PATH . '/Company/index';
                return "<script>window.location.href='" . $url . "'</script>";
            }
        }else{
            return view('',['tags'=>$tags]);
        }
    }

    /**
     * 企业编辑
     */
    public function edit(){
        $id = input('get.id');
        $data = input('post.');
        $form = D('Company')->getById($id);
        $tags = D('Tag')->getList(['section' => 5]);
        if (!empty($data)) {
            $res = D('Company')->saveData($id, $data);
            if (!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data,'tags'=>$tags]);
            else {
                $url = PRO_PATH . '/Company/index';
                return "<script>window.location.href='" . $url . "'</script>";
            }
        } else {
            return view('', ['errors' => [], 'data' => $form,'tags'=>$tags]);
        }
    }
    /**
     * 批量删除
     */
    public function remove(){
        $ret = ['code' => 1, 'msg' => '成功'];
        $ids = input('get.ids');
        try {
            $res = D('Company')->remove(['id' => ['in', $ids]]);
        } catch (MyException $e) {
            $ret['code'] = 2;
            $ret['msg'] = '删除失败';
        }
        $this->jsonReturn($ret);
    }

    /**
     * 企业详细信息
     */
    public function info(){
        $id = input('get.id');
        $list = D('Company')->getById($id);
        $model = D('DataMonitor')->getTable($id);
        isset($list['establishedtime']) && $list['establishedtime'] = $list['establishedtime'] ? strtotime($list['establishedtime']) : 0;
        return view('',['info'=>$list,'model'=>$model]);
    }

    /**
     * 数据导出
     */
    public function export(){
        $list = D('Company')->getCompanyData();
        $data = [];
        // 匹配键值
        array_push($data, $this->exportCols);
        foreach ($list as $value) {
            $temp = [];
            foreach ($this->exportCols as $key => $k){
                array_push($temp, $value[$k]);
            }
            array_push($data, $temp);
        }
        D('Excel')->export($data, 'company.xls');
    }


    /**
     * 数据导入
     */
    public function import(){
        $params = input('post.');
        $file = input('post.file', '');
        $ret = ['code' => 1, 'msg' => '导入成功'];
        $res = D('Excel')->import($params);
        if(!empty($res['errors'])){
            $ret['errors'] = $res['errors'];
            $ret['code'] = 2;
            $ret['msg'] = '导入失败';
        }
        else{
            $keys = $res['keys'];
            $data = $res['data'];
            $colsDic = array_combine($this->colsText, $this->exportCols);
            $count = 0;
            foreach ($data as $item){
                $count++;
                $res = D('Company')->addData($item);
                if (!empty($res['errors'])){
                    $ret['errors'] = $res['errors'];
                    $ret['code'] = 3;
                    $ret['msg'] = '导入失败';
                    break;
                }
            }
            $ret['count'] = $count;
        }
        $this->jsonReturn($ret);
    }
}
?>