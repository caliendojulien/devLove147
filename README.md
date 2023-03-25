# DevLove

## Capture d'écran

![accueil](github/img/accueil.png)

## Technologies
- Symfony 6.2.7
- PHP 8.2.1
- Composer 2.5.1
- Symfony cli 5.4.2

## Installation

```bash
composer install
npm install
symfony console doctrine:database:create
symfony console doctrine:schema:update --force
```

## lancement

```bash
symfony serve
npm run watch
```