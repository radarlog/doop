# Doop

[![Build Status](https://travis-ci.org/radarlog/doop.svg?branch=master)](https://travis-ci.org/radarlog/doop)
[![Coverage Status](https://coveralls.io/repos/github/radarlog/doop/badge.svg?branch=master)](https://coveralls.io/github/radarlog/doop?branch=master)

Doop is a PHP application implementing Hexagonal Architecture for uploading images to an S3-compatible object storage and using PostgreSQL for data deduplication.
It strictly follows SOLID principles and is 100% covered by tests. Development environment is fully dockerized and automated with a makefile. 

### Requirements
* PHP >= 7.4
* PostgreSQL >= 9.0
* S3-compatible storage (AWS, MinIO)

### Directory Structure

```
bin/                 cli entry point 
config/              configuration files
docker/              docker related files
public/              http document root
src/                 source files
  Application/       application layer (use cases)
  Domain/            domain layer (core logic)
  Infrastructure/    infrastructure layer (db, cli, http)
tests/               unit and functional tests
  Application/       use cases unit tests
  Domain/            domain layer unit tests
  Fixtures/          image fixture files
  Infrastructure/    infrastructure functional tests
```

## Running locally

Make sure you have `docker-compose` and `make` installed.
Clone the latest version and run:

```bash
$ make run  
```
then navigate to `http://localhost/` with your favorite browser.

## Testing

Make sure you have `docker-compose` and `make` installed.
Perform all the necessary QA-checks like coding styles, static analysis and unit/functional tests:

``` bash
$ make tests
```

## License

Doop is licensed under MIT License. Please see [LICENSE](LICENSE) for details.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information.
