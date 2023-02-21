
## 1. Directory structure
├── data
│   ├── mysql
│   ├── postgres
│   └── redis
├── logs
│   └── nginx
├── services
│   ├── mysql
│   ├── nginx
│   ├── pgadmin
│   ├── php81
│   ├── phpmyadmin
│   ├── postgres
│   ├── redis
│   └── phpredisadmin
├── .env.example
├── docker-compose.yml.example
└── www

## 2. How to use

## 2.1 Initialization
Copy the example configuration files and modify them as needed.

```bash
cp services/mysql/mysql.cnf.example services/mysql/mysql.cnf
cp services/nginx/conf.d/localhost.conf.example services/nginx/conf.d/localhost.conf
cp services/nginx/fastcgi-php.conf.example services/nginx/fastcgi-php.conf
cp services/nginx/fastcgi_params.example services/nginx/fastcgi_params
cp services/php81/php-fpm.conf.example services/php81/php-fpm.conf
cp services/php81/php.ini.example services/php81/php.ini
cp services/phpmyadmin/config.user.inc.php.example services/phpmyadmin/config.user.inc.php
cp services/phpmyadmin/php-phpmyadmin.ini.example services/phpmyadmin/php-phpmyadmin.ini
cp services/redis/redis.conf.example services/redis/redis.conf
```

### 2.2 Docker Compose
Copy docker-compose.yml.example to docker-compose.yml and modify it as needed.

The docker-compose.yml file for this project has all services enabled for management by default. However, specific services can be enabled or disabled based on project requirements. It's important to note that these settings are customizable and can be modified or removed.

```bash
cp docker-compose.yml.example docker-compose.yml
```

### 2.3 Configuration env
The environment configuration file is .env. Copy it from .env.example and modify it as needed.

To enable specific services, you need to edit the corresponding variables in the `.env` file.

```bash
cp .env.example .env
```

### 2.4 Starting Services

```bash
docker-compose up -d
```

## 3. Services

### 3.1 phpMyAdmin

The port address of the phpMyAdmin container mapped to the host is `8080`. Access it on the host at `localhost:8080`.
    http://localhost:8080

The MySQL connection information is as follows:

* host: (MySQL container network)
* port: `3306`
* username: (manually entered in the phpMyAdmin interface)
* password: (manually entered in the phpMyAdmin interface)


### 3.2 pgAdmin

The port address of the pgAdmin container mapped to the host is `5050`. Access it on the host at `localhost:5050`.
    http://localhost:5050

The PostgreSQL connection information is as follows:

* host: (PostgreSQL container network)
* port: `5432`
* username: (manually entered in the pgAdmin interface)
* password: (manually entered in the pgAdmin interface)

### 3.3 phpRedisAdmin
The port address of the phpRedisAdmin container mapped to the host is `8081`. Access it on the host at `localhost:8081`.
    http://localhost:8081

The Redis connection information is as follows:

*   host: (Redis container network)
*   port: `6379`

## 4. Administrative Commands

### 4.1 Server Startup and Build Commands
Server Startup and Build Commands

```bash
$ docker-compose up # Create and start all containers
$ docker-compose up -d # Create and start all containers in background mode

$ docker-compose up mysql redis # Create and start multiple containers of mysql, redis, ecc ...
$ docker-compose up -d mysql redis # Create and start nginx, php, mysql, ecc ... containers with background running

$ docker-compose start mysql # Start mysql ervice
$ docker-compose stop mysql # Stop mysql service
$ docker-compose restart mysql # Restart mysql service
$ docker-compose build mysql # Build or re-build mysql service

$ docker-compose rm mysql # Delete and stop the mysql container
$ docker-compose down # Stop and delete containers, networks, images and mounted volumes
```

### 4.2 Add shortcut commands
During the development process, developers frequently need to enter a running Docker container using the docker exec -it command to execute various commands and scripts. To avoid repeatedly typing this command, developers can create aliases for commonly used commands within the container, making it more convenient and efficient to work with the container.

Before creating aliases for Docker container commands, it's important to review the list of available containers in the host machine.

```bash
$ docker ps # View all running containers
$ docker ps -a # All containers
```

The `NAMES` column in the output of the docker ps or docker ps -a command shows the names of the containers running on the host machine. By default, the names of the containers are set to common service names such as `nginx`, `mysql`, `redis`, etc.

To create aliases for commonly used commands in a container, you can open the `~/.bashrc` or `~/.zshrc` file, depending on your shell, and add the aliases for the container names you want to work with.

```bash
alias snginx='docker exec -it nginx /bin/sh'
alias smysql='docker exec -it mysql /bin/bash'
alias sredis='docker exec -it redis /bin/sh'
```

By creating aliases for commonly used Docker container commands, such as docker exec -it, developers can quickly and easily enter a container and run desired commands. For example, if you have created an alias for the Nginx container as `snginx`, you can enter the container with a single command like `snginx`. This saves time and improves efficiency, especially during development when you need to frequently access the containers.

```bash
$ snginx
```

## 5. Use Log
The location of log files in a Docker container depends on the log configuration set in the container's configuration files. Specifically, the location of the log files is determined by the value set for each log configuration in the conf file.

### 5.1 Nginx logs
Since Nginx logs are the most commonly used logs, they are separated and stored in the `log` directory at the root level. This directory is then mapped to the Nginx container's `/var/log/nginx` directory. To ensure that the logs are properly saved, the output log location in the Nginx configuration file needs to be set to `/var/log/nginx` directory, for example:
    error_log  /var/log/nginx/nginx.localhost.error.log  warn;

### 5.2 MySQL logs
To avoid conflicts with the MySQL container, it is not recommended to add log files under the `/var/log` directory. Therefore, we usually store MySQL logs in the same directory as data, i.e., the `mysql` directory in the project directory. This directory is then mapped to the `/var/log/mysql/` directory in the MySQL container.

```bash
slow-query-log-file = /var/log/mysql/mysql.slow.log
log-error           = /var/log/mysql/mysql.error.log
```

The above snippet shows the configuration for the MySQL log file in mysql.conf.

## 6. Extra information

### 6.1 Docker container time
The container time is configured in an .env file `TZ` for variables, see all supported time zones [list of time zones on Wikipedia](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones) or [list of time zones supported by PHP· PHP official website](https://www.php.net/manual/zh/timezones.php)。
