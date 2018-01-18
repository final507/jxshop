<?php
        return array(
        //配置
            'URL_MODEL'=>2,
            'DEFAULT_MODEL'=>'HOME',
            'MODULE_ALLOW_LIST'=>array('Home','Admin'),
            'TMPL_PARSE_STRING' =>array(
                    '__PUBLIC_ADMIN__'=>'/Public/Admin',
                    '__PUBLIC_HOME__'=>'/Public/Home'
            ),
            'DB_TYPE'               =>  'mysql',     // 数据库类型
            'DB_HOST'               =>  '127.0.0.1', // 服务器地址
            'DB_NAME'               =>  'jx_shop',          // 数据库名
            'DB_USER'               =>  'root',      // 用户名
            'DB_PWD'                =>  '993838',          // 密码
            'DB_PORT'               =>  '3306',        // 端口
            'DB_PREFIX'             =>  'jx_',    // 数据库表前缀
            'SHOW_PAGE_TRACE'       =>   TRUE

        );