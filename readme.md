# Car Wash, A Laravel Code Test
 
## Precursory notes

 Since the project scope did not reference database design and or server setup I will be using a simple Apache Vhosts setup with a regular DB export for the data.
 
## Installation
 
Clone repo and run composer install, then follow instruction for Apache and DB

### Apache Setup 
 
Very basic vhosts setup 
```
 <VirtualHost *:80>
     DocumentRoot "/var/www/html/Car-Wash/public"
     ServerName localhost
     <Directory "/var/www/html/Car-Wash/public">
         AllowOverride All
         Order allow,deny
         Allow from all
     </Directory>
 </VirtualHost>
```

### Database

Import database in the root directory called car-wash.sql and update .env file to match database location / port (note the .env would not be version controlled in a normal setting for security)

## Design and Development Methodology.

1: Download and setup basic laravel package.

2: Setup and design simple database to reflect product requirements.

3: Create laravel models that map to database tables so that I can access the information through eloquent.

4: Create helper functions in the model to help with common data manipulation. 

5: Download a few fonts and CSS libraries to help with front end.

6: Setup front end process to collect information about the car.

7: Linked up front end to the backend to finalize transaction / record information. 

8: Created Ajax request to submit data and display errors if permitting.

9: Created functions for saving / creating vehicles and washes.

10: Created function, route and view for displaying and retrieving previous washes and their relevant information.

11: Connected it all together / bug fixed.