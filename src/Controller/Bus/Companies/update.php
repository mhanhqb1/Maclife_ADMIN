<?php

use App\Form\UpdateCustomerForm;
use App\Lib\Api;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;

// Load detail
$data = null;
$data = Api::call(Configure::read('API.url_companies_detail'), array());

$pageTitle = __('Cập nhật thông tin website');

// Create breadcrumb
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'name' => $pageTitle,
    ));

// Create Update form 
$form = new UpdateCustomerForm();
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
        'id' => 'logo',
        'label' => __('Logo'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'favicon',
        'label' => __('Favicon'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'facebook',
        'label' => __('LABEL_FACEBOOK'),
    ))
    ->addElement(array(
        'id' => 'twitter',
        'label' => __('LABEL_TWITTER'),
    ))
    ->addElement(array(
        'id' => 'youtube',
        'label' => __('LABEL_YOUTUBE'),
    ))
    ->addElement(array(
        'id' => 'author_name',
        'label' => __('Tên tác giả'),
    ))
    ->addElement(array(
        'id' => 'author_logo',
        'label' => __('Hình ảnh tác giả'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'author_description',
        'label' => __('Mô tả tác giả'),
        'type' => 'textarea',
        'editor' => true
    ))
    ->addElement(array(
        'id' => 'footer_description',
        'label' => __('Mô tả footer'),
        'type' => 'textarea',
        'editor' => true
    ))
    ->addElement(array(
        'id' => 'seo_image',
        'label' => __('LABEL_SEO_IMAGE'),
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'seo_description',
        'label' => __('LABEL_SEO_DESCRIPTION'),
        'type' => 'textarea',
    ))
    ->addElement(array(
        'id' => 'seo_keyword',
        'label' => __('LABEL_SEO_KEYWORD'),
        'type' => 'textarea',
    ))
    ->addElement(array(
        'id' => 'script_header',
        'label' => __('LABEL_SCRIPT_HEADER'),
        'type' => 'textarea',
        'rows' => 7
    ))
    ->addElement(array(
        'id' => 'script_body',
        'label' => __('LABEL_SCRIPT_BODY'),
        'type' => 'textarea',
        'rows' => 7
    ))
    ->addElement(array(
        'id' => 'script_footer',
        'label' => __('LABEL_SCRIPT_FOOTER'),
        'type' => 'textarea',
        'rows' => 7
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
        if (!empty($data['logo']['name'])) {
            $filetype = $data['logo']['type'];
            $filename = $data['logo']['name'];
            $filedata = $data['logo']['tmp_name'];
            $data['logo'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['seo_image']['name'])) {
            $filetype = $data['seo_image']['type'];
            $filename = $data['seo_image']['name'];
            $filedata = $data['seo_image']['tmp_name'];
            $data['seo_image'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['author_logo']['name'])) {
            $filetype = $data['author_logo']['type'];
            $filename = $data['author_logo']['name'];
            $filedata = $data['author_logo']['tmp_name'];
            $data['author_logo'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['favicon']['name'])) {
            $filetype = $data['favicon']['type'];
            $filename = $data['favicon']['name'];
            $filedata = $data['favicon']['tmp_name'];
            $data['favicon'] = new CurlFile($filedata, $filetype, $filename);
        }
        // Call API
        $id = Api::call(Configure::read('API.url_companies_addupdate'), $data);
        if (!empty($id) && !Api::getError()) {            
            $this->Flash->success(__('MESSAGE_SAVE_OK'));
            return $this->redirect("{$this->BASE_URL}/{$this->controller}/update");
        } else {
            return $this->Flash->error(__('MESSAGE_SAVE_NG'));
        }
    }
}