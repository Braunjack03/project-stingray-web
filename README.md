## Table of Contents

- [About](#about)
- [High Level Requirements](./REQUIREMENTS.md)
- [Getting Started](#getting_started)
- [Development Process](#dev_process)
- [Coding Standards](#coding_standards)

## About <a name = "about"></a>
This is the primary Larvel web application for "Project Stingray".  Stingray is a jobboard, company profile, and news website focusing on technology jobs and start-ups in the Florida area. Addtional information about the project can be found in the [requirements](./REQUIREMENTS.md).

The application stack is built on:
- PHP 8.0
- Laravel 8
- Intertia.js
- Vue2
- Vueity

## Getting Started <a name = "getting_started"></a>
Instructions assume that you're going to run the server directly on your machine, as opposed to Docker.  Dev environment should be easy to get running locally if you have PHP 8+, Composer and NodeJS installed. 

The preferred development database is MySQL. You can run MySQL out of Docker or directly on your local machine. 

Note: All commands are ran from the root of the project.
1. Clone Repo & Checkout this branch
2. Make sure you have your .env setup
    * ```cp .env.example .env && php artisan key:generate```
3. Install packages
    * ```composer install & npm install```
4. For development build the frontend using 
    * ```npm run watch-poll```
5. Initalize the database
    * ```php artisan migrate```
6. Serve Laravel Project
    * ```php artisan serve```
7. Load default seed data for the various categories and types
    * ```bash scripts/run_seeds```
8. For dev and QA load test data for job posts, companies, etc.  This will load approx 2000 jobs.
    * ```bash scripts/load_test_data```
## Development Process <a name = "dev_process"></a>
- All work will be managed out of Github issues and Github projects
- Code should be checked-in at least once a day
- We'll use trunk-based development.
    - Developers will work out of short-lived feature branches
    - After testing, developers will open a pull request to merge their branch into master
- The development branch will be automatically deployed to (http://dev.madeintampabay.org/) after each merge
- All new frontend features will have written requirements and/or wireframe diagrams
- Non-functional requirements such as logging and good security are important
- We're using Intertia.js so we don't have to spend time developing an API layer
- We'll write functional tests for important site features (TODO)
- We want to build as quickly as possible without compromising quality
- Minimize code duplication keep things DRY (don't repeat yourself)

## Coding Standards <a name = "coding_standards"></a>
One reason for selecting Laravel is because there are well established best practices on how to build web applications.  We should strive to follow convention as much as possible and avoid re-inventing the wheel. PHP standards documented in [PSR-12](https://www.php-fig.org/psr/psr-12/) will help keep our code clean.  

### Logging
All major actions should be logged to make troubleshooting and to improve security.  Some examples of what should be logged:
    - Log in (successful and unsuccessful)
    - User creation
    - Profile updates
### ID usage
Database IDs of important entities should not be exposed.  UUIDs should be used instead.   
This applies to the following:  
 - User ID
 - Company ID
 - Job Post ID
 - User or company assets such as resumes  

Right:  
```https://examples.com/show_user?id=bf6b67e5-5b68-47df-985e-973516f52498```  
Wrong:  
```https://examples.com/show_user?id=23```
