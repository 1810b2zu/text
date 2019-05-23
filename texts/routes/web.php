<?php
route::prefix('admin')->group(function(){
    route::any('index','Admin\\IndexController@index');
    route::any('/subscribe','Admin\\SubscribeController@index');
    route::any('/subscribe/add','Admin\\SubscribeController@add');

});
?>