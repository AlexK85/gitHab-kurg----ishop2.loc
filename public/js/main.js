/*Filters*/


$('body').on('change', '.w_sidebar input', function(){
    var checked = $('.w_sidebar input:checked')
        data = '';
    checked.each(function () {
        data += this.value + ',';
    });
    // console.log(data);
    if (data) {
        // alert(data);
        $.ajax({
            url: location.href, 
            data: {filter: data}, // на сервер быдем отправлять переменную filter с значением, которое лежит в переменной data
            type: 'GET',    // метод передачаи
            beforeSend: function () {  // перед отправкой запроса включим ПРЕЛОУДЕР
                $('.preloader').fadeIn(300, function() { // покажем ПРЕЛОУДЕР с помощью fadeIn
                    $('.product-one').hide();  // обратимся к product-one и скроем товары методом 
                });
            },
            success: function(res) {
                //обратимся к ПРЕЛОУДЕР и сделаем задержку пол секунды и скроем ПРЕЛОУДЕР медленно
                $('.preloader').delay(500).fadeOut('slow', function() {
                    // обратимся к product-one в него нужно методом html() подгрудить ответ, который пришёл с сервера и далее всё это дело показать fadeIn()
                    $('.product-one').html(res).fadeIn(); 
                    // обращаемся к объекту location к его методу search из него удаляем filter и дальше что угодно до знака & либо до конца строки 
                    var url = location.search.replace(/filter(.+?)(&|$)/g, '');
                    //
                    var newURL = location.pathname + url + (location.search ? "&" :  "?") + "filter=" + data;
                    newURL = newURL.replace('&&', '&'); // два & заменяем одним
                    newURL = newURL.replace('?&', '?'); // 
                    history.pushState({}, '', newURL); // pushState отправляет newURL - обновляет состояние url, добавляя в него или заменяя его тем, что хранится в newURL
                });  
                // console.log(res);
            },
            error: function(res) {
                alert('Ошибка!');
            }
        });
    } else {
        window.location = location.pathname; //если пользователь снял все галочки, то нужно перезапросить страницу
    }
    
});


/*Filters*/



/*Search*/

    var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            wildcard: '%QUERY',
            url: path + '/search/typeahead?query=%QUERY'
        }
    });

    products.initialize();
    
    
    $("#typeahead").typeahead({
        // hint: false,
        highlight: true
    }, {
        name: 'products',
        display: 'title',
        limit: 10,
        source: products
    });

    
    $('#typeahead').bind('typeahead:select', function(ev, suggestion) {
        // console.log(suggestion);
        window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
    });

/*Search*/




/*Cart*/

    // Первое что нужно сделать - это отследить событие клика по кнопке или ссылке с class="add-to-cart-link"
    // отправить AJAX запрос на сервер

    // Будем делегировать события от какго то корневого элемента, который был есть на странице изначально  
    $('body').on('click', '.add-to-cart-link', function(e){
        e.preventDefault();  // отменим действие по умолчанию
        var id = $(this).data('id'),
            // получим количество 
            // обратимся к quantity и внутри нас интересует input и нужно взять его значение var()
            // Если такой элемент на странице будет и у него есть значение тогда мы возьмём его
            // В противном случае присвоим 1 
            // ПОлучается в переменную qty пойдёт или 1 или то что мвозьмём из input
            qty =  $('.quantity input').val() ? $('.quantity input').val() : 1,
            mod =  $('.available select').val();
        
        // console.log(id, qty, mod);

        // Теперь отправляем запрос на сервер
        $.ajax({
            url: 'cart/add',
            data: {id: id, qty: qty, mod: mod},
            type: 'GET',
            success: function(res) {
                showCart(res);
            },
            error: function() {
                alert('Ошибка! Попробуйте позже');
            }
        });
    });

    // от элемента .modal-body делегируем события клика  для элементов с классом .del-item
    $('#cart .modal-body').on('click', '.del-item', function() {
        var id = $(this).data('id');   // id товара который мы хотим удалить
        $.ajax({
            url: 'cart/delete',
            data: {id: id},    // данные которые мы отправляем
            type: 'GET',      // метод запроса
            success: function(res){
                // А если мы удалили товар из корзины то вызываем метод showCart()
                showCart(res);
            },
            error: function(){
                alert('Error!');
            }
        });
    });


    // Если мы товар нашли и положили его в карзину 
    // тогда мы вернём в ответе карзину, которую необходимо показать
    function showCart(cart) { 
        // console.log(cart);

        // Если то что пришло нам в ответе 
        if ($.trim(cart) == '<h3>Корзина пуста</h3>') {  // обрезаем пробелы по бокам
            // обращаемся к id cart ищем  внутри modal-footer и в нём находим ссылку 
            // так же обращаемся к id cart ищем  внутри.modal-footer .btn-danger
            // обращаемся выше к двум элементам и при помощи .css СКРОЕМ 
            $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');
        } else {
            $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
        }
        // далее нужно обратиться к class="modal-body" в watches.php и вставить в  него таблицу в cart_modal.php 
        // и методом html вставляем ответ
        $('#cart .modal-body').html(cart)
        // теперь МОДАЛЬНОЕ ОКНО НУЖНО ПОКАЗАТЬ
        $('#cart').modal();

        // Если у нас корзина не пуста
        if ($('.cart-sum').text()) {
            // данное условие не сработает
            $('.simpleCart_total').html($('#cart .cart-sum').text());
        } else {
            $('.simpleCart_total').text('Empty Cart');
        }
    }


    // отвечает за вывод МОДАЛЬНОГО ОКНА КОРЗИНЫ
    function getCart() {
        $.ajax({
            url: 'cart/show',
            type: 'GET',
            success: function(res) {
                showCart(res);
            },
            error: function() {
                alert('Ошибка! Попробуйте позже');
            }
        });
    }



    function clearCart() {
        $.ajax({
            url: 'cart/clear',
            type: 'GET',
            success: function(res) {
                showCart(res);
            },
            error: function() {
                alert('Ошибка! Попробуйте позже');
            }
        });
    }

/*Cart*/



$('#currency').change(function() {
    // при наступлении события change (при выборе валюты) - зпросить страницу. Это можно сделать при помощи ОБЪЕКТА window, запросив его
    window.location = 'currency/change?curr=' + $(this).val();
    // console.log($(this).val());
});


// ОТВЕЧАЕТ ЗА ВЫВОД  
$('.available select').on('change', function() {
    var modId = $(this).val(),
    // обращаемся к текущему элементу 
    // найти 'option'
    // отфильтровать по ':selected'
    // и необходимо у данного 'option' взять data атрибут 'title'
    color = $(this).find('option').filter(':selected').data('title'),
    price = $(this).find('option').filter(':selected').data('price');
    basePrice = $('#base-price').data('base');
    // console.log(modId, color, price);

    // Если у нас есть цена. 
     if (price) {
        // тогда обратимся к '#base-price' в view.php 
        $('#base-price').text(symboleLeft + price + symboleRight);
    } else {
        $('#base-price').text(symboleLeft + basePrice + symboleRight);
    }
});