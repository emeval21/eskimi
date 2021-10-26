**How to Install Application**

1. Create and add database credentials in the .env file
2. Framework and dependencies version can be located at composer.json file in the root folder
3. On your terminal run composer update
4. After update, run php artisan cache:clear
5. run php artisan migrate
6. run php artisan db:seed


<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


**Task description**:

Using the Laravel framework you will need to create a simple application for managing advertising campaigns. 

**Advertising campaign consists of fields**:

1. Name - string format.
2. Dates (`from` and `to`) - date format.
3. Total budget (in USD) - float format (2 decimal places).
4. Daily budget (in USD) - float format (2 decimal places).
5. Creative upload - multiple banner images of any size can be added. - image file upload.

**User should be able to**:

1. create and edit an advertising campaign;
2. see all created advertising campaigns: name, date, daily budget, total budget, and a creative preview button on a single web page;
3. creative preview button should show advertising campaign’s uploaded creatives in a popup (same page);
4. navigate from campaign create/edit to campaign listing page and the other way around.

**Technical requirements**
Two API endpoints should be created:
1. Endpoint for submitting a new advertising campaign.
2. Endpoint for listing the advertising campaigns and their info.
3. 
For the creative preview button, create a reusable Vue.js component. No need to alter any CSS files or spend time making the user interface look really nice.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
"# eskimi" 
"# eskimi" 
