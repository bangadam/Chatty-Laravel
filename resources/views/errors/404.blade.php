<!DOCTYPE html>
<html>
    <head>
        <title>404 Not Found</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: rgb(4, 4, 4);
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                  Maaf Halaman yang anda cari tidak ada :(
                </div>
                <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    </body>
</html>
