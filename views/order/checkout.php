

    <!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= CONTENT ========================================= -->

    <section id="checkout-page">
        <div class="container">
            <div class="col-xs-12 no-margin">
                <section id="shipping-address" style="margin-bottom:100px;margin-top:-10px">
                    <h2 class="border h1">收货地址</h2>
                    <a href="#" id="createlink">新建联系人</a>
                    <span style="color: red;">
                        <?php if(Yii::$app->session->hasFlash('info')){
                            foreach(Yii::$app->session->getFlash('info') as $k=>$v)
                                echo $v;
                        }
                        ?>
                    </span>
                    <form>
                        <?php foreach ($addressInfo as $k=>$v): ?>
                        <div class="row field-row" style="margin-top:10px">
                            <div class="col-xs-12">
                                <input  class="le-radio big" value="<?= $v->id ?>" type="radio" name="address" />
                                <a class="simple-link bold" href="JavaScript:;"><?= $v->address ?></a>
                            </div>
                        </div><!-- /.field-row -->
                            <a href="javascript:;" style="color: red;" data-value="<?= $v->id ?>" class="delAddress111">删除</a>

                        <?php endforeach;?>

                    </form>
                </section><!-- /#shipping-address -->

                <div class="billing-address" style="display:none;">
                    <h2 class="border h1">新建联系人</h2>
                    <form action="<?= \yii\helpers\Url::to(['address/add']) ?>" method="post">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-6">
                                <label>收件人*</label>
                                <input name="Address[shou_name]"  class="le-input" >
                            </div>
                        </div><!-- /.field-row -->


                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-6">
                                <label>地址*</label>
                                <input name="Address[address1]" class="le-input" data-placeholder="例如：北京市朝阳区" >
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <label>&nbsp;</label>
                                <input name="Address[address2]" class="le-input" data-placeholder="例如：酒仙桥北路" >
                            </div>
                        </div><!-- /.field-row -->

                        <div class="row field-row">
                            <div class="col-xs-12 col-sm-4">
                                <label>邮编</label>
                                <input name="Address[zipcode]" class="le-input"  >
                            </div>

                            <div class="col-xs-12 col-sm-4">
                                <label>联系电话*</label>
                                <input name="Address[phone]" class="le-input" >
                            </div>
                        </div><!-- /.field-row -->

                        <div class="place-order-button">
                            <button type="submit" class="le-button small">新建</button>
                        </div><!-- /.place-order-button -->
                    </form>
                </div><!-- /.billing-address -->


                <section id="your-order">
                    <h2 class="border h1">您的订单详情</h2>
                    <form>

                        <?php foreach($orderGoodsInfo as $k=>$v): ?>
                        <div class="row no-margin order-item">
                            <div class="col-xs-12 col-sm-2 no-margin">
                                <a href="#" class="qty"><?= $v['goods_num'] ?> x</a>
                            </div>

                            <div class="col-xs-12 col-sm-4 ">
                                <div class="title"><a href="#"><img style="width: 100px;height:100px;" src="<?= 'http://'.$v['goods_img'] ?> " /></a></div>
                            </div>

                            <div class="col-xs-12 col-sm-4 ">
                                <div class="title"><a href="#"><?= $v['goods_name'] ?> </a></div>
                            </div>
                            <div class="col-xs-12 col-sm-2 no-margin">
                                <div class="price">￥<?= $v['goods_price'] ?></div>
                            </div>
                        </div><!-- /.order-item -->
                        <?php endforeach;?>

                    </form>
                </section><!-- /#your-order -->

                <div id="total-area" class="row no-margin">
                    <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
                        <div id="subtotal-holder">
                            <ul class="tabled-data inverse-bold no-border">
                                <li>
                                    <label>商品总价</label>
                                    <div style="width:100%;text-align:right" class="value ">￥<?= $orderAmount ?></div>
                                </li>
                                <li>
                                    <label>选择快递</label>
                                    <div style="width:100%;text-align:right" class="value">
                                        <div class="radio-group">
                                            <?php foreach ($expressInfo as $k=>$v): ?>
                                            <input class="le-radio" type="radio" name="express" value="<?= $k ?>"> <div class="radio-label bold"><?= $v[0] ?><span class="bold"> ￥<?= $v[1] ?></span></div><br>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </li>
                            </ul><!-- /.tabled-data -->

                            <ul id="total-field" class="tabled-data inverse-bold ">
                                <li>
                                    <label>订单总额</label>
                                    <div id="orderAmount" class="value" style="width:100%;text-align:right">￥<?= $orderAmount ?></div>
                                </li>
                            </ul><!-- /.tabled-data -->

                        </div><!-- /#subtotal-holder -->
                    </div><!-- /.col -->
                </div><!-- /#total-area -->

                <div id="payment-method-options">
                    <form>
                        <div class="payment-method-option">
                            <input class="le-radio" type="radio" name="group2" value="Direct">
                            <div class="radio-label bold ">微信支付</div>
                        </div><!-- /.payment-method-option -->

                        <div class="payment-method-option">
                            <input class="le-radio" type="radio" name="group2" value="cheque">
                            <div class="radio-label bold ">支付宝支付</div>
                        </div><!-- /.payment-method-option -->

                        <div class="payment-method-option">
                            <input class="le-radio" type="radio" name="group2" value="paypal">
                            <div class="radio-label bold ">网银支付</div>
                        </div><!-- /.payment-method-option -->
                    </form>
                </div><!-- /#payment-method-options -->

                <div class="place-order-button">
                    <button class="le-button big">确认订单</button>
                </div><!-- /.place-order-button -->

            </div><!-- /.col -->
        </div><!-- /.container -->
    </section><!-- /#checkout-page -->
    <!-- ========================================= CONTENT : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->
<script type="text/javascript">
    $('input[name=express]').click(function(){
        var express = $(this).val();
        var order_id = <?= $_GET['order_id'] ?>;
        $.getJSON("<?= \yii\helpers\Url::to(['order/change-amount'])?>",{express:express,order_id:order_id},function(data){
            $('#orderAmount').text('￥'+data.amount)
        })
    })
    $('.delAddress111').click(function(){
        if(confirm('确定删除吗?')){
            var delAddress_id = $(this).data('value');
            $.getJSON("<?= \yii\helpers\Url::to(['address/del'])?>",{delAddress_id:delAddress_id})
            $(this).prev().remove();
            $(this).remove();
        }
    })
</script>