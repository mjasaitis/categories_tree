<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100,700" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 20px;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            td{
                padding: 0 10px;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form action="/save" method="post" >
            {{ csrf_field() }}
            
            @if(isset( $category ) )
                Create new category in <b>{{ $category->title }}</b> 
            @else
                Create top category: 
            @endif
            
            <input type="text" name="title" >
            @if( Input::get("pid") )<input type="hidden" name="pid" value="{{ Input::get('pid') }}" >@endif
            <input type="submit" value="Save" >
            </form>

            <br>

            <table>
            @include("recursive", array("pid" => 0, "level" => 0 )  )
            </table>

            <br><br>

            <table>
            @include("iterative"  )
            </table>


        </div>
    </body>
</html>
