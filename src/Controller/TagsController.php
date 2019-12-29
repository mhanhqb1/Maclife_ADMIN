<?php

namespace App\Controller;

use Cake\Event\Event;

/**
 * Tags page
 */
class TagsController extends AppController {
    
    /**
     * Tags page
     */
    public function index() {
        include ('Bus/Tags/index.php');
    }
    
    /**
     * Add/update info
     */
    public function update($id = '') {
        include ('Bus/Tags/update.php');
    }
}
