- Instalacija:
    public folder treba da bude document root za web server (virtual host), ostali folderi ne treba da budu javno dostipni. PHP moze da pristupi config/database.php fajlu u kome se nalaze kredencijali za bazu podataka. 
    Takođe bi fajl koji sadrži kredencijale ili druge poverljive informacije vezane za razvojno / produkciono okruženje, trebao da bude u .gitignore i da se ne nalazi na gitu, ali zbog jednostavnosti to sada nije urađeno.
    U config/apache.conf se nalazi primer podešavanja za virtual host

- Baza podataka: (Mysql ili MariaDB)
    Dump baze podatka se nalazi u config/database.sql i sadrži test podatke koji se mogu odmah prikazati u tabeli
    U fajlu config/database.php se nalaze kredencijali za povezvanje sa bazom podataka, i moguće je promeniti ime baze, user ili password ukoliko je potrebno.

- Aplikacija je strukturirana prema MVC paternu, u app folderu imena skripti odgovaraju akcijama u kontorleru, a logika za interakciju sa bazom je odvojena u modele.

- Impletiran je kompletan CRUD za nosioci_osiguranja. dodatna_lica u bazi su povezana sa nosioci_osiguranja preko stranog ključa u relaciji 1 na više i na nivou baze je podešeno da se izmena i brisanje na nosioci_osiguranja odražavaju i nad dodatna_lica.

- Kod čitanja iz nosioci_osiguranja za tabelu (paginacija), jednim SQL upitom je rešeno kompletno prikupljanje podataka sa left join i group_concat i time je izbegnut n+1 query problem.

- Za interakciju sa bazom korišćeni su PDO prepared statements, kako bi se onemogućio sql query injection napad. 

- Na frontu, polja za dodatna lica se dinamički kreiraju, svaki novokreirani input dinamički dobija jedinstven id preko koga mu pristupamo. Struktura se čuva u nizu i moguće je dinamičko brisanje i dodavanje novih inputa po potrebi.

Validacija je rešena dinamički, na osnovu konfiguracionog niza. Podržane su validacije: obavezno polje, minimalan i maksimalan broj karaktera i email, i svakom inputu se može dodeliti proizvoljan set validacija.
Validacione greške se prikazuju ispod inputa u kome je nastala greška. 
Takođe su implementirane backend validacije pre krajnjeg upisa u bazu.