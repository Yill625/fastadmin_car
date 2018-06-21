define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'moneyrecord/index',
                    add_url: 'moneyrecord/add',
                    edit_url: 'moneyrecord/edit',
                    del_url: 'moneyrecord/del',
                    multi_url: 'moneyrecord/multi',
                    table: 'moneyrecord',
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
                        {field: 'sign', title: __('Sign'), visible:false, searchList: {"0":__('消费'),'1':__('充值')}},
                        {field: 'sign_text', title: __('Sign'), operate:false},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
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