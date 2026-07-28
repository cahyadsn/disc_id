<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : inc/config.php
DESC         :
AUTHOR       : CAHYA DSN
CREATED DATE : 2016-01-13
UPDATED DATE : 2026-07-28 12:11:34
DEMO SITE    : https://psycho.cahyadsn.com/disc_id
SOURCE CODE  : https://github.com/cahyadsn/disc_id
================================================================================
MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

copyright (c) 2026 by cahya dsn; cahyadsn@gmail.com
================================================================================
*/
  // Load .env file if it exists
  $envPath = __DIR__ . '/../.env';
  if (file_exists($envPath)) {
      $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach ($lines as $line) {
          if (strpos(trim($line), '#') === 0) {
              continue;
          }
          if (strpos($line, '=') !== false) {
              list($name, $value) = explode('=', $line, 2);
              $name = trim($name);
              $value = trim($value);
              if (preg_match('/^"(.*)"$/', $value, $matches) || preg_match("/^'(.*)'$/", $value, $matches)) {
                  $value = $matches[1];
              }
              $_ENV[$name] = $value;
              putenv("$name=$value");
          }
      }
  }
  //-- version 
  $version = getenv('VERSION') ?: '2.0';	

  //-- database configuration
  $dbhost = getenv('DB_HOST') ?: 'localhost';
  $dbuser = getenv('DB_USER') ?: 'root';
  $dbpass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
  $dbname = getenv('DB_NAME') ?: 'disc';

  //-- database connection
  $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($db->connect_error) {
      die("Database connection failed: " . $db->connect_error);
  }
