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