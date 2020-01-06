<?php

use App\Form\UpdatePostForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = null;
$isUpdate = false;
if (!empty($id)) {
    // Edit
    $param['id'] = $id;
    $isUpdate = true;
    $data = Api::call(Configure::read('API.url_users_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        return $this->Flash->error(__('MESSAGE_DATA_NOT_EXIST'));
    }
    
    $pageTitle = __('Update user');
} else {
    // Create new
    $pageTitle = __('LABEL_ADD_NEW');
}

// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/users');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_USER_LIST'),
    ))
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdatePostForm();
$this->UpdateForm->reset()
    ->setModel($form)
    ->setData($data)
    ->setAttribute('autocomplete', 'off')
    ->addElement(array(
        'id' => 'id',
        'type' => 'hidden',
        'label' => __('id'),
    ))
    ->addElement(array(
        'id' => 'name',
        'label' => __('LABEL_NAME'),
        'required' => true,
    ))
    ->addElement(array(
        'id' => 'email',
        'label' => __('Email')
    ))
    ->addElement(array(
        'id' => 'new_pass',
        'label' => __('Password')
    ))
    ->addElement(array(
        'id' => 'is_donate',
        'label' => __('Donate'),
        'options' => array(
            0 => 'No',
            1 => 'Yes'
        )
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('LABEL_SAVE'),
        'class' => 'btn btn-primary',
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('LABEL_CANCEL'),
        'class' => 'btn',
        'onclick' => "return back();"
    ));

// Valdate and update
if ($this->request->is('post')) {
    // Trim data
    $data = $this->request->data();
    foreach ($data as $key => $value) {
        if (is_scalar($value)) {
            $data[$key] = trim($value);
        }
    }
    // Validation
    if ($form->validate($data)) {
        // Call API
        if (!empty($data['new_pass'])) {
            $data['password'] = $data['new_pass'];
        }
        $id = Api::call(Configure::read('API.url_users_addupdate'), $data);
        if (!empty($id) && !Api::getError()) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            if ($isUpdate) {
                return $this->redirect("{$this->BASE_URL}/{$this->controller}/update/{$id}");
            } else {
                return $this->redirect("{$this->BASE_URL}/{$this->controller}");
            }
            
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}