<?php

namespace samuelelonghin\grid\columns;


use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;


class ActionColumn4 extends ActionColumn
{
    const TEMPLATE_U = '{update}';
    const TEMPLATE_D = '{delete}';
    const TEMPLATE_V = '{view}';
    const TEMPLATE_R = '{remove}';

    const TEMPLATE_U_D = self::TEMPLATE_U . self::TEMPLATE_D;
    const TEMPLATE_U_R = self::TEMPLATE_U . self::TEMPLATE_R;
    const TEMPLATE_V_R = self::TEMPLATE_V . self::TEMPLATE_R;

    public $header = false;

    public $buttonOptions = [
        'class' => 'm-auto btn btn-pil',
    ];

    public $template = self::TEMPLATE_U;

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('update', 'edit');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
        $this->initDefaultButton('remove', 'times', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to remove this item?'),
            'data-method' => 'post',
        ]);
    }

    public function init()
    {
        parent::init();
        $this->template = '<div class="text-center">' . $this->template . ' </div>';
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
