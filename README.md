
## 1. Directory structure
    ├── data
    │   ├── mysql
    │   └── redis
    ├── services
    │   ├── nginxs
    │   ├── mysql
    │   ├── phpmyadmin
    │   └── redis
    ├── logs
    │   ├── mysql
    ├── docker-compose.example.yml
    ├── env.example
    └── www

## 2. How to use

### 2.1 Configure the environment
The environment configuration file is `.env`, which is a copy of the `env.example` file, copy it to `.env` and modify it as needed.
```bash
cp .env.example .env
```

### 2.2 Configure docker-compose.yml
The docker-compose.yml file is a copy of the docker-compose.yml.example file, wich is a copy of the docker-compose.yml.example file, copy it to docker-compose.yml and modify it as needed.
```bash
cp docker-compose.yml.example docker-compose.yml
```

### 2.3 Start the service
```bash
docker-compose up -d
```

## 3. Services

### 3.1 phpMyAdmin
The port address of the phpMyAdmin container mapped to the host is: `8080`, so to access on the host, use the address: "localhost:8080".

    http://localhost:8080

Information MySQL connection:

* host: (MySQL container network for this project)
* port：`3306`
* username:(Manually entered in the phpmyadmin interface)
* password:(Manually entered in the phpmyadmin interface)

### 3.2 phpRedisAdmin
The port address of the phpRedisAdmin container mapped to the host is: `8081`, so to access on the host, use the address: 

    http://localhost:8081

The Redis connection information is as follows:

*   host: (Redis Container Network for this project)
*   port: `6379`


## 4. Administrative commands

### 4.1 Server Startup and Build Commands
To manage services, follow the command with the server name, for example:

```bash
$ docker-compose up # Create and start all containers
$ docker-compose up -d # Create and start all containers in background mode
$ docker-compose up mysql redis # Create and start multiple containers of mysql, redis
$ docker-compose up -d mysql redis # Create and start nginx, php, mysql containers with background running

$ docker-compose start mysql # Start Service
$ docker-compose stop mysql # Stop service
$ docker-compose restart mysql # Restart service
$ docker-compose build mysql # Build or re-build services

$ docker-compose rm mysql # Delete and stop the php container
$ docker-compose down # Stop and delete containers, networks, images and mounted volumes
```

### 4.2 Add shortcut commands
At the time of development, we may use it often `docker exec -it` entering the container and aliasing the commands commonly used is a convenient way to do so.

First, review the available containers in the host:

```bash
$ docker ps # View all running containers
$ docker ps -a # All containers
```

Output `NAMES` that column is the name of the container, or if the default configuration is used, then the name is `nginx`, `mysql`, `redis` wait.

Then, open `~/.bashrc` or `~/.zshrc` file, plus:

```bash
alias dnginx='docker exec -it nginx /bin/sh'
alias dmysql='docker exec -it mysql /bin/bash'
alias dredis='docker exec -it redis /bin/sh'
```

The next time you enter the container, it is very fast, such as entering the php container:

```bash
$ dnginx
```

## 5. Use Log
The location where the log file is generated depends on the value of each log configuration under conf.

### 5.1 Nginx logs
Nginx logs are the logs we use the most, so we put them separately in the root directory `log`.
Under `log` the directory will be mapped for the Nginx container `/var/log/nginx` directory, so in the Nginx configuration file, the location of the output log needs to be configured `/var/log/nginx` Directories, such as:

    error_log  /var/log/nginx/nginx.localhost.error.log  warn;

### 5.2 MySQL logs
Because MySQL in the MySQL container is used `mysql`.
The user starts, it cannot be self-contained `/var/log` add log files under Add log files.
So, we put mySQL logs in the same directory as data, i.e. projects `mysql` directory, corresponding to the container `/var/log/mysql/` directory.

```bash
slow-query-log-file = /var/log/mysql/mysql.slow.log
log-error           = /var/log/mysql/mysql.error.log
```

The above is the configuration of the log file in mysql.conf.

## 6. Database management
This project defaults to `docker-compose.yml` for MySQL online management is not turned on *phpMyAdmin*, and for redis online management *phpRedisAdmin*, which can be modified or deleted as needed.

## 7. Extra information

### 7.1 Docker container time
The container time is configured in an .env file `TZ` for variables, see all supported time zones [list of time zones on Wikipedia](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones) or [list of time zones supported by PHP· PHP official website](https://www.php.net/manual/zh/timezones.php)。