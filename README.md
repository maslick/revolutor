# =revolutor=
Sample application using [itsoft7/revolut-php](https://github.com/itsoft7/revolut-php)

## Demo
https://revolutor.herokuapp.com

## Create private key and certificate
```shell
openssl genrsa -out privatekey.pem 1024
openssl req -new -x509 -key privatekey.pem -out publickey.cer -days 1825
```

## Local installation
```shell
sudo sh -c 'echo "\n127.0.0.1 revolutor.tech" >> /etc/hosts'

composer install

open https://sandbox-business.revolut.com/settings/api        # <- add certificate, get REVOLUT_CLIENT_ID
export API_URL="https://sandbox-b2b.revolut.com/api/1.0"
export REVOLUT_CLIENT_ID="xxxxxxxxxxxx"
export REVOLUT_PRIVATE_KEY=$(cat privatekey.pem | base64 | tr -d '\n')
export REDIRECT_URL=http://revolutor.tech:8080
php -S 127.0.0.1:8080

open https://sandbox-business.revolut.com/settings/api        # <- enable API access to your account
open http://revolutor.tech:8080                               # <- enjoy ;)
```


## Heroku
```shell
export APP_NAME=revolutor45

heroku login
heroku create $APP_NAME
heroku git:remote --app $APP_NAME
git push heroku master

open https://sandbox-business.revolut.com/settings/api        # <- add certificate, get REVOLUT_CLIENT_ID

heroku config:set \
  API_URL="https://sandbox-b2b.revolut.com/api/1.0" \
  REVOLUT_CLIENT_ID="xxxxxxxxxxxx" \
  REVOLUT_PRIVATE_KEY=$(cat privatekey.pem | base64 | tr -d '\n') \
  REDIRECT_URL="https://$APP_NAME.herokuapp.com" \
  --app $APP_NAME
  
open https://sandbox-business.revolut.com/settings/api        # <- enable API access to your account
open https://$APP_NAME.herokuapp.com                          # <- enjoy ;)
```