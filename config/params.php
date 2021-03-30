<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    "DreamFactoryHeaderKey" => 'X-DreamFactory-API-Key',
    "DreamFactoryContextURL" => 'http://10.5.5.27:8081/api/v2/crud-api/table/records/', 
    "DreamFactoryContextURLProcedures" => 'http://10.5.5.27:8081/api/v2/crud-api/procedure/',
    "DreamFactoryContextURLCrawler" => 'http://10.5.5.27:8081/api/v2/crawler/',
    "DreamFactoryContextURLFiles" => getenv('API_URL_FILES') ? getenv('API_URL_FILES') : 'http://10.5.5.27:8081/api/v2/files/',
    "DreamFactoryHeaderPass" => '7c174ae2f835c0b7fd9e63f65358cdb6958cd4b9a705d652e220b30f007fdb14',
    "FILE_UPLOAD_SURAT_RASMI" => getenv('FILE-UPLOAD-SURAT-RASMI') ? getenv('FILE-UPLOAD-SURAT-RASMI') : 'uploads/',
    "FILE_UPLOAD_LAPORAN_POLIS" => getenv('FILE-UPLOAD-LAPORAN-POLIS') ? getenv('FILE-UPLOAD-LAPORAN-POLIS') : 'uploads/',
    "FILE_TRASH_SURAT_RASMI" => getenv('FILE_TRASH_SURAT_RASMI') ? getenv('FILE_TRASH_SURAT_RASMI') : '/uploads/trash/permohonan/surat_rasmi/',
    "FILE_TRASH_LAPORAN_POLIS" => getenv('FILE_TRASH_LAPORAN_POLIS') ? getenv('FILE_TRASH_LAPORAN_POLIS') : '/uploads/trash/permohonan/laporan_polis/',
    "FILE_TRASH_BLOCK_REQUEST_SURAT_RASMI" => getenv('FILE_TRASH_BLOCK_REQUEST_SURAT_RASMI') ? getenv('FILE_TRASH_BLOCK_REQUEST_SURAT_RASMI') : '/uploads/trash/block-request/surat_rasmi/',
    "FILE_TRASH_BLOCK_REQUEST_LAPORAN_POLIS" => getenv('FILE_TRASH_BLOCK_REQUEST_LAPORAN_POLIS') ? getenv('FILE_TRASH_BLOCK_REQUEST_LAPORAN_POLIS') : '/uploads/trash/block-request/laporan_polis/',
    "FILE_DOWNLOAD" => getenv('FILE_DOWNLOAD') ? getenv('FILE_DOWNLOAD') : 'http://10.5.5.27:8080/',
    "MASTER_DATA_JSON" => getenv('MASTER_DATA_JSON') ? getenv('MASTER_DATA_JSON') : \Yii::$app->baseUrl,
    
];
