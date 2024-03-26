CREATE TABLE couriers
(
    id   INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE regions
(
    id                      INT PRIMARY KEY AUTO_INCREMENT,
    name                    VARCHAR(50) NOT NULL,
    duration_to_destination INT         NOT NULL,
    duration_return_trip    INT         NOT NULL
);
CREATE TABLE trips
(
    id             INT PRIMARY KEY AUTO_INCREMENT,
    region_id      INT,
    courier_id     INT,
    departure_date DATE,
    arrival_date   DATE,
    return_date    DATE,
    FOREIGN KEY (region_id) REFERENCES regions (id),
    FOREIGN KEY (courier_id) REFERENCES couriers (id)
);