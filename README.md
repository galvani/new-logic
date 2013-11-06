new-logic
=========

Test pro NewLogic.cz by Jan Kozak <jan@galvani.cz>

Requirements:
redis server
mail() - working on the server

Configuration:
==============
 - please, see: app/etc/config.yml

```json
app:
  log:
    filename: log/app.log			# logfile
    verbosity: \Monolog\Logger::DEBUG
  notification:
    sms-notification:
      recipients: ['774877060']
      credentials:				# fake credentials for sms api
        uri: /blah
        username: neno
        password: none
    email-notification:
      recipients: ['jan@galvani.cz']
      parameters:
        sender: 'notification@galvani.cz'
        subject: 'Phone number change at NewLogic.cz'

  wkhtmltopdf:					# executable to produce pdf from web
      binary: bin/wkhtmltopdf-amd64 # https://code.google.com/p/wkhtmltopdf/
  newLogicUrl: http://www.newlogic.cz
  redis:
    host: localhost
    prefix: 'newlogic:'
```

@todo:
	
