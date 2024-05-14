- Instalacija
    public folder treba da bude document root za web server (virtual host), ostali folderi ne treba da budu javno dostipni. PHP moze da pristupi config/database.php fajlu u kome se nalaze kredencijali za bazu podataka. 
    Takođe bi fajl koji sadrži kredencijale ili druge poverljive informacije vezane za razvojno / produkciono okruženje, trebao da bude u .gitignore i da se ne nalazi na gitu, ali zbog jednostavnosti to sada nije urađeno.
    U config/apache.conf se nalazi primer podešavanja za virtual host

- Baza podataka (Mysql ili MariaDB)
    Dump baze podatka se nalazi u config/db.sql.
    U fajlu config/database.php se nalaze kredencijali za povezvanje sa bazom podataka, i moguće je promeniti ime baze, user ili password ukoliko je potrebno.

- Testiranje validacije
    Kod upisa u bazu (index.php) implementirane su  validacija na frontendu, kao i backend validacija
    Za testiranje backend validacije, može se isključiti frontend validacija tako što se zakomentariše konfiguracioni niz u public/index.php:238 red a otkomentariše public/index.php:239
    
