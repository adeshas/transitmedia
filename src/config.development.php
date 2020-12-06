<?php

/**
 * PHPMaker 2021 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "POSTGRESQL", "qs" => "\"", "qe" => "\"", "host" => "localhost", "port" => "5432", "user" => "postgres", "password" => "", "dbname" => "test", "schema" => "public"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "smtp.zoho.com", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "admin@transitmedia.com.ng", // SMTP server user name
        "SERVER_PASSWORD" => "Zimmerr0hde", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "tfG5kbGRjekoq18p", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
