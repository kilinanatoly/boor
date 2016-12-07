<?php
//Вытаскиваем главные категории лдля выпадающего меню
$cats = \app\models\Cats::find()->where('parent_id=0')->all();
?>
<div class="container main-footer1">
    <div class="footer_menu">
        <div class="row">
            <div class="col-xs-12">
                <ul class="main-footer1__list">
                    <?php
                    if ($cats){
                        $functions = new \app\models\Functions();
                        foreach ($cats as $key=>$value) {
                            echo '<li><a  href="'.$functions->get_url($value->id).'" >'.$value->name.'</a>';
                            if ($value->childs){
                                echo '<ul class="main-footer1__list2">';
                                foreach ($value->childs as $key2 => $value2) {
                                    echo '<li><a  href="'.$functions->get_url($value2->id).'" >'.$value2->name.'</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
