define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'expirecar/index',
                    edit_url: 'expirecar/edit',
                    del_url: 'expirecar/del',
                    multi_url: 'expirecar/multi',
                    table: 'expirecar',
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
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'service', title: __('Service')},
                        {field: 'id_number', title: __('Id_number')},
                        {field: 'terminal', title: __('Terminal')},
                        {field: 'number', title: __('Number')},
                        {field: 'vin', title: __('Vin')},
                        {field: 'cart_nember', title: __('Cart_nember')},
                        {field: 'last_pay_time', title: __('Last_pay_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'join_type', title: __('Join_type'),operate:false},
                        {field: 'ip', title: __('Ip'),operate:false},
                        {field: 'port', title: __('Port'),operate:false},
                        {field: 'type', title: __('Type'),formatter: Table.api.formatter.status, searchList: {'已续费': '已续费', '未续费': '未续费'}, style: 'min-width:100px;'},
                        {field: 'info', title: __('Info'),operate:false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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