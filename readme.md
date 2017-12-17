# Probe

Endpoint detection.

## Development with Docker

(note to self)

```
$ docker run --rm -it -v /path/to/probe:/app composer install
$ docker run -d -v /path/to/probe:/var/www/html -p 80:80 --name probe php:5.6-apache
```