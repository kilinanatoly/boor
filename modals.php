<?php
$name = '';
if (isset($product)) {
    $name = $product->name;
}
$functions = new \app\models\Functions();
?>
<!--<p><a href="#" data-toggle="modal" data-target="#myModal1" class="btn btn-default btn1">Узнать цену</a></p>-->

<!-- Узнать цену -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center" id="myModalLabel">Узнать цену на товар: <?= $name ?></h3>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="title" value="Запрос цены на товар <?= $name ?>">
                    <input type="hidden" name="product" value="<?= $functions->getproducturl($product->id) ?>">

                    <div class="form-group">
                        <label for="">Как к Вам обращаться?*</label>
                        <input class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="">Номер телефона или email*</label>
                        <input class="form-control" name="name" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Узнать цену</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Проонсультироваться со специалистом -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center" id="myModalLabel">Проконсультируйтесь со специалистом!</h3>
            </div>
            <div class="modal-body">
                    <form>
                        <input type="hidden" name="title" value="Консультация со специалистом по товару <?= $name ?>">
                        <input type="hidden" name="product" value="<?= $functions->getproducturl($product->id) ?>">

                        <div class="form-group">
                            <label for="">Как к Вам обращаться?*</label>
                            <input class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="">Номер телефона или email*</label>
                            <input class="form-control" name="tel" required>
                        </div>

                        <div class="form-group">
                            <label for="">Сообщение</label>
                            <textarea rows="8" class="form-control" name="text"></textarea>
                        </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Свяжитесь со мной!</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Запрос коммерческого предложения -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center" id="myModalLabel">Запросить коммерческое предложение на
                    продукт: <?= $name ?></h3>
            </div>
            <div class="modal-body">
                    <form>
                        <input type="hidden" name="title" value="Запрос коммерческого предложения на товар <?= $name ?>">
                        <input type="hidden" name="product" value="<?= $functions->getproducturl($product->id) ?>">

                        <div class="form-group">
                            <label for="">Как к Вам обращаться?*</label>
                            <input class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="">Номер телефона или email*</label>
                            <input class="form-control" name="tel" required>
                        </div>

                        <div class="form-group">
                            <label for="">Сообщение</label>
                            <textarea rows="8" class="form-control" name="text"></textarea>
                        </div>
             </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Запросить</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Обратный звонок -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <img class="zvonok" src="/images/site_images/zvonok.png" alt="Обратный звонок">
                <h3 class="modal-title text-center" id="myModalLabel">Хотите, мы Вам перезвоним?</h3>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="">Как к Вам обращаться?*</label>
                        <input class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="">Номер телефона*</label>
                        <input class="form-control" name="tel" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Позвоните мне!</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Оставить заявку -->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center" id="myModalLabel">Оставьте заявку</h3>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="">Как к Вам обращаться?*</label>
                        <input class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="">Номер телефона или email*</label>
                        <input class="form-control" name="tel" required>
                    </div>

                    <div class="form-group">
                        <label for="">Сообщение*</label>
                        <textarea class="form-control" name="text" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Оставить заявку</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Оставить заявку спецпредложение -->
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title text-center" id="myModalLabel">Оставьте заявку на консультацию по продукту: <span></span></h3>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="product_id" class="product_id">
                    <div class="form-group">
                        <label for="">Как к Вам обращаться?*</label>
                        <input class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="">Номер телефона или email*</label>
                        <input class="form-control" name="tel" required>
                    </div>

                    <div class="form-group">
                        <label for="">Сообщение</label>
                        <textarea class="form-control" name="text" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit" data-loading-text="Подождите...">Оставить заявку</button>
            </div>
            </form>

        </div>
    </div>
</div>