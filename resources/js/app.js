let select;

if(select = document.querySelector('select[name=storage]')) {

    //Навешиваем слушатель на выбор склада в формах создания и обновления заказа
    select.addEventListener('change', () => changeStorage(select.options[select.selectedIndex].value));

}

// функция которая вызывает другие функции :)
let changeStorage = async (storageId) => {

    let products = await getProducts(storageId); // Получаем продукты по id склада
    renderProducts(products);                    // Рендрим поля

}

// Функция отрисовки

let renderProducts = (products) => {
    // Проверяем и если они есть удаляем inputs
    // которые были созданы ранее
    document.querySelector('select[name=product]')?.remove();
    document.querySelector('input[name=stock]')?.remove();
    document.querySelector('input[name=discount]')?.remove();

    // Якорь относительно которого рендрится верстка
    let achor = document.querySelector('button[type=submit]');

    // Создаем селект для продуктов
    let select = document.createElement('select');
        select.name = 'product';
    achor.before(select);
    
    //Добавляем продукты из выбранного склада в селект
    products.forEach(el => {
        
        let item = document.createElement('option');
            item.value = el.product.id;
            item.innerText = el.product.name + ' на складе: ' + el.stock;
        select.append(item);

    });

    // Добавляем input 
    let stock = document.createElement('input');
        stock.type = 'text';
        stock.name = 'stock';
        stock.value = '';
        stock.placeholder = 'Количество';
        stock.autocomplete = 'off';
    achor.before(stock);

    // Добавляем input 
    let discount = document.createElement('input');
        discount.type = 'text';
        discount.name = 'discount';
        discount.value = '';
        discount.placeholder = 'Скидка';
        discount.autocomplete = 'off';
    achor.before(discount);

}

// Получаем список продуктов по id склада через api
let getProducts = (id) => {

    return new Promise((resolve, reject) => {

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function()
        {
            if(this.readyState === 4 && this.status === 200)
            {
                resolve(this.response);
            }
        }

        xhttp.open('GET', '/api/orders/getProducts' + '?id=' + id);
        xhttp.responseType = 'json';
        xhttp.send();

    });

}

// Взял вот тут https://stackoverflow.com/questions/6982692/how-to-set-input-type-dates-default-value-to-today
// Подставляет текущую дату в input date на страницу заказов

Date.prototype.toDateInputValue = (function() {
    let local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

document.querySelector('input[name=date]').value = new Date().toDateInputValue();