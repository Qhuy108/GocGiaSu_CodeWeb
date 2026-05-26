<?php
define('BASE_URL',       'http://localhost:8080');
define('UPLOAD_PATH',    __DIR__ . '/../public/assets/uploads/');
define('UPLOAD_URL',     BASE_URL . '/public/assets/uploads/');
define('ITEMS_PER_PAGE', 6);
define('MAX_FILE_SIZE',  5 * 1024 * 1024);
define('ALLOWED_TYPES',  ['image/jpeg', 'image/png', 'image/jpg']);
