This project is build with PHP and communicate with Databases Mysql.
and the application deployed on the server is attached to a telegram bot via the setWebhooks command. 
So the application will interpret the messages of the users of the bot and return a corresponding result

Prerequisites

    - Php 
    - Mysql 

How to Use the bot

1. create a SQL data base (mysql) and import the file "bot_db.sql"

2. Modify the file "connexion.php"  with the access parameter of your database

3. Create a bot telegram and paste the bot token in your source code in the variable $token 
and link your website with it, modify and paste this URL :

(if you are working localy, you need to use Ngrok to have a public url)

https://api.telegram.org/bot[_____Telegram bot token_____]/setWebhook?url=[___URL of your web site____]/index.php&allowed_updates=["message", "edited_channel_post", "callback_query"]


