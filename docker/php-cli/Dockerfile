FROM php:7.3-cli

RUN apt-get update && apt-get install -y \
    curl

WORKDIR /var/www

#make it running
ENTRYPOINT ["tail", "-f", "/dev/null"]
