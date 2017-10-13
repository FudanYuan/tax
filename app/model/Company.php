<?php
/**
 * 公司模型
 * Created by PhpStorm.
 * User: acer-pc
 * Date: 2017/10/3
 * Time: 21:19
 */

namespace app\model;

use think\Model;


class Company extends Model
{
    protected $table = 'tax_company';
    protected $pk = 'id';
    protected $fields = array(
        'id', 'name', 'introduce','C_500','W_500','CL_500','T_100','NEEQ_rank',
        'businessareas','businessmodel','companystate','maincustomer','businessscope',
        'maintrade','mainproduct','valueofexport','brandname','bankaccount','factoryarea',
        'recentlyinspection','legalperson','registryauthority','registeredfund','turnover',
        'companytype','valueofimport','productionpurchase','monthlyoutput','operatingperiod',
        'employeenumber','qualitycontrol','	offerOEM','depositbank','accountholder','establishedtime',
        'companyemail','companypostcode','companyphone','companyfax','companywebsite',
        'administrativeareas','companyareas',
        'status', 'createtime', 'updatetime'
    );
    protected $type = [
        'id' => 'integer',
        'C_500' => 'integer',
        'W_500' => 'integer',
        'CL_500' => 'integer',
        'T_100'=>'integer',
        'NEEQ_rank' => 'integer'
    ];

    public $exportCols = ['id', 'name', 'introduce','C_500','W_500','CL_500','T_100','NEEQ_rank',
        'businessareas','businessmodel','companystate','maincustomer','businessscope',
        'maintrade','mainproduct','valueofexport','brandname','bankaccount','factoryarea',
        'recentlyinspection','legalperson','registryauthority','registeredfund','turnover',
        'companytype','valueofimport','productionpurchase','monthlyoutput','operatingperiod',
        'employeenumber','qualitycontrol','offerOEM','depositbank','accountholder','establishedtime',
        'companyemail','companypostcode','companyphone','companyfax','companywebsite',
        'administrativeareas','companyareas'];

    /**
     * 获取公司数量
     */
    public function getCompanyNumber(){
        $res = $this->field('count(id) as c_count')
            ->where('status <> 2')
            ->select();
        return $res[0]['c_count'];
    }

