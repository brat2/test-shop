Для начала нужно создать БД, запустить миграции и посев

Функция аутентификации не реализована. В место этого, id пользователя нужно передавать через параметр get-запроса (например: /api/cart?user=1) <br>
Роль администратора не реализована.
<br><br>
get  /api/products   - просмотр всех товаров по страницам <br>
get  /api/cart?user=1   - просмотр корзины пользователя <br>
get  /api/carts   - просмотр всех корзин <br>
get  /api/cart/add/5?user=1  - добавление единицы товара с id 5 в корзину (каждый новый запрос плюсует количество товара) <br>
get  /api/cart/remove/5?user=1  - удаление единицы товара с id 5 из корзины (каждый новый запрос минусует количество товара)
