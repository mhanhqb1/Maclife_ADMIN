<?php
use App\Lib\Api;
use Cake\Core\Configure;

$this->doGeneralAction();
$pageSize = Configure::read('Config.PageSize');

// Create breadcrumb
$pageTitle = __('LABEL_POST_LIST');
$this->Breadcrumb->setTitle($pageTitle)
        ->add(array(
            'name' => $pageTitle,
        ));

// Create search form
$dataSearch = array(
    'limit' => $pageSize
);
$this->SearchForm
        ->setAttribute('type', 'get')
        ->setData($dataSearch)
        ->addElement(array(
            'id' => 'name',
            'label' => __('LABEL_NAME')
        ))
        ->addElement(array(
            'id' => 'limit',
            'label' => __('LABEL_LIMIT'),
            'options' => Configure::read('Config.searchPageSize'),
        ))
        ->addElement(array(
            'type' => 'submit',
            'value' => __('LABEL_SEARCH'),
            'class' => 'btn btn-primary',
        ));

$param = $this->getParams(array(
    'limit' => $pageSize
));

$result = Api::call(Configure::read('API.url_posts_list'), $param);
$total = !empty($result['total']) ? $result['total'] : 0;
$data = !empty($result['data']) ? $result['data'] : array();

// Show data
$this->SimpleTable
        ->setDataset($data)
        ->addColumn(array(
            'id' => 'item',
            'name' => 'items[]',
            'type' => 'checkbox',
            'value' => '{id}',
            'width' => 20,
        ))
        ->addColumn(array(
            'id' => 'image',
            'title' => __('LABEL_IMAGE'),
            'type' => 'image',
            'src' => '{image}',
            'width' => 110,
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'name',
            'title' => __('LABEL_NAME'),
            'type' => 'link',
            'href' => $this->BASE_URL . '/' . $this->controller . '/update/{id}',
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'cate_name',
            'title' => __('LABEL_CATE'),
            'empty' => ''
        ))
        ->addColumn(array(
            'id' => 'total_view',
            'title' => __('Tổng view'),
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'total_like',
            'title' => __('Tổng Like'),
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'total_dislike',
            'title' => __('Tổng Dislike'),
            'empty' => 0
        ))
        ->addColumn(array(
            'id' => 'is_premium',
            'title' => __('Premium'),
            'rules' => array(
                0 => 'No',
                1 => 'Yes'
            )
        ))
        ->addColumn(array(
            'id' => 'created',
            'type' => 'dateonly',
            'title' => __('LABEL_CREATED'),
            'width' => 100,
            'empty' => '',
        ))
        ->addButton(array(
            'type' => 'submit',
            'value' => __('LABEL_ADD_NEW'),
            'class' => 'btn btn-success btn-addnew',
        ))
        ->addButton(array(
            'type' => 'submit',
            'value' => __('LABEL_DELETE'),
            'class' => 'btn btn-danger btn-disable',
        ));

$this->set('pageTitle', $pageTitle);
$this->set('total', $total);
$this->set('param', $param);
$this->set('limit', $param['limit']);
$this->set('data', $data);
