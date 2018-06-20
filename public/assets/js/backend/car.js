define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'car/index',
                    add_url: 'car/add',
                    edit_url: 'car/edit',
                    del_url: 'car/del',
                    multi_url: 'car/multi',
                    import_url: 'car/import',
                    table: 'car',
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
                        {field: 'id', title: __('Id')},
                        {field: 'limit_day', title: __('Iimit_day')},
                        {field: 'name', title: __('Name')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'car_number', title: __('Car_number'),operate: 'LIKE %...%'},
                        {field: 'car_set_number', title: __('Car_set_number')},
                        {field: 'card_number', title: __('Card_number')},
                        {field: 'service_day', title: __('Service_day')},
                        {field: 'start_time', title: __('Start_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'end_time', title: __('End_time'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'join_type', title: __('Join_type')},
                        {field: 'ip', title: __('Ip')},
                        {field: 'factory', title: __('Factory')},
                        {field: 'join_ways', title: __('Join_ways')},
                        {field: 'info', title: __('Info')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

                        // 获取选中项
            $(document).on("click", ".btn-selected", function () {
                Backend.api.open('car/sendMessage/' + $(this).data('id'), __('Detail'));
            });
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