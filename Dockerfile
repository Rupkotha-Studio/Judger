FROM ubuntu:latest
#the following ARG turns off the questions normally asked for location and timezone for Apache
ENV DEBIAN_FRONTEND=noninteractive

#install all the tools you might want to use in your container
#probably should change to apt-get install -y --no-install-recommends
RUN apt update
RUN apt install -y nano
RUN apt install -y apache2
RUN apt install libapache2-mod-fcgid
RUN a2enmod proxy
RUN a2enmod proxy_fcgi

RUN apt update && apt install -y php libapache2-mod-php php-mysql

EXPOSE 80

# Now start the server
# run Apache in foreground
CMD  /usr/sbin/apache2ctl -D FOREGROUND


# Compiler Install
RUN apt install -y build-essential
RUN apt install -y manpages-dev
RUN apt install -y default-jre
RUN apt install -y python2
RUN apt install -y python3
RUN apt install -y mono-complete

#if time is not install then /usr/bin/time is not found when code compile
RUN apt install -y time


#set working directory to where Apache serves files
WORKDIR /var/www/html
RUN rm index.html
COPY . /var/www/html
RUN chmod o-rw /var/www/html
RUN chmod -R 777 /var/www/html/api/
RUN mkdir -m 777 /var/www/html/api/temp
RUN mkdir -m 777 /var/www/html/api/compile_file


