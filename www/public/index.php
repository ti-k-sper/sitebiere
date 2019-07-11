<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/blog', 'Post#all', 'home')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/test', 'Twig#index', 'test')
    ->get('/', 'Shop#index', 'shopIndex')
    ->get('/boutique', 'Shop#all', 'shopAll')
    ->get('/boutique/commande', 'Shop#purchaseOrder', 'shopPurchaseOrder')
    ->get('/inscription', 'Users#subscribe', 'usersSubscribe')
    ->get('/login', 'Users#login', 'usersLogin')
    ->get('/user/logout', 'users#logout', 'userLogout')
    ->get('/user/profile', 'users#profile', 'userProfile')
    ->get('/user/profile/detail-[*:token]-[i:id]', 'users#showDetail', 'detailOrder')
    ->get('/contact', 'Shop#contact', 'shopContact')
    //POSTS URLS
    ->post('/boutique', 'Shop#all', 'post_shopAll')
    ->post('/inscription', 'Users#subscribe', 'post_usersSubscribe')
    ->post('/login', 'Users#login', 'post_usersLogin')
    ->post('/user/updateUser', 'users#updateUser', 'post_updateUser')
    ->post('/user/changePassword', 'users#changePassword', 'post_updateChangePassword')
    ->post('/boutique/commande', 'Shop#purchaseOrder', 'post_PurchaseOrder')
    ->run();
