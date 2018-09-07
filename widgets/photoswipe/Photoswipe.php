<?php

namespace app\widgets\photoswipe;


use yii\base\Widget;
use yii\helpers\Html;


class Photoswipe extends \yii\base\Widget
{
    public $images = [];

    public $selector = '.photoswipe';

    public $clientOptions = [
        'bgOpacity' => 0.9,
        'spacing' => 0.9,
        'closeEl' => true,
        'captionEl' => true,
        'fullscreenEl' => false,
        'zoomEl' => true,
        'shareEl' => false,
        'counterEl' => true,
        'arrowEl' => true,
        'preloaderEl' => true,
    ];

    public function run()
    {
        return $this->render('photoswipe');
    }
}
