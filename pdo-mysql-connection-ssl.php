<?php
class databaseClass_ssl extends PDO{
    
          protected $engine = 'mysql';
          protected $host = 'localhost';
	        protected $port = 3306;
          protected $database = 'database_ssl';
          protected $user = 'pdo';
          protected $pass = 'pass';
          protected $dns;
          protected $DbPrefix = 'do_';

   public function __construct(){ 
     try{     
          if(!empty($this->database)){
            /* This exists as of PHP 5.3.7 and MySQL 5.6  */
                  $this->dns = $this->engine.':host='.$this->host.';port='.$this->port.';dbname='.$this->database.';';
                  parent::__construct($this->dns, $this->user, $this->pass, array(
				  /*
				   Stałe połączenia są znane jako sposób na poprawę wydajności. 
				   PHP sprawdza czy istnieje już identyczne połączenie
				  z wcześniej pozostawała otwarta. Jeżeli istnieje, używa go.
				  Jaki sens pozostał otwarty? Trwałe połączenia to połączenia,
				  które nie zamykają się, gdy wykonanie skryptu kończy.'Identyczne'
				  to połączenie, które zostało otwarte dla tego samego hosta,
				  z tej samej nazwy użytkownika i hasa  
				  PDO używa takiej składni podobnie jak poconect PDO :: ATTR_PERSISTENT => true. Stawiamy w konstruktorze PDO:
				  */
				              PDO::ATTR_PERSISTENT => true, // pcoonect otwarte połaczenie 
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'', /* UTF-8 */
                      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, /* bufor */
                      PDO::MYSQL_ATTR_KEY       =>'/client-key.pem',
                      PDO::MYSQL_ATTR_SSL_CERT  =>'/client-cert.pem',
                      PDO::MYSQL_ATTR_SSL_CA    =>'/ca.pem')); /* lista dozwolonych szyfrów wykorzystanych do szyfrowania SSL. */
                 }else{
                     return false;
                 }      
          }catch(PDOException $e){
            return 'Połączenie nie mogło zostać utworzone.<br />'.$e->getMessage().'<br />'.strval($e->getCode()).'<br />'.$e->getFile().'<br />'.
                        $e->getTrace().'<br />'.strval($e->getLine()).'<br />'.$e->getPrevious().'<br />';
          }
    }
  public function dbprefix(){  
       return $this->DbPrefix;
    }     
}
