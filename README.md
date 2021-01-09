# camagru


A basic web app that allows users to take pictures using a webcam and superimpose predefined images onto them.

## Getting Started

### Installation

* Install xampp https://www.apachefriends.org/index.html
How to set up and configure XAMPP:
*Place the downloaded Camagru folder into the installed path "C:\xampp\htdocs"
*Ensure less secure apps enabled on gmail (as I used gmail for sending email)
*Next navigate to "C:\xampp\php\php.ini"
*Look for the heading "[mail function]"
*Set SMTP=smtp.gmail.com
*smtp_port=587
*sendmail_from = ENTER YOUR EMAIL HERE
*sendmail_path = ""C:\xampp\sendmail\sendmail.exe" -t"
*Save and close php.ini
*Next navigate to "C:\xampp\sendmail\sendmail.ini"
*Look for the heading "[sendmail]"
*Set smtp_server=smtp.gmail.com
*Set smtp_port=587
*Set auth_username = ENTER YOUR EMAIL HERE
*Set auth_password = ENTER YOUR GMAIL PASSWORD
*Save and close sendmail.ini

