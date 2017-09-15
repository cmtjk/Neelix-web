#!/bin/bash
docker run -it --rm -v $PWD:/var/www/html -p 8000:80 php:7.1-apache
