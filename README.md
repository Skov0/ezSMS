<p align="center"><img src="https://westeurope1-mediap.svc.ms/transform/thumbnail?provider=spo&inputFormat=jpg&cs=fFNQTw&docid=https%3A%2F%2Fskovdev-my.sharepoint.com%3A443%2F_api%2Fv2.0%2Fdrives%2Fb!Yjr162b4_Uef4V-1lVj4iz7A4HGw20VOsemXmBid7gb-V_m3JsGYRI5ct7cPs4p2%2Fitems%2F015AOPJTDZWRDUARVSL5DKRCXXAVRXJATS%3Fversion%3DPublished&access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTBmZjEtY2UwMC0wMDAwMDAwMDAwMDAvc2tvdmRldi1teS5zaGFyZXBvaW50LmNvbUBjZDk2ZWRiZC01MTJkLTQ5OWEtYWIyYi01ZTY2MTM5MWU1ZjMiLCJpc3MiOiIwMDAwMDAwMy0wMDAwLTBmZjEtY2UwMC0wMDAwMDAwMDAwMDAiLCJuYmYiOiIxNTQzNzUzNDg0IiwiZXhwIjoiMTU0Mzc3NTA4NCIsImVuZHBvaW50dXJsIjoiRnhvUUJPd1V1dHBNbkpVR0dYWTd5UWpNUFlreFJDaVhXUk1YYlBIRGw2dz0iLCJlbmRwb2ludHVybExlbmd0aCI6IjExNyIsImlzbG9vcGJhY2siOiJUcnVlIiwiY2lkIjoiWkdFeE1HRTRPV1V0TmpBd1lTMHdNREF3TFRNM05XWXRZVFJpWldZMlpEQmpNamN3IiwidmVyIjoiaGFzaGVkcHJvb2Z0b2tlbiIsInNpdGVpZCI6IlpXSm1OVE5oTmpJdFpqZzJOaTAwTjJaa0xUbG1aVEV0TldaaU5UazFOVGhtT0RoaSIsInNpZ25pbl9zdGF0ZSI6IltcImttc2lcIl0iLCJuYW1laWQiOiIwIy5mfG1lbWJlcnNoaXB8bWF0aGlhc0Bza292ZGV2Lm5ldCIsIm5paSI6Im1pY3Jvc29mdC5zaGFyZXBvaW50IiwiaXN1c2VyIjoidHJ1ZSIsImNhY2hla2V5IjoiMGguZnxtZW1iZXJzaGlwfDEwMDNiZmZkYWUzMjRmZGVAbGl2ZS5jb20iLCJ0dCI6IjAiLCJ1c2VQZXJzaXN0ZW50Q29va2llIjoiMyJ9.VXlZSDh2cVl0eHR3dFRxU0hpU214NkFkTFh0NFlPTVY5dTEwdUNCMjArRT0&encodeFailures=1&width=850&height=250&srcWidth=850&srcHeight=250"></p>

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
