<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Cart extends Backend
{

    /**
     * Cart模型对象
     * @var \app\admin\model\Cart
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Cart');

    }
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
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
