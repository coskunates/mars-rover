-- plateaus: table
CREATE TABLE `plateaus`
(
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `upper_bound_x`  int          NOT NULL,
    `upper_bound_y`  int          NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO plateaus (upper_bound_x, upper_bound_y) VALUES(5, 5);
INSERT INTO plateaus (upper_bound_x, upper_bound_y) VALUES(6, 6);
INSERT INTO plateaus (upper_bound_x, upper_bound_y) VALUES(7, 9);
INSERT INTO plateaus (upper_bound_x, upper_bound_y) VALUES(3, 5);
INSERT INTO plateaus (upper_bound_x, upper_bound_y) VALUES(7, 5);

-- rovers: table
CREATE TABLE `rovers`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `plateau_id` int unsigned NOT NULL,
    `x`          int          NOT NULL,
    `y`          int          NOT NULL,
    `direction`  varchar(1)   NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_plateau_id_id` (`plateau_id`),
    CONSTRAINT `fk_plateau_id_id` FOREIGN KEY (`plateau_id`) REFERENCES `plateaus` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

INSERT INTO rovers (plateau_id, x, y, direction) VALUES(1, 1, 2, 'N');
INSERT INTO rovers (plateau_id, x, y, direction) VALUES(2, 3, 3, 'E');
INSERT INTO rovers (plateau_id, x, y, direction) VALUES(4, 0, 0, 'S');
INSERT INTO rovers (plateau_id, x, y, direction) VALUES(5, 1, 2, 'W');
INSERT INTO rovers (plateau_id, x, y, direction) VALUES(6, 1, 3, 'W');