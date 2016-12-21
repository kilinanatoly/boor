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
<script type="text/javascript" src="//cdn.perezvoni.com/widget/js/przv.js?przv_code=21848-31233553fc55-59a2338c-2fb31233553fc55-fc55-233553f" ></script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'lGz0p0m4Uw';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter41590214 = new Ya.Metrika({
                    id:41590214,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<!-- /Yandex.Metrika counter -->


<script type="text/javascript">(function(w,doc) {
        if (!w.__utlWdgt ) {
            w.__utlWdgt = true;
            var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
            s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
            var h=d[g]('body')[0];
            h.appendChild(s);
        }})(window,document);
</script>
<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="fixed-right" data-text-color="#000000" data-share-shape="round" data-sn-ids="fb.vk.tw.ok." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1612217" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>