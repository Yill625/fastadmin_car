<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Card extends Backend
{

    /**
     * Card模型对象
     * @var \app\admin\model\Card
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Card');

    }

        /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {
                if ($this->dataLimit && $this->dataLimitFieldAutoFill)
                {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $start_time = strtotime($params['start_time']);
                $date = date('Y',$start_time) + $params['service_year'] . '-' . date('m-d H:i:s',$start_time);//N年后日期
                $params['notice_time']=$date;
                try
                {
                    //是否采用模型验证
                    if ($this->modelValidate)
                    {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    if ($result !== false)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($this->model->getError());
                    }
                }
                catch (\think\exception\PDOException $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }


    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds))
        {
            if (!in_array($row[$this->dataLimitField], $adminIds))
            {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {

                $start_time = strtotime($params['start_time']);
                $date = date('Y',$start_time) + $params['service_year'] . '-' . date('m-d H:i:s',$start_time);//N年后日期
                $params['notice_time']=$date;
                try
                {
                    //是否采用模型验证
                    if ($this->modelValidate)
                    {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    if ($result !== false)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($row->getError());
                    }
                }
                catch (\think\exception\PDOException $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function import()
    {
        $file = $this->request->request('file');
        if (!$file)
        {
            $this->error(__('Parameter %s can not be empty', 'file'));
        }
        $filePath = ROOT_PATH . DS . 'public' . DS . $file;
        if (!is_file($filePath))
        {
            $this->error(__('No results were found'));
        }
        try {
            $table = $this->model->getQuery()->getTable();
            $fieldArr = [];
            $database = \think\Config::get('database.database');
            $list = db()->query("SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?", [$table, $database]);

            foreach ($list as $k1 => $v1)
            {
                $fieldArr[$k1] = $v1['COLUMN_NAME'];
            }
            $fieldArr=array_splice($fieldArr,1);
            $file  = fopen($filePath, "r");

            while(! feof($file))
            {
              $data[]=fgetcsv($file);
            }
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $data1[$key][$k]=mb_convert_encoding($v, "UTF-8", "gb2312");
                    }
                }
            }
            $new_data=array_splice($data1,1);
            foreach ($new_data as $key1 => $value1) {
                foreach ($fieldArr as $key2 => $value2) {
                    if ($fieldArr[$key2]=='admin_id') {
                        $b[$fieldArr[$key2]]=$this->auth->id;
                    }else{
                        $b[$fieldArr[$key2]]=$value1[$key2];
                    }

                }

                $a[]=$b;
            }
            $res  = $this->model->saveAll($a);
            if ($res) {
                $this->success();
            }else{
                $this->error('请检查数据格式');
            }
        } catch (Exception $e) {
            $this->error($e->getError());
        }

    }
}
