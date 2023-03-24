# TuhaV2 phân hệ account

- Task in : https://pm.tuha.vn/projects/tuha-v2-acocunt

### Laravel Quick Start

1. Download and install `Node.js` from Nodejs. The suggested version to install is `14.16.x LTS`.

2. Start a command prompt window or terminal and change directory to [unpacked path]: 

3. Install the latest `NPM`:
   
        npm install --global npm@latest

4. To install `Composer` globally, download the installer from https://getcomposer.org/download/ Verify that Composer in successfully installed, and version of installed Composer will appear:
   
        composer --version

5. Install `Composer` dependencies.
   
        composer install

6. Install `NPM` dependencies.
   
        npm install

7. The below command will compile all the assets(sass, js, media) to public folder:
   
        npm run dev
        
   For DEV env
        
        npm run watch

8. Copy `.env.example` file and create duplicate. Use `cp` command for Linux or Max user.

        cp .env.example .env

    If you are using `Windows`, use `copy` instead of `cp`.
   
        copy .env.example .env
   
9. Create a table in MySQL database and fill the database details `DB_DATABASE` in `.env` file.

10. The below command will create tables into database using Laravel migration and seeder.
   
        php artisan migrate
   

#Quick Start for DEV

1. JS Sample 
   
        resources\assets\default\js\custom\single-page\sample.js
   
2. View Sample
   
        resources\views\pages\sample\index.blade.php
