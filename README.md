# Reporn API

## 🏃 Run the project

### Requirements
Be sure to have done the Symfony technical requirements :
https://symfony.com/doc/current/setup.html#technical-requirements

### Clone the repository :

    git clone https://github.com/team-reporn/api.git
    
### Setup the project :

Install packages :

    composer install
    
Create database :

    php bin/console doctrine:database:create
    
Load users :

    php bin/console doctrine:fixtures:load
