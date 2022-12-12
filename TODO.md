* Change spesific php version
** Deb/Ubuntu Derivatives
```
add-apt-repository ppa:ondrej/php
apt install php{version} php{version}-fpm .*cli .*xml
update-alternatives --set php {php_path}
# Disable current php 
a2dismod php{version}
# Enable current php 
a2enmod php{version}

# restart apache
systemctl restart apache2

# check to see php loaded configuration correcly
php -i | grep "Configuration File
```


