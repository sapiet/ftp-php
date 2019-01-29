# ftp-php

$ftp = new FTP($host);
$ftp->login($login, $password);
$ftp->save($source, $destination);
