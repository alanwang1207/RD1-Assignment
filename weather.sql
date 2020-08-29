create database test2;

use test2;

CREATE TABLE `currentwt` (
  `cityName` varchar(10)  NOT NULL,
  `Wx` varchar(30)  NOT NULL,
  `PoP` varchar(10)  NOT NULL,
  `MinT` varchar(10)  NOT NULL,
  `MaxT` varchar(10)  NOT NULL,
  `CI` varchar(20)  NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;