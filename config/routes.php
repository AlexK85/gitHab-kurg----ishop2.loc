<?php

use ishop\Router;

// Все пользовательские правила должны быть выше дефолтных(общих)! Более конкретные правила должны находиться выше чем общие.

/**
 * Конкретные правила
 */

// если в адресе присутствует ^product/
// далее необходим (?P<controller>[a-z0-9-]+)$  
// далее добавим слЭш необязательный /?
Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']); // '^$' - начало и конец строки



/**
 *  Общие правила
 */
// fefault routes 
// Тут будут дефолтные правила для АДМИНСКОЙ части приложения
Router::add('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']); // '^$' - начало и конец строки
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

// Тут будут дефолтные правила для ПОЛЬЗОВАТЕЛЬСКОЙ части приложения
// первым параметром передаём регулярное выражение, а вторым МАССИВ СООТВЕТСТВИЯ
Router::add('^$', ['controller' => 'Main', 'action' => 'index']); // '^$' - начало и конец строки
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
/**
 *  Общие правила
 */



// Route::get('/admin/products/{article}', 'ProductController@index');
// Route::get('/admin/products/delete/{id}', 'ProductController@delete');
// Router::post('/contacts/create', 'ContactController@create');