<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') ? : 'mysql:host=localhost;dbname=cmsdb',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: 'P@ss1234',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
