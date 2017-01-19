<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet" type="text/css">

        <style>

            body {
                margin: 0px;
                padding: 30px;
                font-weight: 400;
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

            @if( isset($rootNode) )
            <table>
            @include("recursive", array("node" => $rootNode, "level" => 0 )  )
            </table>
            @endif

            <br><br>

            <table>
            @include("iterative", array('categories' => $categories_i) )
            </table>

            <br><br>

            <table>
            @include("iterative", array('categories' => $categories_iq) )
            </table>



        </div>
    </body>
</html>