    /**
     * 获取公司列表--条件
     * @param $cond_or
     * @param $cond_and
     * @param $order
     * @param $pag
     * @return mixed
     */
    public function getCompanyCondition($cond_or=[],$cond_and=[],$order=[],$pag=10){
        if(!isset($cond_and['status'])){
            $cond_and['status'] = ['<>', 2];
        }
        if($pag == -1){
            $pag = $this->getCompanyNumber();
        }
        $res = $this->field('id,name,legalperson,establishedtime,maintrade,
            registeredfund,operatingperiod,companystate,companyareas,companyphone,
            companyfax,companywebsite')
            ->whereor($cond_or)
            ->where($cond_and)
            ->order($order)
            ->paginate($pag);
        return $res;
    }

    /**
     * 获取公司列表--条件
     * @param $cond_or
     * @param $cond_and
     * @param $order
     * @return mixed
     */
    public function getCompanyData($cond_or=[],$cond_and=[],$order=[]){
        if(!isset($cond_and['status'])){
            $cond_and['status'] = ['<>', 2];
        }
        $res = $this->field($this->exportCols)
            ->whereor($cond_or)
            ->where($cond_and)
            ->order($order)
            ->select();
        return $res;
    }

    /**
     * 根据id获取公司信息
     * @param $id
     * @return mixed
     */
    public function getById($id){
        $res = $this->field('id,name,legalperson,establishedtime,maintrade,
            registeredfund,operatingperiod,companystate,companyareas,companyphone,
            companyfax,companywebsite')
            ->where(['id' => $id])
            ->find();
        return $res;
    }
    /**
     * 获取本月公司增加数量
     */
    public function getPercentNumber(){
        $totalNum = $this->field('count(id) as t_num')
            ->where('status <> 2')
            ->select();
        $lastWeekUpdateNum = $this->field('count(id) as lw_num')
            ->where('status <> 2')
            ->wheretime('createtime', 'last week')
            ->select();
        $thisWeekUpdateNum = $this->field('count(id) as tw_num')
            ->where('status <> 2')
            ->wheretime('createtime', 'week')
            ->select();
        $thisYearUpdateNum = $this->field('count(id) as ty_num')
            ->where('status <> 2')
            ->wheretime('createtime', 'year')
            ->select();
        $thisMonthUpdateNum = $this->field('count(id) as tm_num')
            ->where('status <> 2')
            ->wheretime('createtime', 'month')
            ->select();
        $percent = $thisMonthUpdateNum[0]['tm_num'];
        return $percent;
    }

    /**
     * 获取公司500强雷达图
     */
    public function getRadarList(){
        $res = [];
        $c_500 = $this->field('count(id) as c_500')
            ->where('C_500 <> 0 and status <> 2')
            ->select();
        $w_500 = $this->field('count(id) as w_500')
            ->where('W_500 <> 0 and status <> 2')
            ->select();
        $cl_500 = $this->field('count(id) as cl_500')
            ->where('CL_500 <> 0 and status <> 2')
            ->select();
        $t_100 = $this->field('count(id) as t_500')
            ->where('T_500 <> 0 and status <> 2')
            ->select();
        $n_500 = $this->field('count(id) as n_500')
            ->where('NEEQ_rank <> 0 and status <> 2')
            ->select();
        $res[0] = ['item' => '世界企业500强', 'c_count' => $w_500[0]['w_500']];
        $res[1] = ['item' => '中国企业500强', 'c_count' => $c_500[0]['c_500']];
        $res[2] = ['item' => '新三板500强',   'c_count' => $n_500[0]['n_500']];
        $res[3] = ['item' => '中国跨国100强', 'c_count' => $t_100[0]['t_500']];
        $res[4] = ['item' => '中国上市500强', 'c_count' => $cl_500[0]['cl_500']];
        return $res;
    }

    /**
     * 添加公司
     * @param $data
     * @return array
     */
    public function addData($data){
        $ret = [];
        $curtime = time();
        $data['createtime'] = $curtime;
        $errors = $this->filterField($data,false);
        $ret['errors'] = $errors;
        if (empty($errors)) {
            if (!isset($data['status']))
                $data['status'] = 1;
            $this->filterKeys($data);
            $this->save($data);
        }
        return $ret;
    }

    /**
     * 更新公司信息
     * {@inheritDoc}
     * @see \think\Model::save()
     */
    public function saveData($id, $data){
        $ret = [];
        $curtime = time();
        $data['updatetime'] = $curtime;
        $errors = $this->filterField($data,true);
        $ret['errors'] = $errors;
        if (empty($errors)) {
            $this->filterKeys($data);
            $this->save($data, ['id' => $id]);
        }
        return $ret;
    }

    /**
     * 删除操作
     * @param array $cond
     * @return false|int
     * @throws MyException
     */
    public function remove($cond = []){
        $res = $this->save(['status' => 2], $cond);
        if($res === false) throw new MyException('2', '删除失败');
        return $res;
    }


    /**
     * 过滤公司信息
     * @param $data
     * @param $isUpdate
     * @return array
     */
    private function filterField($data,$isUpdate){
        $errors = [];
        if (isset($data['name']) && !$data['name']) {
            $errors['name'] = '企业名不能为空';
        }else if(isset($data['name']) && $data['name']) {
            if(!$isUpdate) {
                $cond_and = [];
                $cond_and['status'] = ['<>', 2];
                $cond_and['name'] = ['=',$data['name']];
                $list = $this->field('*')
                    ->where($cond_and)
                    ->find();
                if (!empty($list)) {
                    $errors['name'] = '企业名字不能重复';
                }
            }
        }
        if (isset($data['legalperson']) && !$data['legalperson']) {
            $errors['legalperson'] = '企业法人不能为空';
        }
        if (isset($data['establishedtime']) && !$data['establishedtime']) {
            $errors['establishedtime'] = '企业注册时间不能为空';
        }
        if (isset($data['maintrade']) && !$data['maintrade']) {
            $errors['maintrade'] = '企业主营范围不能为空';
        }
        if (isset($data['registeredfund']) && !$data['registeredfund']) {
            $errors['registeredfund'] = '企业注册资金不能为空';
        }
        if (isset($data['operatingperiod']) && !$data['operatingperiod']) {
            $errors['operatingperiod'] = '企业经营期限不能为空';
        }
        if (isset($data['companystate']) && !$data['companystate']) {
            $errors['companystate'] = '企业状态不能为空';
        }
        if (isset($data['companyphone']) && !$data['companyphone']) {
            $errors['companyphone'] = '企业电话不能为空';
        }
        if (isset($data['companyfax']) && !$data['companyfax']) {
            $errors['companyfax'] = '企业传真不能为空';
        }
        if (isset($data['companywebsite']) && !$data['companywebsite']) {
            $errors['companywebsite'] = '企业网站不能为空';
        }
        if (isset($data['companyareas']) && !$data['companyareas']) {
            $errors['companyareas'] = '企业地址不能为空';
        }
        return $errors;
    }

    /**
     * 删除非表字段
     * @param $data
     */
    private function filterKeys(&$data){
        $keys = array_keys($data);
        if(isset($data['id'])){
            unset($data['id']);
        }
        foreach ($keys as $key){
            $isin = in_array($key, $this->fields, true);
            if(!$isin){
                unset($data[$key]);
            }
        }
    }
}
