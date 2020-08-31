create database test3 DEFAULT character set utf8;

use test3;


CREATE TABLE `currentwt` (
  `cityName` varchar(10)  NOT NULL,
  `Wx` varchar(30)  NOT NULL,
  `PoP` varchar(10)  NOT NULL,
  `MinT` varchar(10)  NOT NULL,
  `MaxT` varchar(10)  NOT NULL,
  `CI` varchar(20)  NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  CREATE TABLE  `twodays` (
  `cityName` varchar(10)  NOT NULL,
  `startTime` DATETIME NOT NULL,
  `weatherDescription` varchar(240)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `oneweek` (
  `cityName` varchar(10)  NOT NULL,
  `startTime` DATETIME NOT NULL,
  `weatherDescription` varchar(240)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rainfall` (
  `locationName` varchar(10)  NOT NULL,
  `city` varchar(10)  NOT NULL,
  `onehour` varchar(20)  NOT NULL,
  `HOUR_24` varchar(20)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;