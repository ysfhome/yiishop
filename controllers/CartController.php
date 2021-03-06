<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:46
 */

namespace app\controllers;

use app\models\Cart;
use app\models\Goods;
use Yii;
use yii\filters\AccessControl;


class CartController extends CommonController
{

    //受HTTP请求类型控制的方法
    /*protected $verbs
        = [
            'index' => ['post','get'],
        ];*/

    public function behaviors()
    {
        return array_merge([
            'accessFilter' => [
                'class'  => AccessControl::className(),
                'only'   => ['*'],//不设置或设置为空或"*"表示所有方法都受管制
                'except' => [],//除此之外
                'rules'  => [
                    [
                        'allow'   => false,//不允许访问
                        'actions' => [],// 不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['?'],// ? 表示 guest 未登入的
                    ],
                    [
                        'allow'   => true,//允许访问
                        'actions' => [],//不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['@'],// @ 表示 登入用户
                    ],
                ],
            ],
        ], parent::behaviors());
    }

    //指定页面使用的布局文件
    public $layout = 'layout2';

    /* 购物车页 */
    public function actionIndex()
    {

        $userId = Yii::$app->user->id;
        $cartInfo = Cart::find()->alias('c')
            ->select('g.*,c.*,c.id cart_id,c.goods_num cart_goods_num')
            ->leftJoin(Goods::tableName() . ' g', 'c.goods_id = g.id')
            ->where(['c.username' => $userId])->asArray()->all();

        //总价
        $total = 0;
        foreach ($cartInfo as $k => $v) {
            $total += $v['cart_goods_num'] * $v['goods_price'];
        }


        return $this->render('index', compact('cartInfo', 'total'));

    }

    /**
     * 加入购物车
     */
    public function actionAdd()
    {
        $data = [];
        if (Yii::$app->request->isGet) {
            $goods_id = Yii::$app->request->get('gid');
            if (!empty($goods_id)) {
                $goodsInfo = Goods::findOne($goods_id);
                $goodsNum = 1;
                $data['Cart']['goods_id'] = $goodsInfo->id;
                $data['Cart']['goods_num'] = $goodsNum;
                $data['Cart']['username'] = Yii::$app->user->id;
            }
        }
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $data['Cart']['goods_id'] = $post['gid'];
                $data['Cart']['goods_num'] = $post['goods_num'];
                $data['Cart']['username'] = Yii::$app->user->id;
            }
        }
        //判断购物车中是否已经有当前商品的数据了,有的话数量就累加
        $r = Cart::find()->where([
            'username' => $data['Cart']['username'],
            'goods_id' => $data['Cart']['goods_id'],
        ])->one();
        if (!empty($r)) {
            $data['Cart']['goods_num'] = $data['Cart']['goods_num']
                + $r->goods_num;
            $cart = Cart::findOne($r->id);
        } else {
            $cart = new Cart();
        }

        $cart->load($data);
        $cart->save();
        $this->redirect(['cart/index']);

    }


    /***
     * ajax改变购物车商品数量
     *
     * @return string
     */
    public function actionChangeNum()
    {
        $cart_id = Yii::$app->request->get('cart_id');
        $type = Yii::$app->request->get('type', 'jia');

        if ($type == 'jian') {
            $cart = Cart::findOne($cart_id);
            $cart->goods_num -= 1;
        } else {
            $cart = Cart::findOne($cart_id);
            $cart->goods_num += 1;
        }
        $cart->save();

        $userId = Yii::$app->user->id;
        $cartInfo = Cart::find()->alias('c')
            ->select('g.*,c.*,c.id cart_id,c.goods_num cart_goods_num')
            ->leftJoin(Goods::tableName() . ' g', 'c.goods_id = g.id')
            ->where(['c.username' => $userId])->asArray()->all();

        //总价
        $total = 0;
        foreach ($cartInfo as $k => $v) {
            $total += $v['cart_goods_num'] * $v['goods_price'];
        }
        return json_encode(['total' => sprintf('%.2f', $total)]);

    }


    public function actionDel()
    {
        $cart_id = Yii::$app->request->get('cart_id');

        Cart::deleteAll(['id' => $cart_id]);

        $userId = Yii::$app->user->id;
        $cartInfo = Cart::find()->alias('c')
            ->select('g.*,c.*,c.id cart_id,c.goods_num cart_goods_num')
            ->leftJoin(Goods::tableName() . ' g', 'c.goods_id = g.id')
            ->where(['c.username' => $userId])->asArray()->all();

        //总价
        $total = 0;
        foreach ($cartInfo as $k => $v) {
            $total += $v['cart_goods_num'] * $v['goods_price'];
        }
        return json_encode(['total' => sprintf('%.2f', $total)]);
    }

}