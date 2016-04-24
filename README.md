# Satis on Heroku #

Your private Satis instance on Heroku, just one click away.

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

## Initial Configuration ##

### Connect local checkout to Heroku app ###

It is assumed that you have already installed the [Heroku Toolbelt](https://toolbelt.heroku.com/) and that 
you have logged in via ``heroku login`` command. The toolbelt is necessary to interact with your Heroku app via CLI.

Replace ``[heroku-app-name]`` with the app name you have chosen during deployment on Heroku when following the
instructions in this section.

Checkout the repository:

    git clone git@github.com:Matthimatiker/satis-on-heroku.git [heroku-app-name]
    cd [heroku-app-name]
    
Connect the checkout to your Heroku app:
    
    heroku git:remote --app [heroku-app-name]

You are now able to configure your app from your checkout directory via toolbelt.

### Register a SSH key ###

Your Satis instance needs a SSH key to read package data from private repositories. You can skip this
step if you do not plan to use private repositories.

Generate a new key:

    ssh-keygen -t rsa -f satis_on_heroku_ssh_key
    
Add the generated private key to your app configuration:
    
    heroku config:set SATIS_SSH_KEY="`cat satis_on_heroku_ssh_key`"
    
Ensure that the key can be used to access your private repositories. When using GitHub you have to register the
public key at [https://github.com/settings/keys](https://github.com/settings/keys). You might want to create
a separate account with read-only access for your Satis app.

### Add a GitHub token ###

TODO

### Remove the example repository ###

For demonstration purposes, an example repository has been registered during deployment. You might want 
to remove that now:

    heroku config:unset SATIS_REPOSITORY_EXAMPLE

## Usage ##

### Add repositories ###

Repositories that are scanned for packages are added via ``SATIS_REPOSITORY_*`` config variables. The values
of all config variables that are prefixed with ``SATIS_REPOSITORY_`` are treated as repository urls.

Here is an example how to add a repository:

    heroku config:set SATIS_REPOSITORY_NEW=git@github.com:Matthimatiker/satis-on-heroku.git

You can also use the app settings page on the [Heroku dashboard](https://dashboard.heroku.com) to add config values.

### Update ###

Currently, you have to restart your app to rebuild the package repository:

    heroku restart
    
You can also restart the app via [Heroku dashboard](https://dashboard.heroku.com).
