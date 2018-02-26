FROM centos:6.8
COPY join.conf /etc/httpd/conf.d/join.conf
COPY join.ini /etc/php.d/join.ini
COPY init.sh /init.sh
RUN chmod 0777 /init.sh
RUN rpm -Uvh "https://mirror.webtatic.com/yum/el6/latest.rpm"
#RUN yum update -y
RUN yum install -y git httpd
#RUN yum install -y mcrypt
RUN yum install -y php56w php56w-gd php56w-mysql php56w-pdo php56w-soap php56w-xml php56w-xmlrp php56w-ldap php56w-pear
#RUN yum install -y php56w-mcrypt
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod 0777 /init.sh /usr/local/bin/composer
RUN git clone https://github.com/simplesamlphp/simplesamlphp.git /var/simplesamlphp
RUN cp /var/simplesamlphp/config-templates/*.php /var/simplesamlphp/config
RUN cp /var/simplesamlphp/metadata-templates/*.php  /var/simplesamlphp/metadata
RUN composer update -d /var/simplesamlphp
EXPOSE 80
CMD ["/init.sh"]