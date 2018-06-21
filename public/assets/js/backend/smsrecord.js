define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'smsrecord/index',
                    add_url: 'smsrecord/add',
                    edit_url: 'smsrecord/edit',
                    del_url: 'smsrecord/del',
                    multi_url: 'smsrecord/multi',
                    table: 'smsrecord',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {field: 'admin.nickname', title: __('Admin_id')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'state', title: __('State'), visible:false, searchList: {"1":__('成功'),"0":__('失败')}},
                        {field: 'state_text', title: __('State'), operate:false},
                        {field: 'content', title: __('Content')},
                        {field: 'ctime', title: __('Ctime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});