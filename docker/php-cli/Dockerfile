FROM php:7.2-cli

RUN apt-get update && apt-get install -y \
    curl

WORKDIR /var/www

#make it running
ENTRYPOINT ["tail", "-f", "/dev/null"]
