<?php 
/**
 * 首页--控制器
 * author：yzs
 * create：2017.8.15
 */
namespace app\controller;

use app\model\Data;
use think\Db;

class Index extends Common{
	/**
	 * 首页
	 * @return \think\response\View
	 */
	public function index(){
        //$data = input('get.')
        $data['limit'] = -1;
        $count = [];
        $count['company'] =formatNum(D('Company')->getCompanyNumber());
        $count['theme'] = formatNum(D('Theme')->getT3Number());
        $count['data'] = formatNum(D('DataMonitor')->getDataNumber());
        $count['url'] = formatNum(D('WebSite')->getWebNumber());
        $count['task'] = formatNum(D('Task')->getTaskNumber());

        $compare = [];
        $compare['data'] = formatNum(D('DataMonitor')->getPercentNumber());
        $compare['url'] = formatNum(D('WebSite')->getPercentNumber());
        $compare['theme'] = formatNum(D('Theme')->getPercentNumber());
        $compare['company'] =formatNum(D('Company')->getPercentNumber());

        $task = [];
        $task['completed'] = formatNum(D('Task')->getCompletedNum());
        $task['todeal'] = formatNum(D('Task')->getTodealNum());
        $task['time_consume'] = 5;
        $task['percent'] = formatNum(D('Task')->getPercentCompleted());
        $list = D('Theme')->getbubbleList($data);
        return view('', ['count' => $count, 'task' => $task, 'theme_company'=>$list]);

	}
	/**
	 * 清除缓存
	 */
	public function clearcache(){
		$ret = ['errorcode' => 0, 'msg' => '成功'];
		cache_del(CACHE_NAME);
		$this->jsonReturn($ret);
	}

    /**
     * 获取定时任务---命令（shell定时执行）
     */
    public function regularcommand(){
        $flag = false;
        //定时发布
        $publish = D('Sys')->getPublish();
        mydump($publish);
        if(!empty($publish)){
            foreach($publish as $v){
                $v = json_decode($v, true);
                $sec = $this->getSection($v['section']);
                D($sec)->saveData($v['conid'], ['ispublish' => 1]);
            }
            $flag = true;
        }
        //定时推荐开始
        $recomm = D('Sys')->getRecommend();
        mydump($recomm);
        if(!empty($recomm)){
            foreach($recomm as $v){
                $v = json_decode($v, true);
                $sec = $this->getSection($v['section']);
                D($sec)->saveData($v['conid'], ['recommendtime' => $v['time']]);
            }
            $flag = true;
        }
        //定时推荐结束
        $recommEnd = D('Sys')->getRecommendEnd();
        mydump($recommEnd);
        if(!empty($recommEnd)){
            foreach($recommEnd as $v){
                $v = json_decode($v, true);
                $sec = $this->getSection($v['section']);
                D($sec)->saveData($v['conid'], ['isrecommend' => 0]);
            }
            $flag = true;
        }
        //定时置顶
        $top = D('Sys')->getTop();
        mydump($top);
        if(!empty($top)){
            foreach($top as $v){
                $v = json_decode($v, true);
                D('Banner')->saveData($v['t3_id'], ['status' => 1]);
            }
            $flag = true;
        }
        //定时置顶结束
        $topEnd = D('Sys')->getTopEnd();
        mydump($topEnd);
        if(!empty($topEnd)){
            foreach($topEnd as $v){
                $v = json_decode($v, true);
                D('Banner')->remove(['t3_id' => $v['t3_id']]);
            }
            $flag = true;
        }
        //清空缓存
        if($flag) cache_del('web_index');
    }

    private function getSection($secid){
		switch($secid){
            case 1: //研究方向
                $sec = 'ResearchArea';
                break;
            case 2: //科研成果
                $sec = 'Result';
                break;
            case 3: //团队成员
                $sec = 'Member';
                break;
            case 4: //最新动态
                $sec = 'News';
                break;
		}
		return $sec;
	}
}
?>