## Property Api

This is a simple api that add and retrive save property. [Link to Postman Documentation](https://documenter.getpostman.com/view/13660696/2s8ZDeTdyQ).

## Setup
- Clone this repo: git clone https://github.com/omisteck/propertyAPI.git
- Composer install.
- Duplicate the .en.example and rename to .env
- Run Migration: php artisan migrate
- Start: php artisan serve
- Run test to confirm everything is work: php artisan test.

###  Notice
For the bulk upload sample use " Sample Bulk Upload.xlsx" file as format.

###  Highlights
Here are some highlights of this codebase 
- No cache was used because is a small project
- Retriving of saved property is paginated which dynamic
- Saving a property trigger an observer which log a successful save property , no fancy log system like slack etc
- Excel for multiple upload

## [Link to Postman Documentation of the Endpoints](https://documenter.getpostman.com/view/13660696/2s8ZDeTdyQ)