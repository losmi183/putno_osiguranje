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
                                    <input type="text" class="form-control" id="ime_prezime" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datum_rodjenja">Datum rođenja*</label>
                                    <input type="date" class="form-control" id="datum_rodjenja" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="broj_pasosa">Broj pasoša*</label>
                                    <input type="text" class="form-control" id="broj_pasosa" required>
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
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datum_putovanja_od">Datum putovanja (OD)*</label>
                                    <input type="date" class="form-control" id="datum_putovanja_od" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datum_putovanja_do">Datum putovanja (DO)*</label>
                                    <input type="date" class="form-control" id="datum_putovanja_do" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vrsta_polise">Odabir vrste polise osiguranja*</label>
                                    <select class="form-control" id="vrsta_polise" required>
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
         * 1. Validacija svih inputa
         * 2. Pakovanje u niz
         * 3. Slanje Ajax-om u backend
         * 4. Prikazujemo poruku sa backenda / praznimo sve inpute ukoliko je uspešno dodavanje 
         */
        $('#potvrdi').click(function() {

            event.preventDefault(); 
            // Definišemo prazan objekat koji ćemo puniti podacima iz inputa
            var data = {};
            
            // Podaci glavnog osiguranika
            data.ime_prezime = $('#ime_prezime').val();
            data.datum_rodjenja = $('#datum_rodjenja').val();
            data.broj_pasosa = $('#broj_pasosa').val();
            data.telefon = $('#telefon').val();
            data.email = $('#email').val();
            data.datum_putovanja_od = $('#datum_putovanja_od').val();
            data.datum_putovanja_do = $('#datum_putovanja_do').val();
            data.vrsta_polise = $('#vrsta_polise').val();            

            // Ako je grupno osiguranje i imamo dodatne osiguranike, dodajemo kao niz dodatnih osiguranika
            if(data.vrsta_polise === 'grupno' && brojDodatnihOsiguranika > 0) {
                data.dodatniOsiguranici = [];
                for(var i=1; i<=brojDodatnihOsiguranika; i++) {
                    var dodatniOsiguranik = {};
                    dodatniOsiguranik.ime_prezime = $('#ime_prezime-' + i).val();
                    dodatniOsiguranik.datum_rodjenja = $('#datum_rodjenja-' + i).val();
                    dodatniOsiguranik.broj_pasosa = $('#broj_pasosa-' + i).val();
                    data.dodatniOsiguranici.push(dodatniOsiguranik);
                }
            }

            console.log(data);
        });

    });
</script>

</body>
</html>
