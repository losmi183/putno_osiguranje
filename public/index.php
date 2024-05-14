<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna / Unos novog osiguranja</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container-fluid">
        
        <div id="navigation"></div>

        <h1>Početna / Unos novog osiguranja</h1>

        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-md-12">
                    <h2>Forma za unos novog osiguranja</h2>
                    <form id="form-data">
                        <div class="row">
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

<script>
    $(function(){
        // Skripta učitava navbar iz fajla kako bi kod bio reusable
        $("#navigation").load("/includes/navbar.php");

        var vrsta_polise = "";
        var brojDodatnihOsiguranika = 0;
        var sviInputiValidni = true;
        var greske = [];
        // var obelezeniInputi = [];
        // var validacionaPoruka = '';


        /**
         * dodajDodatnogOsigurnaika - Funkcija dinamički kreira inpute za dodatnog osiguranika
         * 
         */ 
        function dodajDodatnogOsigurnaika (index) {
            var noviOsiguranik = '<div id="dodatniOsiguranik-' + index + '" class="row border my-2 p-3">';
            noviOsiguranik += '<div class="col-md-4">';
            noviOsiguranik += `<h3>Dodatni osiguranik ${index}</h3>`;
            noviOsiguranik += '<div class="form-group">';
            noviOsiguranik += '<label for="ime_prezime">Nosilac osiguranja (Ime i Prezime)*</label>';
            noviOsiguranik += '<input id="ime_prezime-' + index + '" type="text" class="form-control" name="ime_prezime[]" required>';
            noviOsiguranik += '</div></div>';
            noviOsiguranik += '<div class="col-md-4">';
            noviOsiguranik += '<div class="form-group">';
            noviOsiguranik += '<label for="datum_rodjenja">Datum rođenja*</label>';
            noviOsiguranik += '<input id="datum_rodjenja-' + index + '" type="date" class="form-control" required>';
            noviOsiguranik += '</div></div>';
            noviOsiguranik += '<div class="col-md-4">';
            noviOsiguranik += '<div class="form-group">';
            noviOsiguranik += '<label for="broj_pasosa">Broj pasoša*</label>';
            noviOsiguranik += '<input id="broj_pasosa-' + index + '" type="text" class="form-control" required>';
            noviOsiguranik += '</div></div></div>';            
            $('#dodatni-osiguranici').append(noviOsiguranik);
        }

        function validate(inputId) {
            // Selektujemo input polje na osnovu ID-ja koji je prosleđen funkciji 
            var value = $('#' + inputId).val();
            // proveravamo da li je vrednost input polja prazan string
            if (value == '' || value === null || value === undefined) {
                sviInputiValidni = false;
                // objekat sadrži koji je input i tekst poruke
                var greska = {};
                greska.input = inputId;
                greska.poruka = 'Polje ' + inputId + ' ne sme biti prazno. ';
                // dodajemo u niz greške 
                greske.push(greska);
            }
        }

        function prikaziGreske(greske) {
            sviInputiValidni = true;
                // Postavljanje crvene ivice oko nevalidnih input polja - niz greske
                greske.forEach(item => {
                    var $input = $('#' + item.input);
                    $input.addClass('border border-danger');
                    $input.after('<div class="error-message text-danger">' + item.poruka + '</div>');                
                });
        }

        /**
         * Kada se promeni vrednost u polju "datum_putovanja_do"
         * Proverava da li je datum_putovanja_do jednak ili posle datum_putovanja_od
         * Ispisuje koliko je dana razlika
         */
        $('#datum_putovanja_do').change(function() {
            var datumOd = new Date($('#datum_putovanja_od').val());
            var datumDo = new Date($(this).val());

            // Provera da li je datum putovanja DO nakon datuma putovanja OD
            if (datumDo < datumOd) {
                alert('Datum povratka sa putovanja ne može biti pre datuma polaska na putovanje!');
                $(this).val(''); // Resetujemo vrednost na prazno polje
            } else {
                // Izračunavanje razlike u danima i prikazivanje u #broj-dana
                var razlikaUDanima = Math.ceil((datumDo - datumOd) / (1000 * 60 * 60 * 24));
                $('#broj-dana').text(razlikaUDanima + ' dan(a)');
            }
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
        $('#dodatni-osiguranik').click(function(){
            brojDodatnihOsiguranika++;
            // Dodaje inpute za novog osiguranika
            dodajDodatnogOsigurnaika(brojDodatnihOsiguranika);
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
            const fields = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'telefon', 'email', 'datum_putovanja_od', 'datum_putovanja_do', 'vrsta_polise'];
            // Inputi dodatnog osiguranika 
            const fields2 = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa'];
            /**
             * validacija konfiguracioni niz - Obavezni inputi
             * Mogla bi se uraditi kompleksnija varijanta, svako polje po veći broj validacija
             * primer: ['ime_prezime': ['string', 'required'], email: ['email', 'required'] ... ]
             */
            const required = ['ime_prezime', 'datum_rodjenja', 'broj_pasosa', 'email', 'datum_putovanja_od', 'datum_putovanja_do'];
            // const required = [];

            // 1. Uklanjanje klasa 'border' i 'border-danger' sa svih input elemenata
            $('input').removeClass('border border-danger');
            // Uklanjanje svih after elemenata
            $('input').next('.error-message').remove();

            // 2.1 Iteriramo kroz niz polja i prikupljamo vrednosti iz inputa u data objekat
            fields.forEach(item => { 
                data[item] = $('#' + item).val();
                // Validacija inputa - samo ako je obavezno polje 
                if (required.includes(item)) {
                    validate(item);
                }
            });      

            // 2.2 Ako je grupno osiguranje i imamo dodatne osiguranike, dodajemo kao niz dodatnih osiguranika
            if(data.vrsta_polise === 'grupno' && brojDodatnihOsiguranika > 0) {
                data.dodatniOsiguranici = [];
                for(var i=1; i<=brojDodatnihOsiguranika; i++) {
                    var dodatniOsiguranik = {};
                    fields2.forEach(item => { // Iteriramo kroz niz polja
                        var id = item + '-' + i; // Dinamički formiramo ključeve
                        dodatniOsiguranik[item] = $('#' + id).val(); 
                        // Validacija inputa
                        if (required.includes(item)) {
                            validate(id);
                        }
                    });
                    data.dodatniOsiguranici.push(dodatniOsiguranik);
                }
            }

            // 3. Ako samo jedno obavezno polje nije popunjeno ovde se prekida izvršenje i šalje poruka
            if(greske.length > 0) {
                prikaziGreske(greske);
                greske = [];
                return false;
            }
            
            // 4. Ajax post na PHP skriptu za upis u bazu
            $.ajax({
                url: '/app/store.php',
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
                        data = [];
                        // Sve inpute resetujemo
                        $('input').val('');
                        $('#broj-dana').text('');
                    } else {
                        // Dobijamo validacione greške sa backenda u istom formatu
                        var decodedResponse = JSON.parse(response);
                        var backendGreske = decodedResponse.errors;
                        // Prikazujemo greške oko inputa
                        console.log(backendGreske)
                        if(backendGreske.length > 0 || backendGreske !== undefined) {
                            prikaziGreske(decodedResponse.errors);
                        }
                        // if(decodedResponse.errors !== undefined || decodedResponse.errors.length > 0) {
                        //     var greske2 = JSON.stringify(decodedResponse.errors);
                        //     alert(greske2);
                        // }
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
