# MajestiCloud Account Management Website

This is a web user-friendly interface for MajestiCloudAPI that enables users to manage their accounts.

## Setup environment variables

Create this file: ```/engine/Environment.config.php``` with the following content, and set the variables with the values fitting your environment.

```php
<?php

define("API_ROOT", "http://api.cloud.lesmajesticiels.local/");
define("API_KEY", "dummy");
define("CLIENT_ID", "3850ef6d-95c2-11ed-acb3-6045cb22ab2e");
define("CLIENT_REDIRECT_URI", "http://cloud.lesmajesticiels.local/auth/continue.php");
define("CLIENT_SECRET", "Nz1G9R6MEF8rNf8brQaNQc7DQptbLeMnWxPL9MEhdQC6U4wwEi0sTE8kBxea");
```