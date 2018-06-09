define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'cart/index',
                    add_url: 'cart/add',
                    edit_url: 'cart/edit',
                    del_url: 'cart/del',
                    multi_url: 'cart/multi',
                    table: 'cart',
                    import_url: 'cart/import',
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
                        {field: 'ctime', title: __('Ctime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'join_type', title: __('Join_type'),operate:false},
                        {field: 'ip', title: __('Ip'),operate:false},
                        {field: 'port', title: __('Port'),operate:false},
                        {field: 'submit_type', title: __('Submit_type'),operate:false},
                        {field: 'type', title: __('Type'),operate:false},
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