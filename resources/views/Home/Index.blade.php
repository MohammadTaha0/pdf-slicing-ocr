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
            <form id="pimgForm" class="form" enctype="multipart/form-data">
                <div class="row row-cols-2 gy-4 justify-content-center align-items-center bg-light py-3">
                    <div class="col-12">
                        <h3 class="text-center">Preview</h3>
                    </div>
                    <div class="col-7">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="file" class="form-control form-control-sm" name="image" id="pImg"
                                accept=".jpg">
                            <input type="hidden" name="view" value="true">
                            <label for="" class="ps-3 pe-1 my-auto">X-</label>
                            <input type="number" name="x" id="x" value="1000"
                                class="form-control form-control-sm" placeholder="Enter X-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Y-</label>
                            <input type="number" name="y" id="y" value="170"
                                class="form-control form-control-sm" placeholder="Enter Y-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Height-</label>
                            <input type="number" name="height" id="height" value="160"
                                class="form-control form-control-sm" placeholder="Enter Y-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Upto-</label>
                            <input type="number" name="upto" id="upto" value="16"
                                class="form-control form-control-sm" placeholder="Enter upto Value">
                        </div>

                        <div class="col-12 p-0 m-0" id="preImgs">
                            <img src="" alt="" class="w-100 d-block">
                        </div>
                    </div>
                </div>
            </form>

            <form id="imageForm" class="form" enctype="multipart/form-data">
                <div class="row row-cols-2 gy-4 justify-content-center align-items-center bg-light py-3">
                    <div class="col-12">
                        <h3 class="text-center">Upload Image File</h3>
                    </div>
                    <div class="col-7">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="hidden" name="get" value="true">
                            <label for="" class="ps-3 pe-1 my-auto">X-</label>
                            <input type="number" name="x" id="x" value="1000"
                                class="form-control form-control-sm" placeholder="Enter X-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Y-</label>
                            <input type="number" name="y" id="y" value="170"
                                class="form-control form-control-sm" placeholder="Enter Y-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Height-</label>
                            <input type="number" name="height" id="height" value="160"
                                class="form-control form-control-sm" placeholder="Enter Y-axis Value">
                            <label for="" class="ps-3 pe-1 my-auto">Upto-</label>
                            <input type="number" name="upto" id="upto" value="16"
                                class="form-control form-control-sm" placeholder="Enter upto Value">
                        </div>
                        <div class="input-group">
                            <input type="file" class="form-control form-control-sm" name="image"
                                accept=".jpg">
                            <input type="hidden" name="get" value="true">
                            <button type="submit" id="uploadBtn"
                                class="btn btn-sm btn-outline-primary">Upload</button>
                        </div>

                    </div>
                </div>
            </form>

            <form id="insertForm" class="form" enctype="multipart/form-data">
                <div class="row row-cols-2 gy-4 justify-content-center align-items-center bg-light py-3">
                    <div class="col-12">
                        <h3 class="text-center">Insert Records</h3>
                    </div>
                    <div class="col-7">
                        <div class="input-group">
                            <select name="uc" id="uc" class="form-select form-select-sm">
                                <option value="">Select UC</option>
                                @foreach ($ucs as $uc)
                                    <option value="{{ $uc->id }}">{{ $uc->districtName . ' ' . $uc->UCName }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="blockcode" class="form-control form-control-sm"
                                placeholder="Type BlockCode..." value="">
                            <button type="submit" id="insertBtn"
                                class="btn btn-sm btn-outline-primary">Insert</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-10 m-auto p-0">
            <table class="table table-bordered w-100 shadow m-auto align-middle text-center">
                <thead>
                    <tr class="text-capitalize">
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
        function Preview() {
            $("#preImgs").html('');
            $.ajax({
                url: "",
                type: "post",
                data: new FormData($("#pimgForm")[0]),
                processData: false,
                contentType: false,
                success: function(pre) {
                    console.log(pre);
                    if (pre.status === 200) {
                        $("#preImgs").html('');
                        let imgs = '';
                        for (let i = 0; i < pre.imgs.length; i++) {
                            console.log(pre.imgs[i])
                            imgs +=
                                `<img src='${pre.imgs[i]}?${new Date().getTime()}' class='w-100 d-block h-100' />`;
                        }
                        $("#preImgs").html(imgs);
                        // setInterval(() => {
                        //     $.ajax({
                        //         type: "post",
                        //         url: "",
                        //         data: {
                        //             imgs: pre.imgs,
                        //             deleted: 'true',
                        //             _token: $("[name='_token']").val()
                        //         },
                        //         success: function(resp) {
                        //             console.log(pre.imgs.length +
                        //                 ' Images Deleted!');
                        //         },
                        //     });
                        // }, 2000);
                    }
                }
            });

        }
        $("#pImg").change(function() {
            let x = $("#x").val();
            let y = $("#y").val();
            let height = $("#height").val();
            let img = $("#pImg").val();
            if (x !== "" && y !== "" && height !== "" && img !== "") {
                Preview();
            }
        });
        $("#x").keyup(function() {
            let x = $("#x").val();
            let y = $("#y").val();
            let height = $("#height").val();
            let img = $("#pImg").val();
            if (x !== "" && y !== "" && height !== "" && img !== "") {
                Preview();
            }
        });
        $("#y").keyup(function() {
            let x = $("#x").val();
            let y = $("#y").val();
            let height = $("#height").val();
            let img = $("#pImg").val();
            if (x !== "" && y !== "" && height !== "" && img !== "") {
                Preview();
                console.log('kl');
            }
        });
        $("#height").keyup(function() {
            let x = $("#x").val();
            let y = $("#y").val();
            let height = $("#height").val();
            let img = $("#pImg").val();
            if (x !== "" && y !== "" && height !== "" && img !== "") {
                Preview();
            }
        });
        $("#imageForm").on("submit", function(e) {
            var formdata = new FormData(this);
            e.preventDefault();
            $.ajax({
                type: "post",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#uploadBtn").html('Uploading');
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
