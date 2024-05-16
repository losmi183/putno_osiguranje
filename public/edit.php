<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmena osiguranja</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        
        <div id="navigation"></div>

        <h1>Izmena osiguranja</h1>

        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-md-12">
                    <h2>Forma za unos novog osiguranja</h2>
                    <form id="form-data">
                        <div class="row">
                            <input type="hidden" class="form-control" id="id">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ime_prezime">Nosilac osiguranja (Ime i Prezime)*</label>
                                    <input type="text" class="form-control" id="ime_prezime">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datum_rodjenja">Datum rođenja*</label>
                                    <input type="date" class="form-control" id="datum_rodjenja">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="broj_pasosa">Broj pasoša*</label>
                                    <input type="text" class="form-control" id="broj_pasosa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefon">Telefon</label>
                                    <input type="tel" class="form-control" id="telefon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email*</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                            </div>
                            <div class="col-md-4" >
                                <div class="row" id="od-do-datum">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="datum_putovanja_od">Datum putovanja (OD)*</label>
                                            <input type="date" class="form-control" id="datum_putovanja_od">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="datum_putovanja_do">Datum putovanja (DO)*</label>
                                            <input type="date" class="form-control" id="datum_putovanja_do">
                                        </div>
                                    </div>
                                    <div id="broj-dana" class="col-md-2 text-success"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vrsta_polise">Odabir vrste polise osiguranja</label>
                                    <select class="form-control" id="vrsta_polise">
                                        <option value="">Odaberi...</option>
                                        <option value="individualno">Individualno</option>
                                        <option value="grupno">Grupno</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display:none" id="dodatni-osiguranik" class="col-md-4">
                                <button class="btn btn-secondary btn-lg">Dodatni osiguranik</button>
                            </div>
                            <div class="col-md-12">
                                <button id="potvrdi" class="btn btn-primary btn-lg btn-block">Potvrdi</button>
                            </div>
                        </div>

                        <div id="dodatni-osiguranici">
                            <!-- Ovde će se dinamički dodavati dodatni osiguranici ako je odabrana grupna polisa -->
                        </div>
                        
                    </form>
                </div>


                <div class="col-md-6">
                    <button style="display: none;" id="dodatni-osiguranik" type="submit" class="btn btn-secondary btn-lg" style="display: none;">Dodatni osiguranik</button>
                    <div id="dodatni-osiguranici"></div>
                </div>
            </div>            
        </div>

    </div>



