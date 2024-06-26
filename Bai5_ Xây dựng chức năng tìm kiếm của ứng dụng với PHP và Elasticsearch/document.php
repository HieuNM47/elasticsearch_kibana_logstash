<?php

use Elasticsearch\Client;
require 'vendor/autoload.php';

$config = require './config/elastic.php';
$hosts = $config['elasticsearch']['hosts'];

//Tạo đối tượng Client
$client = \Elasticsearch\ClientBuilder::create()
    ->setHosts($hosts)
    ->build();

if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['keywords']) && isset($_POST['id'])) {

    $params = [
        'index' => 'article',
        'type'  => '_doc',
        'id'    => $_POST['id'],
        'body' => [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'keywords' => explode(',', $_POST['keywords'])
        ]
    ];
    $response = $client->index($params);
    echo 'Đã tạo, cập nhật ID ' . $_POST['id'];
}
?>

<div class="card m-4">
    <div class="card-header display-4 text-danger">Tạo / cập nhật Document</div>
    <div class="card-body">
        <form method="post" class="form">
            <div class="form-group">
                <label>ID</label>
                <input name="id" class="form-control">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input name="title" class="form-control">
            </div>
            <div class="form-group">
                <label>Content</label> <br>
                <textarea name="content" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Keywords</label>
                <input name="keywords" class="form-control">
            </div>
            <input type="submit" value="Update" class="btn btn-danger">
        </form>
    </div>
</div>