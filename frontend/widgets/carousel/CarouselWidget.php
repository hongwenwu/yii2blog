<?php
/**
 * Created by PhpStorm.
 *
 * describe:  轮播
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 21:35
 */

namespace frontend\widgets\carousel;

use \yii\helpers\Url;
use yii\base\Widget;

class CarouselWidget extends Widget
{

    public $items = [];

    public function init()
    {
        parent::init();

        if(empty($this->items)){
            $this->items = [
                [
                    'label'=>'轮播',
                    'active' => 'active',
                    'url'=>Url::to('/static/images/carousel/b_0.jpg'),
                    'image_url'=>'/static/images/carousel/b_0.jpg',
                    'html'=>'轮播'
                ],
                [
                    'label'=>'轮播',
                    'active' => '',
                    'url'=>Url::to('/static/images/carousel/b_1.jpg'),
                    'image_url'=>'/static/images/carousel/b_1.jpg',
                    'html'=>'轮播'
                ],
                [
                    'label'=>'轮播',
                    'active' => '',
                    'url'=>Url::to('/static/images/carousel/b_2.jpg'),
                    'image_url'=>'/static/images/carousel/b_2.jpg',
                    'html'=>'轮播'
                ]
            ];
        }
    }

    public function run()
    {
        parent::run();

        $data['items'] = $this->items;
        return $this->render("index", ['data' =>$data ]);
    }

}