<h1>Records</h1>

{{--<ul>--}}
{{--    <li>Record 1</li>--}}
{{--    <li>Record 2</li>--}}
{{--    <li>Record 3</li>--}}
{{--</ul>--}}

<ul>

<!--    --><?php
//
//    //    foreach ($records as $record) {
//    //        echo "<li> $record </li> \n";
//    //    }
//
//    ?>

    @foreach ($records as $record)
        <li>{{ $record }}</li>
    @endforeach


</ul>



