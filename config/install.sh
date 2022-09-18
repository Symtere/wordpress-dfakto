#!/bin/bash

# Set variables
host_ext=.local
folder_name=dfakto
site_url="https://"$folder_name""$host_ext""
site_title="dfakto"
db_name=dfakto
db_prefix=pkhn_
admin_user=custom-admin
admin_email=supiot.gregory@gmail.fr
admin_user_password=YoXLP1wWh6mHPbVu

echo -e """
-----------------------------------
           Installation
-----------------------------------\n"""

# Download WP
wp core download --locale=fr_FR --force

has_db=$(wp db size)

if [ -z "$has_db" ]
then

echo -e """
-----------------------------------
   Configuration base de données
-----------------------------------\n"""

# Create wp-config.php
wp config create --dbname=$db_name --dbuser=root --dbpass="" --dbprefix=$db_prefix --skip-check --extra-php <<PHP
define( 'SCRIPT_DEBUG', true );
define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'WP_ALLOW_MULTISITE', false );
define( 'WP_POST_REVISIONS', 3 );
//define( 'AUTOSAVE_INTERVAL', 360 ); // seconds
//define( 'WP_POST_REVISIONS', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', false );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'WP_ROCKET_EMAIL', 'contact@wholehelp.com');
define( 'WP_ROCKET_KEY', '96ce35ed');
header('X-Frame-Options: SAMEORIGIN');
define('FORCE_SSL_ADMIN', true);
PHP

# Create new password
# passgen=`head -c 10 /dev/random | base64`
# password=${passgen:0:16}

# Create Database
wp db create

# Install Database
wp core install --url=$site_url --title="$site_title" --admin_user=$admin_user --admin_email=$admin_email --admin_password=$admin_user_password


## Set default options
# blogdescription
wp option update blogdescription "$site_title"
# Global
wp option update use_smilies 0
wp option update auto_update_core_dev 0
wp option update auto_update_core_minor 0
wp option update auto_update_core_major 0
# comments
wp option update comments_per_page 0
wp option update close_comments_for_old_posts 1
wp option update thread_comments 0
wp option update comment_registration 1
wp option update default_comment_status "closed"
wp option update default_ping_status "closed"
wp option update default_pingback_flag 0
wp option update comment_moderation 1
wp option update comment_previously_approved 1
wp option update show_avatars 0
# Date
wp option update date_format "j M Y"
wp option update blog_public 0
# Debug
wp config set WP_DEBUG true --raw
# Post per page : for dev pagination test
wp option update posts_per_page "1"

# Generate .htaccess // https://github.com/wp-cli/rewrite-command
wp rewrite structure "/%post_id%/%postname%/"
wp option update permalink_structure "/%post_id%/%postname%/"
wp rewrite flush --hard

## Create RGPD pages
# echo -e """
# -----------------------------------
#      Création des pages RGPD
# -----------------------------------\n"""

# RGPD pages
# cd scaffold/tpl/rgpd/pages
# sh create-rgpd-pages.sh
# cd ../../../../


else
    echo -e """
-----------------------------------
     Base de donnée existante
-----------------------------------\n"""
fi

## Install plugins
echo -e """
-----------------------------------
     Installation des plugins
-----------------------------------\n"""

#composer clear-cache
composer install
# cd wp-content/plugins/wp-rocket
# composer install --no-dev --no-scripts
# cd ../../../

## Remove themes + plugins
rm -rf wp-content/themes/twenty*
rm wp-content/plugins/hello.php
rm -rf wp-content/plugins/akismet

## Activate plugins
wp plugin activate --all --quiet

## Update plugins translations
wp language plugin --all update

## Add BCrypt as mu-plugins
mkdir -p wp-content/mu-plugins
cp scaffold/mu-plugins/wp-password-bcrypt.php wp-content/mu-plugins

## Git configuration
# Remove .git if scaffolder has already been cloned
#rm -rf .git

## Install theme
echo -e """
-----------------------------------
      Installation du thème
-----------------------------------\n"""

cd wp-content/themes
git clone git@github.com:symtere/wordpress-blank-theme.git dfakto
wp theme activate dfakto

## Clean
#rm -rf test/

## Displays final settings
echo -e """
-------------------------------------------------------"""
#echo "  WP Version: $(wp core version) | Blog public: $(wp option get blog_public)"
echo "  Login:" $site_url"/wp-admin"
echo "  User:" $admin_user
echo "  Password:" $admin_user_password
echo -e """
-------------------------------------------------------\n"""
