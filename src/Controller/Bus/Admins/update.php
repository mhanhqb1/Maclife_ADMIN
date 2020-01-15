<?php

use App\Form\UpdateAdminForm;
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
    $data = Api::call(Configure::read('API.url_admins_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        return $this->Flash->error(__('MESSAGE_DATA_NOT_EXIST'));
    }
    
    $pageTitle = __('LABEL_UPDATE');
} else {
    // Create new
    $pageTitle = __('LABEL_ADD_NEW');
}

// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/admins');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_ADMIN_LIST'),
    ))
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdateAdminForm();
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
        'id' => 'avatar',
        'label' => __('LABEL_IMAGE'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'name',
        'label' => __('LABEL_NAME'),
        'empty' => ''
    ))
    ->addElement(array(
        'id' => 'email',
        'label' => __('LABEL_EMAIL'),
        'empty' => ''
    ))
    ->addElement(array(
        'id' => 'password',
        'label' => __('LABEL_PASSWORD'),
        'empty' => ''
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
        if (!empty($data['avatar']['name'])) {
            $filetype = $data['avatar']['type'];
            $filename = $data['avatar']['name'];
            $filedata = $data['avatar']['tmp_name'];
            $data['avatar'] = new CurlFile($filedata, $filetype, $filename);
        }
        // Call API
        $id = Api::call(Configure::read('API.url_admins_addupdate'), $data);
        $error = Api::getError();
        if (!empty($id) && !$error) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            if ($isUpdate) {
                return $this->redirect("{$this->BASE_URL}/{$this->controller}/update/{$id}");
            } else {
                return $this->redirect("{$this->BASE_URL}/{$this->controller}");
            }
        } else {
            $message = __('MESSAGE_SAVE_NG');
            if (!empty($error['admin_email'])) {
                $message = 'Email đã tồn tại';
            }
            return $this->Flash->error($message);
        }
    }
}