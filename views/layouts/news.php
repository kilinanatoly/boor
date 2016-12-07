<div class="container news main_news">
    <div class="row">
        <div class="col-xs-12">
            <h2>Новости</h2> <span class="all_news"><a href="/articles">Все новости</a></span>
            <div class="clearfix"></div>
            <?php
            $news = \app\models\Articles::find()->orderBy('id DESC')->limit(4)->all();
            if ($news){
                foreach ($news as $key => $value) {
                    echo '
                    <div class="news_item inline_block">
                        <header>
                            <p>'.$value->name.'</p>
                        </header>
                        <footer>
                            <p>'.$value->text.'</p>
                        </footer>
                    </div>
                    ';
                }
            }
            ?>
        </div>
    </div>
</div>