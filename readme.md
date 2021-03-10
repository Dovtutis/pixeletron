# Pixeletron - add a pixel!

Pixeletron is a webpage with register and login system, where registered users can add pixels of different size and color to the field which is used by all users.

## Tasks which vere required for this page
- Register and Login system with validation.
- Pixel creation system, where it's possible to select pixel size and color. 
- Pixel creation validation system, which validates if the space for new pixel is empty and valid.
- Pixel edit and delete systems with validation, where user can edit and delete his pixels.
- Activity Log where user can see his actions of adding, editing and deleting pixels.

## How to set it up

1. create mysql database
1. Create table 'users' in database

    CREATE TABLE `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `firstname` varchar(255) NOT NULL,
    `lastname` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf32
1. Create table 'pixels' in database

    CREATE TABLE `pixels` (
    `pixel_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `coordinate_x` int(255) NOT NULL,
    `coordinate_y` int(255) NOT NULL,
    `color` varchar(255) NOT NULL,
    `size` int(255) NOT NULL,
    PRIMARY KEY (`pixel_id`),
    KEY `pixels` (`user_id`),
    CONSTRAINT `pixels` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf32
   
1. Create table 'activitylog'' in database

    CREATE TABLE `activitylog` (
    `log_id` int(11) NOT NULL AUTO_INCREMENT,
    `pixel_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `coordinate_x` int(255) NOT NULL,
    `coordinate_y` int(255) NOT NULL,
    `color` varchar(255) NOT NULL,
    `size` int(64) NOT NULL,
    `action` varchar(255) NOT NULL,
    `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`log_id`),
    KEY `constraint1` (`pixel_id`),
    KEY `constraint2` (`user_id`),
    CONSTRAINT `constraint2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf32

1. Make changes in config.php.
    1. change DB_HOST
    1. change DB_USER
    1. change DB_PASS
    1. change DB_NAME
    1. change APPROOT
    1. change URLROOT
    1. change SITENANE
    1. change APPVERSION

1. Make changes in .htaccess which is located './public/.htaccess'
    
