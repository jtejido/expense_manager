<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$title}}</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/animate.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/paper-dashboard.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/themify-icons.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    </head>
    <body>
        <div id="app">
            <index></index>
        </div>
        

        <script src="{{asset('js/jquery.min.js')}}" ></script>
        <script src="{{asset('js/app.js')}}" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"></script>
        <script src="{{asset('js/bootstrap.min.js')}}" ></script>
        <script src="{{asset('js/demo.js')}}" ></script>
        <script src="{{asset('js/paper-dashboard.js')}}" ></script>
        <script src="{{asset('js/jquery.sharrre.js')}}" ></script>
        <script src="{{asset('js/chartist.min.js')}}" ></script>
        <script src="{{asset('js/bootstrap-notify.js')}}" ></script>
        <script src="{{asset('js/bootstrap-checkbox-radio.js')}}" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        
    </body>
</html>