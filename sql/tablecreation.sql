DROP TABLE IF EXISTS photogallery;

CREATE TABLE photogallery (
id int(11)  AUTO_INCREMENT PRIMARY KEY,
filename varchar(255),
image varchar(255),
title varchar(100),
description text,
width int(11),
height int(11)
);
