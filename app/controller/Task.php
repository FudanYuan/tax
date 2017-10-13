<?php
/**
 * 任务--控制器
 * author：yzs
 * create：2017.8.15
 */
namespace app\controller;

use app\model\MyException;

class Task extends Common{
    /**
     * 任务列表
     * @return \think\response\View
     */
    public function index(){
        $params = input('get.');
        $task_id = input('get.id');
        $taskStatus = input('get.taskstatus',-1);
        $order = input('get.sortCol');
        $cond_and = [];
        $cond_or = [];
        if($task_id){
            $cond_and['id'] = $task_id;
        }
        if($taskStatus!=-1){
            switch ($taskStatus){
                case '0':
                    $cond_and['taskstatus'] = ['=' , 0];
                    break;
                case '1':
                    $cond_and['taskstatus'] = ['=' , 1];
                    break;
                case '2':
                    $cond_and['taskstatus'] = ['=' , 2];
                    break;
            }
        }
        $tags = D('Tag')->getList(['section' => 4]);
        $list = D('Task')->getTaskList($cond_or,$cond_and,$order);
        for($i=0;$i<count($list);$i++){
            $curtime = time();
            $begintime = $list[$i]['begintime'];
            $pretime = $list[$i]['pretime'];
            $time = $curtime - $begintime;
            $progress = 0;
            if($curtime>($begintime+$pretime)){
                $progress = 100;
            }else if($curtime<$begintime){
                $progress = 0;
            }else{
                if($time>0){
                    $progress =($time/$pretime)*100;
                }else{
                    $progress = 100;
                }
            }
            $list[$i]['pretime'] = round($pretime/3600,1);
            $list[$i]['progress'] =round($progress,2);
            $list[$i]['time'] = round($time/3600,1);
            $list[$i]['count'] = number_format($list[$i]['count']);
        }
        return view('', ['list' => $list, 'tags' => $tags, 'cond' => $params]);
    }
    /**
     * 终止
     */
    public function stop(){
        $ret = ['code' => 1, 'msg' => '成功'];
        $ids = input('get.ids');
        try{
            $res = D('Task')->end_task(['id' => ['in', $ids]]);
        }catch(MyException $e){
            $ret['code'] = 2;
            $ret['msg'] = '终止失败';
        }
        $this->jsonReturn($ret);
    }

    /**
     * 新建
     */
    public function create(){
        $data = input('post.');
        $theme_list = D('Theme')->getT1List([],[],[]);
        for($i = 0; $i < count($theme_list); $i++){
            $cond['b.id'] = ['=',$theme_list[$i]['t1_id']];
            $theme_2_list = D('Theme')->getT2List([],$cond,[]);
            $theme_list[$i]['t1_content'] = $theme_2_list;
        }
        $website_list = D('WebSiteType')->getWebTypeList();
        if(!empty($data)){
            $ret = ['code' => 1, 'msg' => '成功'];
            if(!isset($data['theme'])){
                $data['theme'] = [];
            }
            if(!isset($data['website'])){
                $data['website'] = [];
            }
            // 添加task
            $res_task = D('Task')->addData($data);
            $theme = $data['theme'];
            $website = $data['website'];
            if (!empty($res['errors'])) {
                $ret['code'] = 2;
                $ret['msg'] = '新建失败';
                $ret['errors'] = $res_task['errors'];
                $this->jsonReturn($ret);
            }else {
                $task_id = $res_task['task_id'];
                // 添加task_theme
                for ($i = 0; $i < count($theme); $i++) {
                    $theme_3_data = D('Theme')->getT3ByT2id($theme[$i]);
                    $task_theme_data = [];
                    for ($j = 0; $j < count($theme_3_data); $j++) {
                        $task_theme_data['task_id'] = $task_id;
                        $task_theme_data['theme_3_id'] = $theme_3_data[$j]['t3_id'];
                        D('TaskTheme')->addData($task_theme_data);
                    }
                }
                // 添加task_website
                $task_website_data = [];
                for($i = 0;$i <count($website); $i++){
                    $task_website_data['task_id'] = $task_id;
                    $task_website_data['website_id'] = $website[$i];
                    D('TaskUrl')->addData($task_website_data);
                }
                $this->jsonReturn($ret);
            }
        }

        return view('', ['theme_list' => $theme_list, 'website_list' => $website_list]);
    }

    /**
     * 编辑
     */
    public function edit(){
        $id = input('get.id');
        $data = input('post.');
        $sections = D('Tag')->getSections();
        if(!empty($data)){
            $res = D('Tag')->saveData($id, $data);
            if(!empty($res['errors']))
                return view('', ['errors' => $res['errors'], 'data' => $data, 'sections' => $sections]);
            else{
                $url = PRO_PATH . '/Tag/index';
                return "<script>window.location.href='".$url."'</script>";
            }
        }else{
            $data = D('Tag')->getById($id);
            return view('', ['errors' => [], 'data' => $data, 'sections' => $sections]);
        }
    }

    /**
     * 设置抓取周期
     */
    public function config(){
        return view('', []);
    }
}
?>