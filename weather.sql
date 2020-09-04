create database rd1 DEFAULT character set utf8;

use rd1;


CREATE TABLE `currentwt` (
  `cityName` varchar(30)  NOT NULL,
  `Wx` varchar(30)  NOT NULL,
  `WxValue` VARCHAR(30) NOT NULL,
  `PoP` varchar(30)  NOT NULL,
  `MinT` varchar(30)  NOT NULL,
  `MaxT` varchar(30)  NOT NULL,
  `CI` varchar(30)  NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  CREATE TABLE  `twodays` (
  `cityName` varchar(30)  NOT NULL,
  `locationName` varchar(30),
  `Wx` varchar(30)  NOT NULL,
  `WxValue` int NOT NULL,
  `PoP` varchar(30)  NOT NULL,
  `T` varchar(30)  NOT NULL,
  `CI` varchar(30)  NOT NULL,
  `RH` varchar(30)  NOT NULL,
  `startTime` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `oneweek` (
  `cityName` varchar(30)  NOT NULL,
  `locationName` varchar(30),
  `Wx` varchar(30)  NOT NULL,
  `WxValue` int NOT NULL,
  `PoP` varchar(30)  NOT NULL,
  `T` varchar(30)  NOT NULL,
  `CI` varchar(30)  NOT NULL,
  `RH` varchar(30)  NOT NULL,
  `startTime` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rainfall` (
  `locationName` varchar(30)  NOT NULL,
  `city` varchar(30)  NOT NULL,
  `townName` varchar(30)  NOT NULL,
  `onehour` varchar(30)  NOT NULL,
  `HOUR_24` varchar(30)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
