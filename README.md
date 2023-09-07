# MSGR 2.0 SMS management platform.

This repo is a clone of a point in time of the original repo. It is used for the purpose of a test like the one you're
doing now.

API docs are automatically generated at

- http://localhost/docs/api#/ (using [scramble package](https://scramble.dedoc.co/installation))
- generate api's into typescript (runs from frontend) with `openapi-typescript` (further reading at nuxt/readme.md)

# Starting project

Create a .env file from .env.example

# Github

- we use (https://nvie.com/posts/a-successful-git-branching-model/) branching model
-
    - working on feature/<feature> name
-
    - create a PR to merge to development branch when done
-
    - we deploy to production from master branch

```bash
cp .env.example .env
```

Check if correct binary for your architecture is specified in /docker/clickhouse/Dockerfile
Look for the following two lines and comment/uncomment the correct one

```bash
#ARG single_binary_location_url="https://builds.clickhouse.com/master/amd64/clickhouse"

# Apple chip solution - unomment the line above and use this instead.
ARG single_binary_location_url="https://builds.clickhouse.com/master/aarch64/clickhouse"
````

Install dependencies, start the project and run tests

```bash
composer install
sail up -d
sail -f docker-compose.clickhouse.yml up -d
sail artisan migrate:fresh --seed
sail artisan jwt:secret
sail test
```

- if composer is not installed run `docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  composer install --ignore-platform-reqs`

If `clickhouse` container doesn't exist, run this command:

```bash
sail -f docker-compose.clickhouse.yml up -d
```

# queues

`sail php artisan horizon` to start
`http://v2.local/horizon/dashboard` to view

make sure queues are not retrying automatically

# logs

I use https://lnav.org/ for it
run `lnav storage/logs/laravel.log`

# supporting services

- frontend: https://v2-frontend.vercel.app/ (https://github.com/msgr2/v2_frontend)
- url shortener: https://github.com/msgr2/v2_shortener


# Commit from Pitangent

# For RabbitMQ setup you need to add following in .env file

QUEUE_CONNECTION=rabbitmq

MQ_HOST=rabbitmq
MQ_PORT=5672
MQ_VHOST=/
MQ_LOGIN=guest
MQ_PASS=guest
MQ_USER=guest

# For sending SMS using Twilio you need to setup Twilio following in .env file
TWILIO_SID=<YOUR_TWILIO_SID>
TWILIO_AUTH_TOKEN=<YOUR_TWILIO_AUTH_TOKEN>
TWILIO_NUMBER=<YOUR_TWILIO_NUMBER>

# For send SMS you need to change the following details in App\Http\Controllers\RabbitMQMessageController
$receiverDetails = [
    /**
        * Where to send a text message (your cell phone?), 
        * For trial period ,currently it's only supported registered number
        * This number is used for demo purpose
        */
    'phone' => '+911234567890'
];

# For send SMS you need to hit the below api

http://v2.local:8888/api/v1/message, it is GET request

# For consume the message you need to run below command in terminal

sudo docker exec -it msgr_v2-laravel.test-1 php artisan mq:consume

# RabbitMQ provide a default UI, you need to hit the below URL in browser
http://v2.local:15672/



