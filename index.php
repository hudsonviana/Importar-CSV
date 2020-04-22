<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar CSV</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>

    <!-- JAVASCRIPT -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  
    <!-- DataTable -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
</head>
<body>
    <div class="container">
        <h3 style="text-align: center;">Edição e Importação de Arquivo CSV</h3>
        <div class="form">
            <form action="" method="post" enctype="multipart/form-data" id="upload_csv">
                <div class="row">
                    <div class="col-md-2">
                        <label for="">Selecionar CSV</label>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="csv_file" id="csv_file" accept=".csv">
                    </div>
                    <div class="col-md-5">
                        <input type="submit" value="Upload" name="upload" id="upload" class="btn btn-info">
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </form>
        </div>
        <div id="csv_file_data" class="mt-4"></div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#upload_csv').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'fetch.php',
                method: 'POST',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    var html = '<table class="table table-sm table-striped table-bordered">';
                    if (data.column) {
                        html += '<tr>';
                        for (var count = 0; count < data.column.length; count++) {
                            html += '<th>' + data.column[count] + '</th>';
                        }
                        html += '</tr>';
                    }

                    if (data.row_data) {
                        for (var count = 0; count < data.row_data.length; count++) {
                            html += '<tr>';
                            html += '<td class="student_name" contenteditable>' + data.row_data[count].student_name + '</td>';
                            html += '<td class="student_phone" contenteditable>' + data.row_data[count].student_phone + '</td></tr>';
                        }
                    }

                    html += '</table>';
                    html += '<div class="text-center"><button type="button" id="import_data" class="btn btn-success mt-2">Importar</button></div>';

                    $('#csv_file_data').html(html);
                    $('#upload_csv')[0].reset();
                }
            })
        })

        $(document).on('click', '#import_data', function() {
            var student_name = [];
            var student_phone = [];

            $('.student_name').each(function() {
                student_name.push($(this).text());
            });

            $('.student_phone').each(function() {
                student_phone.push($(this).text());
            });

            $.ajax({
                url: 'import.php',
                method: 'POST',
                data: {student_name:student_name, student_phone:student_phone},
                success: function(data) {
                    $('#csv_file_data').html('<div class="alert alert-success">Dados importados com sucesso!</div>');
                }
            })
        })
    })
</script>
</html>