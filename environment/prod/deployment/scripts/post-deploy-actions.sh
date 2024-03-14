#!/bin/sh

# -e is for "automatic error detection", tell shell to abort any time an error occurred
set -e

composer install && \
npm install && \
npx tailwindcss -i ./styles.css -o ./public/output.css
