-- structure only, no dump data for free version

CREATE DATABASE IF NOT EXISTS disc;
USE disc;

DROP TABLE IF EXISTS tbl_personalities;
CREATE TABLE IF NOT EXISTS tbl_personalities (
  id tinyint(2) NOT NULL AUTO_INCREMENT,
  no tinyint(2) NOT NULL,
  term varchar(100) NOT NULL,
  most char(1) NOT NULL,
  least char(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tbl_results;
CREATE TABLE IF NOT EXISTS tbl_results(
  id INT NOT NULL AUTO_INCREMENT,
  value INT NOT NULL,
  d FLOAT NOT NULL,
  i FLOAT NOT NULL,
  s FLOAT NOT NULL,
  c FLOAT NOT NULL,
  line TINYINT(1) NOT NULL,
  PRIMARY KEY(id)
) ENGINE MyISAM;

DROP TABLE IF EXISTS tbl_patterns;
CREATE TABLE IF NOT EXISTS tbl_patterns(
  id INT NOT NULL AUTO_INCREMENT,
  type VARCHAR(20),
  pattern VARCHAR(30),
  behaviour VARCHAR(255),
  jobs TEXT,
  description TEXT,
  PRIMARY KEY(id)
) ENGINE=MyISAM;
