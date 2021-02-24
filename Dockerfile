FROM yiisoftware/yii2-php:7.4-apache
COPY . /app
RUN chown -R www-data.www-data /app
EXPOSE 80
