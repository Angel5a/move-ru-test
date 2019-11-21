# Задание 1

Для выполнения поставленных в задании задач PHP код не используется, однако выдвигаются требования к PHP коду, который должен будет формировать записи для указанных таблиц (выполнять заполнение таблиц). Эти требования могут быть сняты, за счёт усложнения запросов и увеличения потребляемых ресурсов для их выполнения.

## Решение 1

Более гибкий вариант таблиц в плане расширения и возможностей.

Таблица контактов.
```
CREATE TABLE `contacts` (
`id` int NOT NULL AUTO_INCREMENT,
`name` varchar(40) DEFAULT '',
PRIMARY KEY (`id`)
);
```

Таблица связи друзей.
```
CREATE TABLE `friends` (
  `who` int(11) NOT NULL,
  `whom` int(11) NOT NULL,
  PRIMARY KEY (`who`, `whom`)
);
```

Пункт 1.1. Получение списка контактов у которых более 5 друзей.
```
SELECT friends.who, contacts.name, count(*) as cnt
 FROM friends
 LEFT JOIN contacts ON friends.who = contacts.id
 GROUP BY friends.who
 HAVING cnt > 5;
```

Пункт 1.2. Получить все уникальные пары. Уникальность обеспечивает UNION и дополнительные условия первым индексом меньшего (точнее не большего) из двух.
```
SELECT f.id1, c1.name as name1, f.id2, c2.name as name2
 FROM (
   (SELECT who as id1, whom as id2 FROM friends where who < whom)
   UNION
   (SELECT whom as id1, who as id2 FROM friends where who >= whom)
  ) f
 LEFT JOIN contacts c1 ON f.id1 = c1.id
 LEFT JOIN contacts c2 ON f.id2 = c2.id

 ```

### Минусы

 1. Добавление новой записи выполняется как вставка сразу двух строк (если необходимо, это требование можно снять, усложнив запрос получения списка контактов).
```
INSERT INTO `friends` VALUES (1, 2), (2, 1);
```
 2. Двойная избыточность при хранении.
 3. Возможны проблемы с целостностью данных (утеряна строка с "обратным" направлением).
 4. Использование UNION при получении уникальных пар на большой таблице связей крайне затратно.

### Плюсы

 1. Один индекс в таблице друзей для ускорения операций вставки (но это, предположительно, редкая операция).
 2. Простота получения списка друзей и их количества, что обычно является более частым запросом (если расспатривать социальные сети).
 3. Возможность "односторонней" дружбы (но это не соответствует поставленой задаче).


## Решение 2

Больше оптимальный в рамках поставленной задачи. Некоторые другие запросы тоже предполагаются, но оптимизация с учётом только заявленных запросов.

Таблица контактов.
```
CREATE TABLE `contacts` (
`id` int NOT NULL AUTO_INCREMENT,
`name` varchar(40) DEFAULT '',
PRIMARY KEY (`id`)
);
```

Таблица связи друзей. В поле id1 должен быть меньший индекс из двух.
```
CREATE TABLE `friends` (
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  PRIMARY KEY (`id1`, `id2`),
  INDEX `auxid` (`id2`)
);
```

Пункт 1.1. Получение списка контактов у которых более 5 друзей.
```
SELECT f.id, c1.name, count(*) as cnt
 FROM (
   (SELECT id1 as id, id2 as whom FROM friends)
   UNION ALL
   (SELECT id2 as id, id1 as whom FROM friends)
   ) f
 LEFT JOIN contacts c1 ON f.id = c1.id
 GROUP BY f.id
 HAVING cnt > 5;
```

Пункт 1.2. Получить все уникальные пары. Уникальность обеспечиваетc индексом и строгим соблюдением правила вставки записи.
```
SELECT f.id1, c1.name as name1, f.id2, c2.name as name2
 FROM friends f
 LEFT JOIN contacts c1 ON f.id1 = c1.id
 LEFT JOIN contacts c2 ON f.id2 = c2.id

 ```

### Минусы

 1. При добавлении записей надо следить за порядком индексов. Или добавлять в базу тригеры проверки с генерацией ошибки. Иначе результаты запросов будут искажены.
 2. Необходимость второго индекса (по id2) для быстрого извлечения списка друзей конкретного пользователя.

### Плюсы

 1. Нет избыточности данных.
 