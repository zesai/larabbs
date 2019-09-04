<?php

use Spatie\Permission\Models\Role;

return [
    // 页面标题
    'title'   => '角色',

    // 模型单数，用作页面『新建 $single』
    'single'  => '角色',

    // 数据模型，用作数据的 CRUD
    'model'   => Role::class,

    // 设置当前页面的访问权限，通过返回布尔值来控制权限。
    // 返回 True 即通过权限验证，False 则无权访问并从 Menu 中隐藏
    'permission'=> function()
    {
        return Auth::user()->can('manage_users');
    },

    // 字段负责渲染『数据表格』，由无数的『列』组成，
    'columns' => [

        // 列的标示，这是一个最小化『列』信息配置的例子，读取的是模型里对应
        // 的属性的值，如 $model->id
        'id' => [
            // 数据表格里列的名称，默认会使用『列标识』
            'title' => 'ID',
        ],

        'name' => [
            'title'  => '标示',
        ],

        'permissions' => [
            'title'    => '权限',
            'sortable' => false,
            'output' => function ($name, $model) {
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission) {
                    $result[] = $permission->name;
                }
                return empty($result) ? 'N/A' : implode($result, '|');
            },
        ],

        'operation' => [
            'title'  => '管理',
            'output' => function ($value, $model) {
                return $value;
            },
            'sortable' => false,
        ],
    ],

    // 『模型表单』设置项
    'edit_fields' => [
        'name' => [
            'title' => '用户名',
        ],
        'permissions' => [
            'title' => '权限',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
    ],

    // 『数据过滤』设置
    'filters' => [
        'id' => [
            // 过滤表单条目显示名称
            'title' => 'ID',
        ],

        'name' => [
            'title' => '标识',
        ],
    ],

    // 新建和编辑时的表单验证规则
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    // 表单验证错误时定制错误消息
    'messages' => [
        'name.required' => '标识不能为空',
        'name.unique' => '标识已存在',
    ]
];