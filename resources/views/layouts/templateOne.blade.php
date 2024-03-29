<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{--fontes--}}
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
    {{--moment js--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
    {{--tailwindcss--}}
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    {{--favicon--}}
    <link rel="shortcut icon" href="{{URL::asset('img/favicon.ico')}}" type="image/x-icon" />
    {{--bootstrap 4--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--jquery 3.6--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{--poppover and tooltips--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    {{--icones--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    {{--mascarar numeros--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    {{--minha folha de estilos--}}
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    {{--DataTables--}}    
    <script src="{{ URL::asset('assets/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('assets/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('assets/datatables/datatables-demo.js') }}"></script>
    <link href="{{ URL::asset('assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    {{--FullCalendar--}}
    <link href="{{ URL::asset('assets/fullcalendar/lib/main.min.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/fullcalendar/lib/main.min.js')}}"></script>
    <script src="{{ URL::asset('assets/fullcalendar/lib/locales-all.min.js')}}"></script>
    {{--Moment JS--}}
    <script src="{{ URL::asset('assets/moment.js/moment.min.js')}}"></script>
    {{--jQuery Mask--}}
    <script src="{{ URL::asset('assets/jQuery-Mask/dist/jquery.mask.min.js')}}"></script>
    {{--Modais, Popover and Tooltip--}}
    <script language="JavaScript">    
        //função do purpose
        $(function () {
        $('[data-toggle="popover"]').popover()
        })
        //função tolltip
        $(function () {
        $('[data-tt="tooltip"]').tooltip()
        })
        //Exibição de Mensagem ao iniciar
        $(document).ready(function() {
          $('#modalmensagem').modal('show');
        });
        

        function routeEvents(route) {
            return document.getElementById('calendar').dataset[route];
        }

        $.ajaxSetup({ //sem isso aqui o ajax nao funciona no laravel
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
</head>
<body>
@yield('content')    
</body>
</html>