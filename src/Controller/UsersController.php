<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Users page
 */
class UsersController extends AppController {
    
    /**
     * Users page
     */
    public function index() {
        include ('Bus/Users/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Users/update.php');
    }
}
