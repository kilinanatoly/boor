<style>
    .tt-menu{
        padding:10px 20px;
    }
    .tt-menu h3{
        margin:0;
    }
</style>
<div class="block2 ">
    <form class="search1" action="/site/search" method="get">
        <?php
        use kartik\typeahead\Typeahead;
        use yii\helpers\Url;
        $template = '<a href="'.Url::to(['/search']) . '?search={{query}}'.'">{{value}}</a>';
        echo Typeahead::widget([
            'name' => 'search',
            'options' => [
                'placeholder' => 'Поиск оборудования...',
                ],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'templates' => [
                        'header' => '<h3 class="league-name">Категории</h3>',
                        'suggestion' => new \yii\web\JsExpression("Handlebars.compile('{$template}')")
                    ],
                    'remote' => [
                        'url' => Url::to(['ajax/cats-list']) . '?q=%QUERY',
                        'wildcard' => '%QUERY'
                    ]
                ],
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'templates' => [
                        'header' => '<h3 class="league-name">Продукты</h3>',
                        'suggestion' => new \yii\web\JsExpression("Handlebars.compile('{$template}')")
                    ],
                    'remote' => [
                        'url' => Url::to(['ajax/products-list']) . '?q=%QUERY',
                        'wildcard' => '%QUERY'
                    ]
                ]
            ]
        ]);
        ?>
        <button style="display: none" type="submit">Найти</button>
    </form>
</div>
