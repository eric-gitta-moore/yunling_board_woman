<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_yunling_board_woman
{
    public function global_footer()
    {
        global $_G;
        $config = $_G['cache']['plugin']['yunling_board_woman'];
        if ($config['switch'] == 0)
        {
            return null;
        }

        $cdn_url = rtrim(trim($config['cdn_url']),'/');
        $model = trim($config['module']);
        $model_link = trim($config['module_link']);
        $mode = $config['mode'] == 1?"left" : "right";//位置Position
        $width = empty($config['width'])?280:$config['width'];
        $height = empty($config['height'])?250:$config['height'];
        $night_func = $config['night_func'];
        $view_mode = $config['view_mode'];//展现模式Mode
        $hidden = $config['hidden'];
        $timer = $config['timer'];
        $jquery_switch = $config['jQuery_switch'];
        $interaction_tips = $config['interaction_tips'];
        $rand_say_switch = $config['rand_say_switch'];//随机一言

        if ($view_mode == 1)
        {
            $view_mode = 'static';
        }
        elseif ($view_mode == 2)
        {
            $view_mode = 'fixed';
        }
        else
        {
            $view_mode = 'draggable';
        }

        if (!empty($model_link))
        {
            $model_link = explode("\n",$model_link);
            $model = $model_link;
        }
        else
        {
            $model = explode(',',$model);
            foreach ($model as &$item) {
                $item = $cdn_url . '/source/plugin/yunling_board_woman/models/' . $item . '/model.json';
            }
        }

        $l2d_config = array(
            "mode" => $view_mode,
            'model' => $model,
            "hidden" => $hidden == 1 ? true : false,
            "content" => $interaction_tips ? json_decode($interaction_tips, true) : array()
        );

        if (!empty($night_func))
        {
            $l2d_config['night'] = $night_func;
        }

        if ($timer)
        {
            $l2d_config['tips'] = true;
        }


        $loader_json = json_encode($l2d_config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        include template('yunling_board_woman:pub');

        return $return;

    }

}

