# phpのバッチサンプル

## Install
```bash
composer install
```

## Usage

pear/console_commandline
```bash
php src/Pcc/PccCommand.php
php src/Pcc/PccCommand.php -h
php src/Pcc/PccCommand.php /notfound
php src/Pcc/PccCommand.php /tmp
php src/Pcc/PccCommand.php /tmp --keepFile=1  
```

symfony/console
```bash
php bin/sfc.php sfc:sample1
php bin/sfc.php sfc:sample1 -h
php bin/sfc.php sfc:sample1 /notfound
php bin/sfc.php sfc:sample1 /tmp
php bin/sfc.php sfc:sample1 /tmp --keepFile=1
```