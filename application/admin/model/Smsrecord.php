<?php

namespace app\admin\model;

use think\Model;

class Smsrecord extends Model
{
    // 表名
    protected $name = 'smsrecord';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'state_text'
    ];



    public function getStateList()
    {
        return ["1"=>__('成功'),"0"=>__('失败')];
    }


    public function getStateTextAttr($value, $data)
    {
        $value = $value ? $value : $data['state'];
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function admin()
    {
        return $this->belongsTo('Admin', 'admin_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function recordSms($admin_id,$mobile,$content,$state=1)
    {
        $data['admin_id']=$admin_id;
        $data['mobile']=$mobile;
        $data['content']=$content;
        $data['ctime']=date('Y-m-d H:i:s',time());
        $data['state']=$state;
        return $this->save($data);
    }
}
