#!/usr/bin/env bash

set -e

composer install
./vendor/bin/phpunit --process-isolation tests/
