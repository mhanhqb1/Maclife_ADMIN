<?php
/* 
 * Production's Config
 */

use Cake\Core\Configure;

define('USE_SUB_DIRECTORY', '');

Configure::write('API.Host', 'http://api.cg4vn.net/public/');
Configure::write('Config.HTTPS', false);

Configure::write('Config.CKeditor', array(
    'basel_dir'=>'/home/hoangan1/img.cg4vn.net/',
    'basel_url'=>'https://img.cg4vn.net/'
));
