IWIS Project

Запуск проекту

Перейти в папку конфігурації проєкту

cd IWIS/dev-environment

Запустити інфраструктуру

make up

Встановити залежності

make composer cmd="install"

Налаштувати базу даних

make console c="doctrine:migrations:migrate"
make console c="doctrine:mongodb:schema:update"

Тестування

Надіслати тестові продукти в чергу

make console c="app:load-test --count=1000"

Запустити worker для обробки черги

make console c="messenger:consume async -vv"

Обробити продукти з MongoDB у MySQL

make console c="app:process-products"

Перевірити лог збереження в MySQL

docker-compose exec php tail -f var/log/product_mysql_save.log


