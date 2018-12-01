<p align="center"><img src="https://skovdev-my.sharepoint.com/:i:/g/personal/mathias_skovdev_net/EXm0R0BGsl9GqIr3BWN0gnIBRShPLgbcy3IS2LOXWQfAuw?e=5c6aw3"></p>

<p align="center">Website for sending SMS from your browser. Can be easily modified to work with your SMS Gateway provider.</p>

## Features
Send SMS to a specific number.<br>
Send SMS to single or multiple contacts.<br>
Phonebook - Add, edit & delete contacts.<br>
Users - Add, edit & delete users.<br>
History - View sent SMSes.<br>

## Installation
Go to install.php and follow the instructions. (for added security please move backend/config/database.ini to a directory outside the document root after the installation. And edit backend/config/mysql_conn.php with the new path.)<br>

## Customization
Edit backend/config/config.php - to customize the application.

## Support
### Browsers
Tested working in the following browsers:<br>
Edge >= 25.10<br>
Chrome >= 54.0<br>
Firefox >= 45.0<br>
IE >= 11.6<br>
Might work with older versions, but it hasn't been tested..

### APis
The project was tested using JustSMS.dk APi while under development. But can be easily modified to fit any APi.<br>
Edit backend/config/config.php to do so.

## Demo
... Coming sone.

It should be noted that this project was made as a temporary solution years ago, and currently lacks error handling, etc.
