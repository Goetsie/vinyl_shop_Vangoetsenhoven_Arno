@extends('layouts.template')

@section('title', 'Record')

@section('main')
    <h1>{{ $record->title }}</h1>
    <div class="row">
        <div class="col-sm-4 text-center">
            <img class="img-thumbnail" id="cover" src="/assets/vinyl.png" data-src="{{ $record->cover }}"
                 alt="{{ $record->title }}">
            <p>
                <a href="#!"
                   class="btn btn-sm  btn-block mt-3 {{ $record->btnClass }} {{ $record->stock == 0 ? 'disabled' : '' }}">
                    <i class="fas fa-cart-plus mr-3"></i>Add to cart
                </a>
            </p>
            <p class="text-left">Genre: {{ $record->genreName }}<br>
                Stock: {{ $record->stock }}<br>
                Price: € {{ number_format($record->price, 2) }} </p>
        </div>
        <div class="col-sm-8">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Track</th>
                    <th scope="col">Length</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script_after')
    <script>
        $(function () {
            // Replace the stock image vinyl.png with the real cover
            $('#cover').attr('src', $('#cover').data('src'));

            // Get tracks from MusicBrainz API
            $.getJSON('{{ $record->recordUrl }}')
                .done(function (data) {
                    console.log(data);

                    // loop over each track
                    $.each(data.media[0].tracks, function (key, value) {



                        // Maak een tabel row
                        // hier zou ook iets van if kunnen staan voor de lengte van de liedjes
                        let row = `<tr>
                            <td>${value.position}</td>
                            <td>${value.title}</td>
                            <td>${vinylShop.to_mm_ss(value.recording.length)}</td>
                        </tr>`

                        // Origanal
                        // In record met 31 staat de lengte van de track niet op deze positie maar wel dieper in value.recording.length
                        // <td>${vinylShop.to_mm_ss(value.length)}</td>

                        // Append the row to the tbody tag
                        $('tbody').append(row);
                    });
                })
                .fail(function (error) {
                    console.log(error);
                })
        });
    </script>
@endsection
