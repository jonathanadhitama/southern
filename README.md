# Installed PHP Packages
- doctrine/dbal: Passport for OAUTH authentication
- laravel/ui: Scaffolding to generate front-end
- rap2hpoutre/fast-excel: Fast excel for importing CSV Data

# Installed JS Packages:
- axios: HTTP Client for calling REST API
- formik: Form validation library for React
- lodash: Library for utility functions
- react: Main library for rendering front-end
- yup: Validation Schema for Formik

# Initial Setup
- Navigate to project directory via Terminal
- Install composer packages: $ `composer install`
- Install JS packages: $ `npm i`
- Generate environment file via copying the example: $ `cp .env.example .env`
- Modify environment values for:
    - DB_HOST= Database Host
    - DB_DATABASE= Database name to use
    - DB_USERNAME= Username to access Database
    - DB_PASSWORD= Password to access Database
- Generate Laravel Application Key: $ `php artisan key:generate`
- Migrate DB: $ `php artisan migrate`
- Run Seeder: $ `php artisan db:seed`

# Assumptions
- Developed with PHP 7.4.11
- Developed with MaridDB 10.5.6
- Used Laravel version 7 to satisfy with requirements that application is executable with PHP 7.2
- Using blade template with the exact script name to display HTML page as it is the recommended way of utilising Laravel's powerful MVC. 
- Created a main service class (`App\Services\MainService`) which has public methods based on the individual scripts. This is so it easier to import and tested more easily.
    - `public function getAllCharacters` --> `characters_jedi.php`
    - `public function getAllMammals` --> `mammal_homeworlds.php`
    - `public function importCharactersToDB` --> `import_characters.php`
    - `public function updateCharactersToDB` --> `update_characters.php`
    - `public function insertCharacterToDB` --> `create_character.php`
- For create character page, added client and server side validation
    - Client side validation is handled via Formik and Yup
    - Server side validation is handled with Laravel Form Request and calling SWAPI for checking homeworld and species name before DB insertion
    - Added CSRF handling in create character page to prevent XSS attack
- Using Laravel query builder for any interactions with Database to prevent SQL injection attack 

# Running the application
- Navigate to project directory via Terminal
- Run Laravel Mix: $ `npm run dev`
- Run Laravel Server: $ `php artisan serve`
- Open web browser
- To view all character names in the movie Return of the Jedi navigate to: `http://localhost:8000/characters_jedi` 
- To view all species and their homeworld name in Star Wars film navigate to: `http://localhost:8000/mammal_homeworlds`
- To import all people from SWAPI into table `swapi_characters` navigate to: `http://localhost:8000/import_characters`
- To update all characters inside table `swapi_characters` from table `updated_character_data` navigate to: `http://localhost:8000/update_characters`
    - Make sure seeder has been ran first before navigating here, otherwise no character will be updated: $ `php artisan db:seed`
- To insert a new character into table `swapi_characters` navigate to: `http://localhost:8000/create_character`

# Testing
- Server unit and feature testing with in-built PHPUnit from Laravel via $ `php artisan test`

# Possible Improvements 
- Import Characters script could be improved to use Laravel Job & Queue. This will import all characters in the background, which could improve performance. 
