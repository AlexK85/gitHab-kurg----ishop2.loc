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