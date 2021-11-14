$('#currency').change(function() {
    // при наступлении события change (при выборе валюты) - зпросить страницу. Это можно сделать при помощи ОБЪЕКТА window, запросив его
    window.location = 'currency/change?curr=' + $(this).val();
    // console.log($(this).val());
});