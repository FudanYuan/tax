<?php
/**
 * 网站库--控制器
 * author：yzs
 * create：2017.8.15
 */
namespace app\controller;

class WebSite extends Common
{
    public $exportCols = ['id','name','type_id', 'type_name','url'];
    public $colsText = ['序号', '网站名称', '网站类型id','网站类型名字','网址'];
    /**
     * 网站列表
     * @return \think\response\View
     */
    public function index(){
        $params = input('get.');
        $keywords = input('get.keywords', '');
        $type_id = input('get.type_id', -1);
        $order = input('get.sortCol', '');
        if(!$order){
            $params['sortCol'] = 'a.id asc';
        }
        $cond_or = [];
        $cond_and = [];
        if($type_id != -1){
            $cond_and['a.id'] = $type_id;
        }
        if($keywords){
            $cond_or['a.name'] = ['like', '%' . $keywords . '%'];
            $cond_or['a.url'] = ['like', '%' . $keywords . '%'];
            $cond_or['b.name'] = ['like', '%' . $keywords . '%'];
        }
        $type_list = D('WebSiteType')->getWebTypeList();
        $list = D('WebSite')->getWebList($cond_or, $cond_and,$order);

        return view('', ['list' => $list, 'typeList' => $type_list, 'type_id' => $type_id, 'cond' => $params]);
    }

    /**
     * 批量删除
     */
    public function remove()
    {
        $ret = ['code' => 1, 'msg' => '成功'];
        $ids = input('get.ids');
        try {
            $res = D('WebSite')->remove(['id' => ['in', $ids]]);
        } catch (MyException $e) {
            $ret['code'] = 2;
            $ret['msg'] = '删除失败';
        }
        $this->jsonReturn($ret);
    }

    /**
     * 增加网站
     */
    public function create_url(){
        $data = input('post.');
        $typeList = D('WebSiteType')->getWebTypeList();
        if (!empty($data)) {
            $res = D('WebSite')->addData($data);
            if (!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data,'typeList'=>$typeList]);
            else {
                $url = PRO_PATH . '/WebSite/index';
                return "<script>window.location.href='" . $url . "'</script>";
            }
        }else{
            return view('',['typeList'=>$typeList]);
        }
    }
    /**
     * 增加网站类型
     */
    public function create_type(){
        $data = input('post.');
        if (!empty($data)) {
            $res = D('WebSiteType')->addData($data);
            if (!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data]);
            else {
                $url = PRO_PATH . '/WebSite/index';
                return "<script>window.location.href='" . $url . "'</script>";
            }
        }else{
            return view('', ['errors' => [], 'data' => $data]);
        }
    }
    /**
     * 编辑网站
     */
    public function edit(){
        $id = input('get.id');
        $data = input('post.');
        $form = D('WebSite')->getById($id);
        $typeList = D('WebSiteType')->getWebTypeList();
        if (!empty($data)) {
            $res = D('WebSite')->saveData($id, $data);
            if (!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data,'typeList'=>$typeList]);
            else {
                $url = PRO_PATH . '/WebSite/index';
                return "<script>window.location.href='" . $url . "'</script>";
            }
        } else {
            return view('', ['errors' => [], 'data' => $form,'typeList'=>$typeList]);
        }
    }

    /**
     * 网站类型饼形图
     */
    public function typePie(){
        $data = input('get.');
        if(isset($data['theme'])){
            $list = D('DataMonitor')->getThemePie($data);
        }else{
            $list = D('WebSite')->getTypePie($data);
        }
        $ret = ['errorcode' => 0, 'data' => [], 'msg' => ''];
        $ret['data'] = $list;
        $this->jsonReturn($ret);
    }

    /**
     * 网站导出
     */
    public function export(){
        $cond_or = [];
        $cond_and = [];
        $order = [];
        $list = D('WebSite')->getWebList([],[],[],-1);
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
        D('Excel')->export($data, 'website.xls');
    }
    /**
     * 主题导入
     */
    public function import(){
        $params = input('post.');
        //$file = input('post.file', '');
        $ret[0] = ['code' => 1, 'msg' => '导入成功'];
        $res = D('Excel')->import($params);
        if(!empty($res['errors'])){
            $ret[0]['errors'] = $res['errors'];
            $ret[0]['code'] = 2;
            $ret[0]['msg'] = '导入失败';
        }else{
            $keys = $res['keys'];
            $data = $res['data'];
            $colsDic = array_combine($this->colsText, $this->exportCols);
            $count = 0;
            $i=0;
            foreach ($data as $item){
                $count++;
                $i++;
                $res = D('Website')->import_theme($item);
                if (!empty($res['errors'])){
                    $ret[$i]['errors'] = $res['errors'];
                    $ret[$i]['code'] = 3;
                    $ret[$i]['msg'] = '导入失败';
                    $count--;
                }
            }
            $ret['count'] = $count;
        }
        $this->jsonReturn($ret);
    }
}

?>
