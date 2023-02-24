<?php
//Создание таблиц
$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$connection->exec(
    "DROP TABLE if exists users;
                CREATE TABLE users (
                       uuid TEXT NOT NULL
                           CONSTRAINT uuid_primary_key PRIMARY KEY,
                       username TEXT NOT NULL
                           CONSTRAINT username_unique_key UNIQUE,
                       first_name TEXT NOT NULL ,
                       last_name TEXT NOT NULL
                );
                DROP TABLE if exists posts;
                CREATE TABLE posts (
                       uuid text not null
                           CONSTRAINT uuid_primary_key PRIMARY KEY,
                       author_uuid TEXT NOT NULL,
                       title TEXT NOT NULL ,
                       text TEXT NOT NULL,
                       FOREIGN KEY (author_uuid) REFERENCES users(uuid) ON DELETE CASCADE
                );
                DROP TABLE if exists comments;
                CREATE TABLE comments (
                       uuid text not null
                           CONSTRAINT uuid_primary_key PRIMARY KEY,
                       post_uuid TEXT NOT NULL,
                       author_uuid TEXT NOT NULL ,
                       text TEXT NOT NULL,
                       FOREIGN KEY (post_uuid) REFERENCES posts(uuid) ON DELETE CASCADE,
                       FOREIGN KEY (author_uuid) REFERENCES users(uuid) ON DELETE CASCADE
                );
                DROP TABLE if exists likes;
                CREATE TABLE likes (
                       uuid text not null
                           CONSTRAINT uuid_primary_key PRIMARY KEY,
                       post_uuid TEXT NOT NULL,
                       author_uuid TEXT NOT NULL ,
                       FOREIGN KEY (post_uuid) REFERENCES posts(uuid) ON DELETE CASCADE,
                       FOREIGN KEY (author_uuid) REFERENCES users(uuid) ON DELETE CASCADE
                );"

);
