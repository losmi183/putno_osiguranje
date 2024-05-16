/**
 * Fajl sadrži funkcije koje se koriste više puta
 */


// Pomoćna funkcija proverava da li je datum validan
function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}

function brojDana(datumOd, datumDo) {
    // Tek kada su oba datuma selektovana/validna računamo i prikazujemo
    if (isValidDate(datumOd) && isValidDate(datumDo)) {
        // Provera da li je datum putovanja DO nakon datuma putovanja OD
        if (datumDo < datumOd) {
            alert('Datum povratka sa putovanja ne može biti pre datuma polaska na putovanje!');
            $(this).val(''); // Resetujemo vrednost na prazno polje
        } else {
            // Izračunavanje razlike u danima i prikazivanje u #broj-dana
            var razlikaUDanima = Math.ceil((datumDo - datumOd) / (1000 * 60 * 60 * 24));
            $('#broj-dana').text(razlikaUDanima + ' dan(a)');
        }
    }
}

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
    noviOsiguranik += '<div class="col-md-3">';
    noviOsiguranik += '<div class="form-group">';
    noviOsiguranik += '<label for="datum_rodjenja">Datum rođenja*</label>';
    noviOsiguranik += '<input id="datum_rodjenja-' + index + '" type="date" class="form-control" required>';
    noviOsiguranik += '</div></div>';
    noviOsiguranik += '<div class="col-md-4">';
    noviOsiguranik += '<div class="form-group">';
    noviOsiguranik += '<label for="broj_pasosa">Broj pasoša*</label>';
    noviOsiguranik += '<input id="broj_pasosa-' + index + '" type="text" class="form-control" required>';
    noviOsiguranik += '</div></div>';            
    noviOsiguranik += '<div class="col-md-1">';
    noviOsiguranik += `<button class="btn btn-danger" data-index="${index}">Izbaci</button>`;
    noviOsiguranik += '</div></div></div>';            
    $('#dodatni-osiguranici').append(noviOsiguranik);
}

/**
 * dodajDodatnogOsigurnaika - Funkcija dinamički kreira inpute za dodatnog osiguranika
 * Dodatno popunjava i value za input 
 */ 
function dodajDodatnogOsigurnaikaIPopuni (index, osiguranik) {
    var noviOsiguranik = '<div id="dodatniOsiguranik-' + index + '" class="row border my-2 p-3">';
    noviOsiguranik += '<div class="col-md-4">';
    noviOsiguranik += `<h3>Dodatni osiguranik ${index}</h3>`;
    noviOsiguranik += '<div class="form-group">';
    noviOsiguranik += '<label for="ime_prezime">Nosilac osiguranja (Ime i Prezime)*</label>';
    noviOsiguranik += '<input value="' + osiguranik.ime_prezime + '" id="ime_prezime-' + index + '" type="text" class="form-control" name="ime_prezime[]" required>';
    noviOsiguranik += '</div></div>';
    noviOsiguranik += '<div class="col-md-3">';
    noviOsiguranik += '<div class="form-group">';
    noviOsiguranik += '<label for="datum_rodjenja">Datum rođenja*</label>';
    noviOsiguranik += '<input value="' + osiguranik.datum_rodjenja + '" id="datum_rodjenja-' + index + '" type="date" class="form-control" required>';
    noviOsiguranik += '</div></div>';
    noviOsiguranik += '<div class="col-md-4">';
    noviOsiguranik += '<div class="form-group">';
    noviOsiguranik += '<label for="broj_pasosa">Broj pasoša*</label>';
    noviOsiguranik += '<input value="' + osiguranik.broj_pasosa + '" id="broj_pasosa-' + index + '" type="text" class="form-control" required>';
    noviOsiguranik += '</div></div>';            
    noviOsiguranik += '<div class="col-md-1">';
    noviOsiguranik += `<button class="btn btn-danger" data-index="${index}">Izbaci</button>`;
    noviOsiguranik += '</div></div></div>';            
    $('#dodatni-osiguranici').append(noviOsiguranik);
}

const validationRules = {
    'ime_prezime': ['required', { 'max': 255 }],
    'datum_rodjenja': ['required'],
    'broj_pasosa': ['required', { 'max': 20 }],
    'email': ['required', 'email', { 'max': 20 }],
    'datum_putovanja_od': ['required'],
    'datum_putovanja_do': ['required']
};

function validate(inputId, validationErrors) {
    
    // Selektujemo input polje na osnovu ID-ja koji je prosleđen funkciji 
    var value = $('#' + inputId).val();
    // Odvajamo samo tip inputa nezavisno od id (zbog dodatnik inputa)
    var inputType;
    if (inputId.indexOf('-') === -1) {
        inputType = inputId;
    } else {
        inputType = inputId.substring(0, inputId.indexOf('-'));
    }

    // Ako input nije u validacionim pravilima preskacemo
    if (!(inputType in validationRules)) {
        return; // Izlazak iz funkcije
    }

    var rules = validationRules[inputType];
    rules.forEach((rule) => {
        
        if (typeof rule === 'object') {

            var ruleName = Object.keys(rule)[0];
            var ruleValue = rule[ruleName];

            if(ruleName == 'max') {
                if(value.length > ruleValue) {
                    validationErrors.push({
                        inputId: inputId,
                        message: 'Maksimalni broj karaktera je ' + ruleValue
                    })
                }
            }
            if(ruleName == 'min') {
                if(value.length < ruleValue) {
                    validationErrors.push({
                        inputId: inputId,
                        message: 'Minimalni broj karaktera je ' + ruleValue
                    })
                }
            }
        }
        if(typeof rule === 'string') {
            if(rule == 'required') {
                if(value == '' || value === null || value === undefined) {
                    validationErrors.push({
                        inputId: inputId,
                        message: 'Polje mora biti popunjeno'
                    })
                }
            }
        }
        if (rule === 'email') {
            // Provera da li je value validna email adresa
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                validationErrors.push({
                    inputId: inputId,
                    message: 'Polje mora biti validna email adresa'
                })
            }
        }
    });
}