CREATE TABLE IF NOT EXISTS User (
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    phone INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS Adress (
    id_adress INTEGER PRIMARY KEY AUTOINCREMENT,
    id_user INTEGER,
    city TEXT NOT NULL,
    adress TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Product (
    id_product INTEGER PRIMARY KEY AUTOINCREMENT,
    product TEXT NOT NULL,
    price INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS List (
    id_list INTEGER PRIMARY KEY AUTOINCREMENT,
    id_product INTEGER,
    quantity INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS Cart (
    id_cart INTEGER PRIMARY KEY AUTOINCREMENT,
    id_user INTEGER,
    id_list INTEGER
);

CREATE TABLE IF NOT EXISTS Command (
    id_command INTEGER PRIMARY KEY AUTOINCREMENT,
    id_user INTEGER,
    id_list INTEGER,
    total_price INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS Invoices (
    id_invoices INTEGER PRIMARY KEY AUTOINCREMENT,
    id_command INTEGER,
    time_arrived DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS Payment (
    id_payment INTEGER PRIMARY KEY AUTOINCREMENT,
    id_user INTEGER,
    id_adress INTEGER,
    payment_method TEXT NOT NULL,
    iban INTEGER NOT NULL
);

SELECT u.name, a.city, p.product, p.price
FROM User u
JOIN Adress a ON u.id_user = a.id_user
JOIN Cart c ON u.id_user = c.id_user
JOIN List l ON c.id_list = l.id_list
JOIN Product p ON l.id_product = p.id_product;
