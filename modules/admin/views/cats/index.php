<?php
use yii\widgets\Pjax;


$this->params['home'] = [
    'label' => 'Категории',
    'url' => '/admin/cats/index',
];
if (empty($bread)) {
    $this->params['breadcrumbs'][] = 'Главные категории';
}
foreach ($bread as $key => $value) {
    if ($key < count($bread) - 1) {
        $this->params['breadcrumbs'][] = ['label' => $value['name'], 'url' => ['/admin/cats/index?parent_id=' . $value['id']]];
    } else {
        $this->params['breadcrumbs'][] = $value['name'];
    }
}
$session = Yii::$app->session;
echo $session->getFlash('add');
?>
<div class="cats">
    <?php
    echo $cats;
    ?>
</div>
<?= $this->render('cats_form', [
    'model' => $model
]) ?>