<!-- Bootstrap JS (jQuery first, then Popper.js, then Bootstrap JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>

<script>
    $(function(){
        // Skripta učitava navbar iz fajla kako bi kod bio reusable
        $("#navigation").load("/includes/navbar.php");

        var vrsta_polise = "";
        var brojDodatnihOsiguranika = 0;
        /**
         *  Evidentiramo id miniforme svaki put kada se klikne na Dodatni osiguranik
         *  Takođe izbacujemo iz niza kada se klikne na obriši za tog osiguranika
         */
        var nizDodatnihOsiguranika = [];

        const required = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'email', 'datum_putovanja_od', 'datum_putovanja_do'];
        // const required = [];
        // U ovaj niz pakujemo greske
        var validationErrors = [];

        var sviInputiValidni = true;
        var greske = [];    

        // Pomoću PHP dobijamo id iz query stringa 
        var id = <?php echo json_encode($_GET['id'] ?? ''); ?>;

        // AJAX GET zahtev ka /app/edit.php sa dodatim ID-om kao query string
        $.ajax({
            url: '/app/edit.php?id=' + id,
            type: 'GET',
            success: function(response) {

                var decodedResponse = JSON.parse(response);
                var nosilac_osiguranja = decodedResponse.nosilac_osiguranja;
            
                // Postavljanje vrednosti polja input elemenata na osnovu podataka iz JSON odgovora
                $('#id').val(nosilac_osiguranja.id);
                $('#ime_prezime').val(nosilac_osiguranja.ime_prezime);
                $('#datum_rodjenja').val(nosilac_osiguranja.datum_rodjenja);
                $('#broj_pasosa').val(nosilac_osiguranja.broj_pasosa);
                $('#telefon').val(nosilac_osiguranja.telefon);
                $('#email').val(nosilac_osiguranja.email);
                $('#datum_putovanja_od').val(nosilac_osiguranja.datum_putovanja_od);
                $('#datum_putovanja_do').val(nosilac_osiguranja.datum_putovanja_do);
                $('#vrsta_polise').val(nosilac_osiguranja.vrsta_polise);
                vrsta_polise  = nosilac_osiguranja.vrsta_polise;

                // DA prikaže u startu dugme za dodavanje
                if(nosilac_osiguranja.vrsta_polise == 'grupno') {
                    $('#dodatni-osiguranik').show();
                }
                
                // Iteriranje kroz dodatna lica i kreiranje seta inputa sa vrednostima koje su u JSON-u
                nosilac_osiguranja.dodatna_lica.forEach(function(osiguranik, index) {
                    dodajDodatnogOsigurnaikaIPopuni(index+1, osiguranik);
                    brojDodatnihOsiguranika++;
                    nizDodatnihOsiguranika.push(index+1);
                });

                // Računanje broja dana pri učitavanju
                var datumOd = new Date($('#datum_putovanja_od').val());
                var datumDo = new Date($('#datum_putovanja_do').val());        
                brojDana(datumOd, datumDo);
            },
            error: function(xhr, status, error) {
                console.error('Došlo je do greške prilikom izvršavanja GET zahteva ka /app/edit.php:', error);
            }
        });

        // on - hvata dogadjaj na dinamicki kreiranim elementima, data-index sadrzi index od kliknutog elementa
        $(document).on('click', '.btn-danger', function() {
            var index = $(this).data('index');
            // Uklanja kliknuti element na osnovu id diva koji je vraper 
            $('#dodatniOsiguranik-' + index).remove();
            var indexToRemove = nizDodatnihOsiguranika.indexOf(index);
            if (indexToRemove !== -1) {
                nizDodatnihOsiguranika.splice(indexToRemove, 1);
            }
            console.log(nizDodatnihOsiguranika)
        });

        // function validate(inputId) {
        //     // Selektujemo input polje na osnovu ID-ja koji je prosleđen funkciji 
        //     var value = $('#' + inputId).val();
        //     // proveravamo da li je vrednost input polja prazan string
        //     if (value == '' || value === null || value === undefined) {
        //         sviInputiValidni = false;
        //         // objekat sadrži koji je input i tekst poruke
        //         var greska = {};
        //         greska.input = inputId;
        //         greska.poruka = 'Polje ' + inputId + ' ne sme biti prazno. ';
        //         // dodajemo u niz greške 
        //         greske.push(greska);
        //     }
        // }

        function prikaziGreske(validationErrors) {
        // sviInputiValidni = true;
            // Postavljanje crvene ivice oko nevalidnih input polja - niz greske
            validationErrors.forEach(item => {
                var $input = $('#' + item.inputId);
                $input.addClass('border border-danger');
                $input.after('<div class="error-message text-danger">' + item.message + '</div>');                
            });
            console.log(validationErrors)
        }

        /**
         * Kada se promeni vrednost u polju "datum_putovanja_do"
         * Proverava da li je datum_putovanja_do jednak ili posle datum_putovanja_od
         * Ispisuje koliko je dana razlika
         */
        $('#datum_putovanja_do,#datum_putovanja_od').change(function() {
            var datumOd = new Date($('#datum_putovanja_od').val());
            var datumDo = new Date($('#datum_putovanja_do').val());        
            brojDana(datumOd, datumDo);
        });


        // Na osnovu vrednosti select-a prikazujemo/sakrivamo dugme za dodavanje dodatnog osiguranika
        $('#vrsta_polise').change(function(){
            vrsta_polise = $(this).val();
            if(vrsta_polise === 'grupno') {
                $('#dodatni-osiguranik').show();
            } else {
                $('#dodatni-osiguranik').hide();
            }            
        });

        // Uhvati klik događaj na dugmetu "Dodatni osiguranik"
        $('#dodatni-osiguranik').click(function() {
            brojDodatnihOsiguranika++;

            let rbr;
            // Ova logika dodaje naredni inkrement u nizDodatnihOsiguranika
            if (nizDodatnihOsiguranika.length === 0) {
                rbr = 1;
                nizDodatnihOsiguranika.push(rbr);
            } else {
                let najveci = Math.max(...nizDodatnihOsiguranika);
                rbr = najveci + 1
                nizDodatnihOsiguranika.push(rbr);
            }

            /**
             * Potom poyivamo funkciju dodajDodatnogOsigurnaika(rbr) koja kreira set inputa
             * Svaki id počinje sa rbr. Ovim smo ostvarili da imamo evidenciju svih setova inputa u nizu
             */
            dodajDodatnogOsigurnaika(rbr);
        });

        /**
         * Klik na Potvrdi
         * 1. uklanjanje starih validacionih poruka
         * 2. Pakovanje u niz i Validacija svih inputa
         * 3. obeležavanje inputa koji nisu validni i prikaz greške
         * 3. Slanje Ajax-om u backend
         * 4. Prikazujemo poruku sa backenda / praznimo sve inpute ukoliko je uspešno dodavanje 
         */
        $('#potvrdi').click(function() {

            /**
             * Početna konfiguracija
             */
            event.preventDefault(); 
            // Definišemo prazan objekat koji ćemo puniti podacima iz inputa
            var data = {};            
            // Svi inputi glavnog osiguranika - poklapaju se imena promenjivih sa css selektorima radi jednostavnosti
            const fields = ['id', 'ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'telefon', 'email', 'datum_putovanja_od', 'datum_putovanja_do', 'vrsta_polise'];
            // Inputi dodatnog osiguranika 
            const fields2 = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa'];

            // 1. Uklanjanje klasa 'border' i 'border-danger' sa svih input elemenata
            $('input').removeClass('border border-danger');
            // Uklanjanje svih after elemenata
            $('input').nextAll('.error-message').remove();

            // 2.1 Iteriramo kroz niz polja i prikupljamo vrednosti iz inputa u data objekat
            fields.forEach(item => { 
                data[item] = $('#' + item).val();
                // Validacija inputa - samo ako je obavezno polje      
                validate(item, validationErrors);
            });

            // 2.2 Ako je grupno osiguranje i imamo dodatne osiguranike, dodajemo kao niz dodatnih osiguranika
            if(data.vrsta_polise === 'grupno' && brojDodatnihOsiguranika > 0) {
                data.dodatniOsiguranici = [];

                // Koristiom nizDodatnihOsiguranika koji sadrzi informaciju sa indexima #
                nizDodatnihOsiguranika.forEach(index => {
                    var dodatniOsiguranik = {};
                    fields2.forEach(item => { // Iteriramo kroz niz polja
                        var id = item + '-' + index; // Dinamički formiramo ključeve
                        dodatniOsiguranik[item] = $('#' + id).val(); 
                        // Validacija inputa
                        validate(id, validationErrors);
                    });
                    data.dodatniOsiguranici.push(dodatniOsiguranik);
                });
            }

            // 3. Ako samo jedno obavezno polje nije popunjeno ovde se prekida izvršenje i šalje poruka
            if(validationErrors.length > 0) {
                prikaziGreske(validationErrors);
                // Resetujemo greske a i data niz
                validationErrors = [];
                data = [];
                return false;
            }
            
            // 4. Ajax post na PHP skriptu za upis u bazu
            $.ajax({
                url: '/app/update.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    // Provera da li je odgovor uspešan - nema validacionih grešaka
                    var decodedResponse = JSON.parse(response);
                    if (decodedResponse.success === true) {
                        // Obrada uspešnog odgovora
                        alert(decodedResponse.message);
                        // Praznimo data objekat sa prethodnim podacima
                    } else {
                        // Dobijamo validacione greške sa backenda u istom formatu
                        var decodedResponse = JSON.parse(response);
                        var backendGreske = decodedResponse.errors;
                        // Prikazujemo greške oko inputa
                        console.log(backendGreske)
                        if(backendGreske.length > 0 || backendGreske !== undefined) {
                            prikaziGreske(decodedResponse.errors);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    // Obrada greške ako dođe do problema sa AJAX zahtevom
                    console.error('Greška prilikom slanja na server:', error);
                }
            });

        });

    });
</script>

</body>
</html>
