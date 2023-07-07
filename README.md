<img src="https://i.imgur.com/g3d79iJ.png">


# About

This repository is for those who want to create an online store for their project in a Rust game.


# Installation
First, we need to clone the repository to the folder where the application will be located.
```
git clone https://github.com/msavchin/PrismStore.git ./
```
Next, you need to install the Composer and npm packages in the application folder.
```
composer install
```
```
npm install
```
Now we need to build the entire frontend
```
npm run build
```
For development
```
npm run dev
```
Next, be sure to copy the .env.example file to the .env name and configure it, i.e. enter the data from the database, data from PayPal, Steam API key. You also need to generate the api key and application key using the commands below
```
php artisan key:generate
```
```
php artisan api-key:generate 
```
The next step is to migrate the database. Don't forget to change the SteamID to yours in database/seeders/DatabaseSeeder.php
```
php artisan migrate --seed
```
(optional): if you want to enable <a href="https://inertiajs.com/server-side-rendering">Server Side Rendering</a>, you need to enter the command
```
php artisan inertia:start-ssr
```

# A plugin for your server
Download <a href="https://github.com/msavchin/PrismCart_plugin">the oxide plugin</a> and set up the configuration, replace the ApiUrl with the link to your application and the ApiKey, which you can find in the .env file.
