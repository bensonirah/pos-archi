#!/usr/bin/env bash

# install dependencies
## csa/guzzle-bundle => error
## fr3d/ldap-bundle => symfony/ldap
## friendsofsymfony/rest-bundle => error
## friendsofsymfony/user-bundle => error
## gesdinet/jwt-refresh-token-bundle => error
## onurb/excel-bundle => error
composer req symfony/ldap
composer req "serializer:^1.0"
composer req friendsofsymfony/rest-bundle
composer req orm
composer req incenteev/composer-parameter-handler
composer req ircmaxell/password-compat
composer req jms/serializer-bundle
composer req lexik/jwt-authentication-bundle
composer req nekman/luhn-algorithm
composer req ramsey/uuid
composer req symfony/maker-bundle --dev