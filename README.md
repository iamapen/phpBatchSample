# phpのバッチサンプル

## Install
```bash
composer install
```

## Usage

pear/console_commandline
```bash
php bin/pcc.php
php bin/pcc.php -h
php bin/pcc.php /notfound
php bin/pcc.php /tmp
php bin/pcc.php /tmp --keepFile=1  
```

symfony/console
```bash
php bin/sfc.php sfc:sample1
php bin/sfc.php sfc:sample1 -h
php bin/sfc.php sfc:sample1 /notfound
php bin/sfc.php sfc:sample1 /tmp
php bin/sfc.php sfc:sample1 /tmp --keepFile=1
```