# Installed PHP Packages
- doctrine/dbal: Framework to allow changing table columns in Laravel
- laravel/ui: Scaffolding to generate front-end and Bootstrap CSS
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

# Assumptions & Explanations
- Developed with PHP 7.4.11
- Developed with MaridDB 10.5.6
- Used `https://swapi.dev/` for API calls
- Used Laravel version 7 to satisfy the requirement that application is executable with PHP 7.2
- Using Laravel Blade template with the exact script name to display HTML as it is the recommended way of utilising Laravel's powerful MVC 
- Created a main service class (`App\Services\MainService`) which has public methods that execute the individual scripts. This is for easier import and testing.
    - `public function getAllCharacters` --> `characters_jedi.php`
    - `public function getAllMammals` --> `mammal_homeworlds.php`
    - `public function importCharactersToDB` --> `import_characters.php`
    - `public function updateCharactersToDB` --> `update_characters.php`
    - `public function insertCharacterToDB` --> `create_character.php`
- All SWAPI URLs used are stored in `<project-directory>/config/swapi.php` 
- When importing all characters from SWAPI into DB:
    - It will follow SWAPI URL pagination to get all characters
    - All received data are validated and sanitised before inserting into DB
    - Before insertion, it will first truncate table `swapi_characters`
    - It will insert characters in batches of 20 records. (This can be changed in file `<project-directory>/config/constant.php` under `batch_insert`)
- Data validation for importing, updating, and creating characters:
    - height: has to be numeric; if a string is received, the height will be saved as `null`
    - mass: has to be numeric; if a string is received, the mass will be saved as `null`
    - birth_year: has to be in the forms of: 13ABY / 13BBY / 13 ABY / 13 BBY; if an invalid value is received, the birth_year will be saved as `null`
    - homeworld: validated by doing a search API call to SWAPI and checking that **only one result** is returned 
    - species: validated by doing a search API call to SWAPI and checking that **only one result** is returned
- When running the DB seeder it will:
    - Use FastExcel to read CSV data located in `<project-directory>/storage/imports/updated_characters_data.csv`
    - Import read data to table `updated_character_data` to be used to update records on table `swapi_characters` 
- When updating characters in table `swapi_characters` from table `updated_character_data`:
    - Any invalid value will not get updated i.e. when there is a record in `updated_character_data` with an invalid mass value, the corresponding record's mass in `swapi_characters` will not get updated  
    - If the script cannot find a record in `swapi_characters` with the same name, it will not create a new record
- For create character page:
    - Built in combination of Laravel Blade Template and React.js
    - Added client and server side validation
    - Client side validation is handled via Formik and Yup
    - Server side validation is handled with Laravel Form Request and calling SWAPI for checking homeworld and species name before DB insertion
    - Added CSRF handling in create character page to prevent XSS attack
    - All values in the character data sent to the server must be correct for the the record to be inserted into the Database
    - Any invalid value in the character data will cause the record to not be saved and an alert will show in the page to indicate that it is not saved 
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
- Log file location: `<project-directory>/storage/logs/laravel.log`

# Testing
- Server unit and feature testing with in-built PHPUnit from Laravel via $ `php artisan test`

# Future Improvements 
- Import Characters script could be improved to use Laravel Job & Queue. This will import all characters in the background, which would improve performance. 
