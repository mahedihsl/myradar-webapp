FROM palatok/laravelmongo:latest

ADD . /var/www/

WORKDIR /var/www

RUN su palatok -c "sudo chown -R palatok:palatok /var/www"
RUN su palatok -c "sudo chown palatok:palatok .env"
RUN su palatok -c "sudo rm .env.example"
RUN su palatok -c "sudo rm -r .git"
RUN su palatok -c "sudo chmod -R 755 /var/www/"
RUN su palatok -c "sudo chmod -R 777 storage/"
RUN rm -r public/storage
RUN su palatok -c "php artisan storage:link"
RUN mv .env.prod .env
RUN su palatok -c "php artisan config:clear"
RUN su palatok -c "php artisan cache:clear"
RUN su palatok -c "composer dumpautoload -o"

EXPOSE 80


#cron:  */2 * * * * php /var/www/artisan schedule:run >> /dev/null 2>&1
