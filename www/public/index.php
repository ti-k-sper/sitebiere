<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/', 'Beer#home', 'shop')
    ->get('/articles', 'Beer#all', 'articles')
    ->get('/signup', 'Users#signUp', 'signup')
    ->post('/signup', 'Users#signUp', 'post_signup')
    ->post('/signin', 'Users#signIn', 'post_signin')
    ->get('/signin', 'Users#signIn', 'signin')
    ->get('/signin/[*:mail]-[*:token]', 'Users#signIn', 'mail_verif')
    ->get('/disconnect', 'Users#disconnect', 'disconnect')
    ->get('/purchase_order', 'Orders#purchaseOrder', 'purchase_order')
    ->post('/purchase_order', 'Orders#purchaseOrder', 'post_purchase_order')
    ->get('/confirm_order/[i:id]-[i:id_user]', 'Orders#confirmOrder', 'confirm_order')
    ->get('/profil', 'Users#showProfil', 'profil')
    ->post('/profil', 'Users#showProfil', 'post_profil')
    ->get('/blog', 'Post#all', 'blog')
    ->get('/posts', 'Post#all', 'posts')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/test', 'Twig#index', 'test')
    ->run();
