#EEVENTS

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/a27b80f6c9d64283ac9899a4c99bf9d6)](https://www.codacy.com?utm_source=bitbucket.org&amp;utm_medium=referral&amp;utm_content=cdpwebteam/vivant-backend&amp;utm_campaign=Badge_Grade) [![Codacy Badge](https://app.codacy.com/project/badge/Coverage/a27b80f6c9d64283ac9899a4c99bf9d6)](https://www.codacy.com?utm_source=bitbucket.org&utm_medium=referral&utm_content=cdpwebteam/vivant-backend&utm_campaign=Badge_Coverage)

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Download and install [Docker](https://www.docker.com/get-started)

### Set up Laradoc

Create empty directory for project:

```sh
mkdir eevents
cd eevents
```

Clone Laradock:

```sh
git clone https://github.com/Laradock/laradock.git
```

Clone Eevents backend project:

```sh
git clone https://github.com/tamaravasiljevic/eevents.git
```

In your favorite IDE open `laradoc` directory, and:

- copy `eevents/samples/laradoc.env` file to `.env`, and
- copy `eevents/samples/laradoc-docker-compose.yaml` file to `docker-compose.yaml`.

Now from laradoc directory you should be able to start and stop docker containers.

Start:

```sh
docker-compose up -d nginx mysql redis mailhog workspace
```

Stop:

```sh
docker-compose down
```

You can access docker container with project files with:

```sh
docker exec -it vivant_workspace_1 bash
```

### Set up project

In your favorite IDE open `eevents` directory and:

- copy `samples/laravel.env` file to `.env`.

Access docker container `docker exec -it vivant_workspace_1 bash` and install dependencies:

```sh
composer install
```

Migrate database:

```sh
php artisan migrate
```

Install passport:

```sh
php artisan passport:install
```

Seed database:

```sh
php artisan db:seed
php artisan db:seed --class UserSeeder
```

Add `127.0.0.1 vivant.app` to your hosts file.

In your browser navigate to: http://eevents.com/admin

Login with:

- Email: admin@vivant.eco
- Password: admin


### Set up Xdebug

- Find out the internal IP of your machine.
- SSH to FPM container using:
```
docker exec -it vivant_php-fpm_1  bash
```
- Navigate to PHP configs.
```
cd /usr/local/etc/php/conf.d
```
- Since there are no text editors installed, remove xdebug.ini file.
```
rm xdebug.ini 
```
- Edit the lines bellow with desired host (your internal IP) and port and create new xdebug.ini file with:
```
cat <<EOT >> xdebug.ini
xdebug.remote_host=192.168.0.0
xdebug.remote_connect_back=0
xdebug.remote_port=9000
xdebug.idekey=PHPSTORM

xdebug.remote_autostart=1
xdebug.remote_enable=1
xdebug.cli_color=1
xdebug.profiler_enable=0
xdebug.profiler_output_dir="~/xdebug/phpstorm/tmp/profiling"

xdebug.remote_handler=dbgp
xdebug.remote_mode=req

xdebug.var_display_max_children=-1
xdebug.var_display_max_data=-1
xdebug.var_display_max_depth=-1

EOT
```

- Restart Docker containers for FPM and Nginx. Run:
```
docker restart vivant_php-fpm_1 && docker restart vivant_nginx_1
```

- Make sure that the correct port is entered in your IDE Xdebug settings.

- Update PHP server settings in IDE PHP settings. Values should be:
```
name: vivant
host: 0.0.0.0
port: 80
```

- Update mapping if necessary by adding `/var/www` as value for Absolute path on server.

- Click the designated IDE icon to start listening for PHP debugg connections.

Notes:

- The following instructions are intended for InteliJ platform IDE's.
- If you change location, your internal IP is likely to change, so you will have to
  update xdebug host manually.
- If you run `docker-compose down` to stop docker containers, your FPM configs will be cleared on new start,
  so it is advised to use `docker stop {container_name}` instead.

## Running the tests

Before you start, create test database: `php artisan test:prepare-db`.

Run database migrations and seeders on test database:

```sh
php artisan migrate --database mysql-test
php artisan db:seed --database mysql-test
```

Access docker container `docker exec -it vivant_workspace_1 bash` and run:

```sh
vendor/bin/phpunit
```

## Coding standards

Please follow [PSR-12](https://www.php-fig.org/psr/psr-12/).

You can set up Code Sniffer, or similar tools, in your IDE to help you with this.

## Deployment

Please follow [Gitflow Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow).

You are not allowed to push to `master` and `dev` branches.

All of your branches should be created from `dev` branch, except hotfix branches. Merge requests should be open to `dev` branch and reviewed by at least one other developer working in team.

When some branch is merged into `dev` deployment to dev server will be triggered automatically and new changes will be deployed in few minutes.

When some branch is merged into `master` deployment to production server will be triggered automatically and new changes will be deployed in few minutes. It is recommended to merge only `dev` branch into `master` after QA team confirmation.

## Built With

* [Laravel](https://laravel.com/) - The framework used
* [Backpack](https://backpackforlaravel.com/) - Laravel Admin Panel

## Developers working on the project

* **Tamara Vasiljević** - [tamaravasiljevic89@gmail.coom](tamaravasiljevic89@gmail.com)
