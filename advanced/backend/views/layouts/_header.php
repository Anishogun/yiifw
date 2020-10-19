<?php
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;


NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-expand-lg navbar-dark bg-dark shadow-sm',
    ],
]);

$menuItems = [
    ['label' => 'Create', 'url' => ['/video/create']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    // $menuItems[] = '<li>'
    //     . Html::beginForm(['/site/logout'], 'post')
    //     . Html::submitButton(
    //         'Logout (' . Yii::$app->user->identity->username . ')',
    //         ['class' => 'btn btn-link logout']
    //     )
    //     . Html::endForm()
    //     . '</li>';
    $menuItems[] = [
        'label' => 'Logout('.Yii::$app->user->identity->username.')', 
        'url' => ['/site/logout'],
        'linkOptions' =>[
            'data-method' => 'post'
        ]
    ];
}
echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav ml-auto'],
    'items' => $menuItems,
]);
NavBar::end();