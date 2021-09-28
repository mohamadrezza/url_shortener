#!/usr/bin/env bash

mysql -u root -e "
CREATE DATABASE IF NOT EXISTS shortener;
use shortener;

create table if not exists users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(250) NULL,
    email      VARCHAR(250) NOT NULL UNIQUE,
    password   VARCHAR(250) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX( name,email)
);

create table if not exists short_links
(
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED,
    link       VARCHAR(250) NOT NULL,
    code       VARCHAR(250) NOT NULL UNIQUE,
    expire_at  TIMESTAMP DEFAULT NULL,
    deleted_at TIMESTAMP DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX( link,code)
)"