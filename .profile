#!/usr/bin/env bash

# Generate the Satis config
php bin/render-template.php views/satis.json.twig > satis.json

# Store the SSH key.
if ! [ -z "$SATIS_SSH_KEY" ]; then
    mkdir -p $HOME/.ssh
    echo "$SATIS_SSH_KEY" > $HOME/.ssh/id_rsa
    # Generate a corresponding public key.
    ssh-keygen -y -f $HOME/.ssh/id_rsa > $HOME/.ssh/id_rsa.pub
    # Add hosts of all configured repositories to known_hosts
    php bin/print-repository-hosts.php | xargs ssh-keyscan >> "$HOME/.ssh/known_hosts"
fi

htpasswd -c -b -B "$HOME/.htpasswd" test test
php bin/render-template.php views/htaccess.text.twig > web/.htaccess

# Perform an initial build when the instance starts.
./vendor/bin/satis build --no-interaction --skip-errors
