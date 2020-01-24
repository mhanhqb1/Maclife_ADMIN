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
    $data = Api::call(Configure::read('API.url_posts_detail'), $param);
    $this->Common->handleException(Api::getError());
    if (empty($data)) {
        return $this->Flash->error(__('MESSAGE_DATA_NOT_EXIST'));
    }
    
    $pageTitle = __('LABEL_POST_UPDATE');
} else {
    // Create new
    $pageTitle = __('LABEL_ADD_NEW');
}

$cates = $this->Common->arrayKeyValue(Api::call(Configure::read('API.url_cates_all'), array(
    'type' => 2
)), 'id', 'name');
$tags = $this->Common->arrayKeyValue(Api::call(Configure::read('API.url_tags_all'), array()), 'id', 'name');

// Create breadcrumb
$listPageUrl = h($this->BASE_URL . '/posts');
$this->Breadcrumb->setTitle($pageTitle)
    ->add(array(
        'link' => $listPageUrl,
        'name' => __('LABEL_POST_LIST'),
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
        'label' => __('id')
    ))
    ->addElement(array(
        'id' => 'disable',
        'type' => 'hidden',
        'label' => __('disable'),
    ))
    ->addElement(array(
        'id' => 'name',
        'label' => __('LABEL_NAME'),
        'required' => true,
    ))
    ->addElement(array(
        'id' => 'cate_id',
        'label' => __('LABEL_CATE'),
        'options' => $cates,
        'empty' => '-',
        'multiple' => 'multiple'
    ))
    ->addElement(array(
        'id' => 'image',
        'label' => __('LABEL_IMAGE').'(402x378)',
        'image' => true,
        'type' => 'file'
    ))
    ->addElement(array(
        'id' => 'description',
        'label' => __('LABEL_DESCRIPTION'),
        'type' => 'textarea',
        'empty' => ''
    ))
    ->addElement(array(
        'id' => 'detail',
        'label' => __('LABEL_CONTENT'),
        'type' => 'editor'
    ))
    ->addElement(array(
        'id' => 'is_premium',
        'label' => __('Premium'),
        'options' => array(
            0 => 'No',
            1 => 'Yes'
        )
    ))
    ->addElement(array(
        'id' => 'premium_content',
        'label' => __('Premium Content'),
        'type' => 'editor'
    ))
    ->addElement(array(
        'id' => 'tag',
        'label' => __('Tags'),
        'options' => $tags,
        'empty' => '',
        'multiple' => 'multiple'
    ))
    ->addElement(array(
        'id' => 'seo_keyword',
        'label' => __('LABEL_SEO_KEYWORD'),
        'empty' => ''
    ))
    ->addElement(array(
        'id' => 'seo_description',
        'label' => __('LABEL_SEO_DESCRIPTION'),
        'type' => 'textarea',
        'empty' => ''
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('LABEL_SAVE'),
        'class' => 'btn btn-primary btn-post-publish',
    ))
    ->addElement(array(
        'type' => 'submit',
        'value' => __('Save as draft'),
        'class' => 'btn btn-info btn-save-draft',
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
        if (!empty($data['image']['name'])) {
            $filetype = $data['image']['type'];
            $filename = $data['image']['name'];
            $filedata = $data['image']['tmp_name'];
            $data['image'] = new CurlFile($filedata, $filetype, $filename);
        }
        if (!empty($data['tag'])) {
            $data['tags'] = implode(',', $data['tag']);
        }
        if (!empty($data['cate_id'])) {
            $data['cate_id'] = implode(',', $data['cate_id']);
        }
        // Call API
        $id = Api::call(Configure::read('API.url_posts_addupdate'), $data);
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
            if (!empty($error['post_name'])) {
                $message = 'Bài viết đã tồn tại';
            }
            return $this->Flash->error($message);
        }
    }
}