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
                    <th>ID</th>
                    <th>Title</th>
                    <th>Release Year</th>
                    <th>Description</th>
                    <th>Image</th>
                </tr>
            </thead>
        </table>
    </div>


<!-- Bootstrap JS (jQuery first, then Popper.js, then Bootstrap JS) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<!-- Datatable JS -->
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>

<!-- Skripta učitava navbar iz fajla kako ne bi smo ponavljali kod -->
<script>
    $(function(){
        $("#navigation").load("/includes/navbar.php");
    });
</script>

<script>
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
            // Simple binding JSON fields to data columns
            { data: 'id' },
            { data: 'title' },
            { data: 'release_year' },
            { data: 'description' },
            { 
            data: 'image_path',
            // Function for custom changes on every row for this column
            render: function (data, type, row) {
                // Create html code for every img column
                return '<img src="' + data + '" alt="Movie Image" style="max-width: 100px; max-height: 100px;">';
            }
        }
        ],
        // Filters
        // revisionSubject: revisionSubject,
    });
</script>
</body>
</html>
