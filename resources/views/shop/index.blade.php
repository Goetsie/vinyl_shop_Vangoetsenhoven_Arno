@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop</h1>

    {{--    Add a basic form to the view--}}
    <form method="get" action="/shop" id="searchForm">
        <div class="row">
            <div class="col-sm-8 mb-8">
                <input type="text" class="form-control" name="artist" id="artist"
                       value="{{ request()->artist }}" placeholder="Filter Artist Or Record">
            </div>
            <div class="col-sm-4 mb-4">
                <select class="form-control" name="genre_id" id="genre_id">
                    <option value="%">All genres</option>
                    @foreach($genres as $genre)
                        {{--                        <option value="{{ $genre->id }}">{{ ucfirst($genre->name) }} ({{ $genre->records_count }})</option>--}}
                        <option value="{{ $genre->id }}" {{ (request()->genre_id == $genre->id ? 'selected' : '') }}>{{
                            $genre->name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
    </form>
    <hr>
    {{--        Give feedback if the collection is empty--}}
        @if ($records->count() == 0)
            <div class="alert alert-danger alert-dismissible fade show">
                @if (request()->genre_id == "%")
                    Can't find any artist or album with <b>'{{ request()->artist }}'</b> for this genre
                @else
{{--                                Hier zou niet de id moeten komen te staan maar de naam van het genre--}}
{{--                                Kijk exercise 4 Master page--}}
                    Can't find any artist or album with <b>'{{ request()->artist }}'</b> for the genre
                    <b>'{{ request()->genre_id }}'</b>
                @endif
{{--                Can't find any artist or album with <b>'{{ srequest()->artist }}'</b> for this genre--}}

{{--                            Can't find any artist or album with <b>'{{ request()->artist }}'</b> for the genre <b>'{{ $genres[request()->genre_id]->name }}'</b>--}}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

{{--    @if ($records->count() == 0)--}}
{{--        <div class="alert alert-danger alert-dismissible fade show">--}}
{{--            @if (request()->genre_id == "%")--}}
{{--                Can't find any artist or album with <b>'{{ srequest()->artist }}'</b> for this genre--}}
{{--            @else--}}
{{--                Can't find any artist or album with <b>'{{ request()->artist }}'</b> for the genre--}}
{{--                <b>'{{ request()->genre_id }}'</b>--}}
{{--            @endif--}}
{{--            --}}{{--            Can't find any artist or album with <b>'{{ request()->artist }}'</b> for this genre--}}
{{--            <button type="button" class="close" data-dismiss="alert">--}}
{{--                <span>&times;</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    @endif--}}


    {{ $records->links() }}
    <div class="row">
        @foreach($records as $record)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex flex-row">
                <div class="card cardShopMaster" data-id="{{ $record->id }}">
                    <img class="card-img-top" src="/assets/vinyl.png" data-src="{{ $record->cover }}" ...>
                    <div class="card-body">
                        <h5 class="card-title">{{ $record->artist }}</h5>
                        <p class="card-text">{{ $record->title }}</p>
                        <a href="#!" class="btn btn-outline-info btn-sm btn-block">Show details</a>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <p>{{ $record->genre->name }}</p>
                        <p>
                            € {{number_format($record->price, 2)}}
                            <span class="ml-3 badge badge-success">{{ $record->stock }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $records->links() }}
@endsection

@section('script_after')
    <script>
        $(function () {
            // Get record id and redirect to the detail page
            $('.card').click(function () {
                record_id = $(this).data('id');
                $(location).attr('href', `/shop/${record_id}`); //OR $(location).attr('href', '/shop/' + record_id);
            });
            // Replace vinyl.png with real cover
            $('.card img').each(function () {
                $(this).attr('src', $(this).data('src'));
            });
            // Add shadow to card on hover
            $('.card').hover(function () {
                $(this).addClass('shadow');
            }, function () {
                $(this).removeClass('shadow');
            });
            // submit form when leaving text field 'artist'
            $('#artist').blur(function () {
                $('#searchForm').submit();
            });
            // submit form when changing dropdown list 'genre_id'
            $('#genre_id').change(function () {
                $('#searchForm').submit();
            });
        })
    </script>
@endsection
