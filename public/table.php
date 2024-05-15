<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled unetih polisa</title>    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Datatables css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
</head>
<body>

    <div class="container-fluid">
        <div id="navigation"></div>
        
        <h1>Pregled unetih polisa</h1>
    
        <table id="report" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Datum unosa polise</th>
                    <th>Ime i prezime osiguranika</th>
                    <th>Datum rođenja</th>
                    <th>Broj pasoša</th>
                    <th>Email</th>
                    <th>Datum početka putovanja</th>
                    <th>Datum završetka putovanja</th>
                    <th>Broj dana</th>
                    <th>Vrsta polise</th>
                    <th>Akcije</th>
                </tr>
            </thead>
        </table>

        <!--Modal za prikaz grupne polise  -->
        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Pregled grupnog osiguranja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Ime i prezime nosioca:</strong> <span id="imePrezime"></span></p>
                    <p><strong>Vrsta polise:</strong> <span id="vrstaPolise"></span></p>
                </div>
                </div>
            </div>
        </div>


    </div>


<!-- Bootstrap JS (jQuery first, then Popper.js, then Bootstrap JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<!-- Datatable JS -->
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

<script>
    // Funkcija za prikaz modala
    function showInfoModal(modalContent) {
        // Kreiranje modala sa Bootstrap modal komponentom
        var modal = $('<div class="modal fade" tabindex="-1" role="dialog"> \
                        <div class="modal-dialog" role="document"> \
                            <div class="modal-content"> \
                                <div class="modal-body">' + modalContent + '</div> \
                                <div class="modal-footer"> \
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> \
                                </div> \
                            </div> \
                        </div> \
                    </div>');

        // Dodavanje modala u telo dokumenta
        $('body').append(modal);

        // Prikaz modala
        modal.modal('show');
    }

    $('#report').DataTable({
        processing: true,
        serverSide: true, // Server side pagination mode on
        lengthMenu: [[5, 10, -1], [5, 10, "All"]], // Possible values for per page
        // 
        ajax: {
            url: '/app/paginate.php',
            data: function (d) {

            },
        },
        columns: [
            { data: 'datum_kreiranja' },  
            { data: 'ime_prezime' },
            { data: 'datum_rodjenja' },
            { data: 'broj_pasosa' },
            { data: 'email' },
            { data: 'datum_putovanja_od' },
            { data: 'datum_putovanja_do' },
            // Izračunavanje trajanja putovanja u danima
            { data: 'broj_dana' },
            { data: 'vrsta_polise' }, // Vrsta polise
            // Akcije
            { 
                data: null,
                render: function(data, type, row) {
                    if (row.vrsta_polise === 'grupno') {
                        var modalContent = '<div><p>Ime i prezime nosioca: ' + row.ime_prezime + '</p><p>Vrsta polise: ' + row.vrsta_polise + '</p>';
                        // Provera da li postoji polje dodatna_lica i dodavanje njegovog prikaza u modal
                        if (row.dodatna_lica && row.dodatna_lica.length > 0) {
                            modalContent += '<p>Dodatni osiguranici:</p><ul>';
                            row.dodatna_lica.forEach(function(osiguranik) {
                                modalContent += '<li>' + osiguranik + '</li>';
                            });
                            modalContent += '</ul>';
                        }
                        modalContent += '</div>';
                        return '<button onclick="showInfoModal(\'' + modalContent + '\')">Prikaži grupno osiguranje</button>';
                    } else {
                        return '';
                    }
                }
            }
        ],
        // Filters
        // revisionSubject: revisionSubject,
    });
</script>
</body>
</html>
