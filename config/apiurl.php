<?php

/**
 * API's Url
 */
use Cake\Core\Configure;

Configure::write('API.Timeout', 60);
Configure::write('API.secretKey', 'lyonabeauty');
Configure::write('API.rewriteUrl', array());

Configure::write('API.url_admins_login', 'admins/login');
Configure::write('API.url_admins_updateprofile', 'admins/updateprofile');

Configure::write('API.url_companies_addupdate', 'companies/addupdate');
Configure::write('API.url_companies_detail', 'companies/detail');

Configure::write('API.url_posts_list', 'posts/list');
Configure::write('API.url_posts_addupdate', 'posts/addupdate');
Configure::write('API.url_posts_detail', 'posts/detail');
Configure::write('API.url_posts_all', 'posts/all');

Configure::write('API.url_cates_list', 'cates/list');
Configure::write('API.url_cates_addupdate', 'cates/addupdate');
Configure::write('API.url_cates_detail', 'cates/detail');
Configure::write('API.url_cates_all', 'cates/all');

Configure::write('API.url_tags_list', 'tags/list');
Configure::write('API.url_tags_addupdate', 'tags/addupdate');
Configure::write('API.url_tags_detail', 'tags/detail');

Configure::write('API.url_reports_general', 'reports/general');

Configure::write('API.url_pages_addupdate', 'pages/addupdate');
Configure::write('API.url_pages_detail', 'pages/detail');

Configure::write('API.url_tags_all', 'tags/all');

Configure::write('API.url_users_list', 'users/list');
Configure::write('API.url_users_addupdate', 'users/addupdate');
Configure::write('API.url_users_detail', 'users/detail');