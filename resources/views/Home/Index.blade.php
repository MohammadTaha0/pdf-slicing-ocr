<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OCR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="row justify-content-center gy-2 w-100 m-0 p-0">
        <div class="col-10">
            <form id="imageForm" class="form" enctype="multipart/form-data">
                <div class="row row-cols-2 gy-4 justify-content-center align-items-center bg-light py-3">
                    <div class="col-12">
                        <h3 class="text-center">Upload Image File</h3>
                    </div>
                    <div class="col">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="file" class="form-control" name="image" accept=".jpg">
                            <input type="hidden" name="get" value="true">
                            <button type="submit" id="uploadBtn" class="btn btn-outline-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-10 m-auto p-0">
            <table class="table table-bordered w-100 shadow m-auto align-middle text-center">
                <thead>
                    <tr>
                        <th>cnic</th>
                        <th>silsila</th>
                        <th>gahrana</th>
                        <th>name</th>
                        <th>address</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
                {{ csrf_field() }}
            </table>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $("#imageForm").on("submit", function(e) {
            var formdata = new FormData(this);
            e.preventDefault();
            $.ajax({
                type: "post",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#uploadBtn").html($("#uploadBtn").html() +
                        `<span class="spinner-border spinner-border-sm ms-4" role="status" aria-hidden="true"></span>`
                        );
                },
                success: function(response) {
                    console.log(response);
                    $("#uploadBtn").html('Upload');
                    $("#tbody").html(response);
                }

            });
        });
        $("#tbody").on('click', '[data-role="update"]', function() {
            console.log('triggered');
            let cnic = $(this).attr('data-id');
            let type = $(this).attr('data-type');
            let inpValue = $("#" + type + "-" + cnic).val();
            $.ajax({
                type: "post",
                url: "",
                data: {
                    _token: $("[name='_token']").val(),
                    cnic: cnic,
                    type: type,
                    inpValue: inpValue,
                },
                success: function(response) {
                    $("#tbody").html(response);
                }
            });
        });
    });
</script>

</html>
