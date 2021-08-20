# Windoo interview template

## Requirements

- PHP v8.0 with sqlite extension
- Symfony CLI (https://symfony.com/download)
- Composer (https://getcomposer.org/download/)
- Node JS v14

## Installation

Run these commands to install the project.

```shell
# you may change the last argument to an appropriate folder  
git clone git@github.com:remibrat/interview-template.git ~/windoo-interview
cd ~/windoo-interview
composer install
npm install
```

## Development

Run these two commands in two separated terminals.

- `symfony serve`
- `npm run watch`

You can now access your website on https://127.0.0.1:8000.

## Connection

Run this command in the terminal.

- `php bin/console doctrine:fixtures:load`

You can now log in the website with these credentials :

- `User  : user@dev`
- `Admin : admin@dev`

- `Password : !aTFEPHom9`