DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `has_districts` int(1) DEFAULT '0',
  `region` varchar(3) DEFAULT NULL,
  `county` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO city(id, name, has_districts, region, county) VALUES (918123, 'Warszawa', 1, '14', '65');
INSERT INTO city(id, name, has_districts, region, county) VALUES (922410, 'Białystok', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (928363, 'Bydgoszcz', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (930868, 'Częstochowa', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (933016, 'Gdańsk', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (934100, 'Gdynia', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (934783, 'Sopot', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (937474, 'Katowice', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (938670, 'Bytom', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (938887, 'Chorzów', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (940000, 'Gliwice', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (943428, 'Sosnowiec', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (950463, 'Kraków', 1, '12', '61');
INSERT INTO city(id, name, has_districts, region, county) VALUES (954047, 'Legnica', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (954700, 'Lublin', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (957650, 'Łódź', 1, '10', '61');
INSERT INTO city(id, name, has_districts, region, county) VALUES (964465, 'Olsztyn', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (965016, 'Opole', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (969400, 'Poznań', 1, '30', '64');
INSERT INTO city(id, name, has_districts, region, county) VALUES (970632, 'Gniezno', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (972750, 'Radom', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (974133, 'Rzeszów', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (977976, 'Szczecin', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (982724, 'Toruń', 0, NULL, NULL);
INSERT INTO city(id, name, has_districts, region, county) VALUES (986283, 'Wrocław', 1, '02', '64');

DROP TABLE IF EXISTS `street`;

CREATE TABLE `street` (
  `id` int(11) NOT NULL,
  `prefix` varchar(3) NOT NULL,
  `name_1` varchar(255) NOT NULL,
  `name_2` varchar(255) NOT NULL,
  `city_id_fk` int(11) NOT NULL,
  `district_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`id`,`city_id_fk`,`district_id_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `district`;

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
