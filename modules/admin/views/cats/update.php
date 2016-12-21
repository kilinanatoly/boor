<?php
use yii\widgets\Pjax;

$this->params['home'] = [
    'label'=>'Категории',
    'url'=>'/admin/cats/index',
];


foreach ($bread as $key=>$value) {
    if ($key<count($bread)-1){
        $this->params['breadcrumbs'][] = ['label' => $value['name'], 'url' => ['/admin/cats/index?parent_id='.$value['id']]];
    }else{
        $this->params['breadcrumbs'][] = 'Редактирование категории ' .$value['name'];
    }
}
$session = Yii::$app->session;
echo $session->getFlash('add');
?>

<?=$this->render('cats_update_form',[
    'model'=>$model
])?>
