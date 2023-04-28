<html>

<head>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css">
</head>

<body>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Position</th>
                <th>Position</th>
            </tr>
        </thead>
       
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Position</th>
                <th>Position</th>
            </tr>
        </tfoot>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                lengthMenu: [
            [  50,100],
            [ 50,100],
        ],
        rowGroup: {
                    dataSrc: [0]
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "http://localhost/ims/reportbtl",
                    type: "POST",
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        // if (XMLHttpRequest.status == 500) {
                        //     localStorage.removeItem("token");
                        //     location.href = base_url;
                        // }
                    }
                },
                order: [
                    [0, 'asc']
                ],
                
                columnDefs: [{
                    targets: [0],
                    visible: false
                }]
            });
        });
    </script>
</body>

</html>