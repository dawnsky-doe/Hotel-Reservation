<!-- <?php
    // require './api/config.php';

    // if(empty($_SESSION["user"])){
    //     header("Location: login.php");
    // }else{
    //     if($_SESSION["user"] != "admin"){
    //         header("Location: index.php");
    //     }
    // }
?> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <script src="/jquery.min.js"></script>
    <link href="/datatables.min.css" rel="stylesheet">
    <script src="/datatables.min.js"></script>
    <script src="/day.min.js"></script>

</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        text-align: center;
    }

    body {
        background:rgb(101, 136, 100);
        padding-left: 100px;
        padding-right: 100px;
    }

    .main {
        max-width: 1280px;
        margin: 0 auto;
    }

    div.form{
        background:rgb(253, 255, 253);
        width: 100%;
        border-radius: 6px;
        margin: 100px auto;
        padding: 90px;
        margin-top: 100px;
    }

    .title {
        margin-bottom: 2rem;
        margin-top: 2rem;
    }

    table thead th {
        text-align: center !important;
        font-size: 19px;
    }

    button#logout {
        float: right;
        font-family: 'Poppins';
        padding: 1px 5px;
        margin: 0rem 1em;
        font-size: 17px;
        background-color: transparent;
        color: rgb(54, 114, 38);
        outline: none;
        border: 3px solid rgb(54, 114, 38);
        border-radius: 4px;
        cursor: pointer;
        pointer-events: all;
        transition: .3s;
        font-weight: 600;
    }

    .script {
        font-size: 122px;
    }
    .delete{
        color: white;
        font-size: 15px;
        background-color: red;
        padding: 3px;
    }
    .btn{
        color: white;
        font-size: 20px;
        background-color: green;
        border: 2px solid black;
        padding: 3px; 
        float: left;
    }

    .btn:hover{
        letter-spacing: .2rem;
    }



</style>
<body>
    <div class="main">
        <div class="form">
        <a href="admin_dashboard.php" class="btn">Home</a>
            <h1 class="title">Registered account</h1>
            <table id="table">
                <thead>
                    <tr>
                        <th><center>Name</center></th>
                        <th>Email</th>
                        <th>Id Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    

    <script>
        
        $(function(e) {

            $("#logout").click(function(e) {
                $.ajax({
                    type: "POST",
                    url: "/api/logout.php",
                    success: (res) => {
                        location.replace("/index.php")
                    }
                })
            })


            let table = new DataTable('#table', {
                ajax: "/api/get_accounts.php",
                ordering: false,
                columns: [
                    {
                        data: "fullname"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "id_number"
                    },
                    {
                        data: "id_number",
                        render: (data, meta, row) => {

                            return (`
                                <button id="${data}" class="delete btn-danger">DELETE</button>
                            `)
                        }
                    }
                ]
            });

            $("table tbody").on("click", "button", function(e) {
                const id = $(this).attr("id")
                $.ajax({
                    type: "DELETE",
                    url: `/api/get_accounts.php?id_number=${id}`,
                    success: (res) => {
                        table.ajax.reload()
                        alert("Deleted successfully")
                    }
                })
            })


            
            const refreshTimer = setInterval(() => {
                table.ajax.reload()
            }, 5000)
        })
    </script>
</body>
</html>