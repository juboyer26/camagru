# camagru


A basic web app similar to Instagram, that allows users to upload images, apply stickers, like and comment on images.


## Requirements

* Xampp https://www.apachefriends.org/index.html

## Installation

#### How to download source code:
- Click clone / download

#### How to set up and configure XAMPP:
 
1. Place the downloaded Camagru folder into the installed path "C:\xampp\htdocs"

2. Next navigate to "C:\xampp\php\php.ini"
- Look for the heading "[mail function]"
- Set SMTP=smtp.gmail.com
- smtp_port=587
- sendmail_from = ENTER YOUR EMAIL HERE
- sendmail_path = ""C:\xampp\sendmail\sendmail.exe" -t"
- Save and close php.ini

3. Next navigate to "C:\xampp\sendmail\sendmail.ini"
- Look for the heading "[sendmail]"
- Set smtp_server=smtp.gmail.com
- Set smtp_port=587
- Set auth_username = ENTER YOUR EMAIL HERE
- Set auth_password = ENTER YOUR GMAIL PASSWORD
- Save and close sendmail.ini

#### How to run the program
1. Open XAMPP
- Click on the start button for "Apache"
- Click on the start button for "MySQL"
2. Open a web browser of your choosing
- Type the following in your search bar "http://localhost/camagru/"


## Testing
Tests that are executed:
* Preliminary checks, used PHP, no external frameworks (aside from css), config files in the correct location. Used PDOs
* Webserver starts
* Create an account
* Log in
* Capture a picture with the webcam / upload an image
* Change user credentials

Expected outcomes:
* Backend code written in PHP
* No frameworks used (aside from css)
* database.php + setup.php in the config folder
* Used PDOs
* Web server starts on localhost
* Able to register
* Able to log in
* Able to capture photos
* Able to change credentials
