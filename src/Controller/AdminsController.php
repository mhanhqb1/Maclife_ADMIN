<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Admins page
 */
class AdminsController extends AppController {
    
    /**
     * Admins page
     */
    public function updateprofile() {
        include ('Bus/Admins/updateprofile.php');
    }
    
    /**
     * List page
     */
    public function index() {
        include ('Bus/Admins/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Admins/update.php');
    }
}
