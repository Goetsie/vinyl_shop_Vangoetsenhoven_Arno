@extends('layouts.template')

@section('title', 'Shop_alt')

@section('main')
    <h1>Shop - alternative listing</h1>
{{--    <h2>{{ $record->genre->name }}</h2>--}}
{{--    @foreach($records as $record)--}}
{{--                <div class="col-sm-6 col-md-4 col-lg-3 mb-3">--}}
{{--                    <div class="card cardShopMaster" data-id="{{ $record->id }}">--}}
{{--                        <img class="card-img-top" src="/assets/vinyl.png" data-src="{{ $record->cover }}" ...>--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">{{ $record->artist }}</h5>--}}
{{--                            <p class="card-text">{{ $record->title }}</p>--}}
{{--                            <a href="#!" class="btn btn-outline-info btn-sm btn-block">Show details</a>--}}
{{--                        </div>--}}
{{--                        <div class="card-footer d-flex justify-content-between">--}}
{{--                            <p>{{ $record->genre->name }}</p>--}}
{{--                            <p>--}}
{{--                                € {{number_format($record->price, 2)}}--}}
{{--                                <span class="ml-3 badge badge-success">{{ $record->stock }}</span>--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--    <h2>{{ $record->genre->name }}</h2>--}}
{{--            @endforeach--}}
{{--    @foreach($genres as $genre)--}}
{{--        <h2>{{ $genre->name }}</h2>--}}
{{--        @foreach ($records as $record)--}}
{{--            <p>{{ $record->artist }} - {{ $record->title }} | Price: € {{ $record->price }} | Stock: {{ $record->stock }}</p>--}}
{{--        @endforeach--}}
{{--    @endforeach--}}

    @foreach($genres as $genre)
        <h2>{{ $genre->name }}</h2>

        <ul>

        @foreach ($records as $record)
            @if ($record->genre_id == $genre->id)
                <li><a href="/shop/{{ $record->id }}">{{ $record->artist }} - {{ $record->title }}</a> | Price: € {{  number_format($record->price,2) }} | Stock: {{ $record->stock }}</li>

            @endif
{{--            <p>{{ $genre->name }} {{ $genre->id }} <a href="">{{ $record->artist }} - {{ $record->title }}</a> | Price: € {{ $record->price }} | Stock: {{ $record->stock }}</p>--}}
        @endforeach

        </ul>

    @endforeach


{{--        Add a basic form to the view--}}
{{--    <form method="get" action="/shop" id="searchForm">--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-8 mb-8">--}}
{{--                <input type="text" class="form-control" name="artist" id="artist"--}}
{{--                       value="{{ request()->artist }}" placeholder="Filter Artist Or Record">--}}
{{--            </div>--}}
{{--            <div class="col-sm-4 mb-4">--}}
{{--                <select class="form-control" name="genre_id" id="genre_id">--}}
{{--                    <option value="%">All genres</option>--}}
{{--                    @foreach($genres as $genre)--}}
{{--                                                <option value="{{ $genre->id }}">{{ ucfirst($genre->name) }} ({{ $genre->records_count }})</option>--}}
{{--                        <option value="{{ $genre->id }}" {{ (request()->genre_id == $genre->id ? 'selected' : '')--}}
{{--                            }}>{{ $genre->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--    <hr>--}}
{{--        Give feedback if the collection is empty--}}
{{--    @if ($records->count() == 0)--}}
{{--        <div class="alert alert-danger alert-dismissible fade show">--}}
{{--            Can't find any artist or album with <b>'{{ request()->artist }}'</b> for this genre--}}
{{--            <button type="button" class="close" data-dismiss="alert">--}}
{{--                <span>&times;</span>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    @endif--}}


{{--    {{ $records->links() }}--}}
{{--    <div class="row">--}}
{{--        @foreach($records as $record)--}}
{{--            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">--}}
{{--                <div class="card cardShopMaster" data-id="{{ $record->id }}">--}}
{{--                    <img class="card-img-top" src="/assets/vinyl.png" data-src="{{ $record->cover }}" ...>--}}
{{--                    <div class="card-body">--}}
{{--                        <h5 class="card-title">{{ $record->artist }}</h5>--}}
{{--                        <p class="card-text">{{ $record->title }}</p>--}}
{{--                        <a href="#!" class="btn btn-outline-info btn-sm btn-block">Show details</a>--}}
{{--                    </div>--}}
{{--                    <div class="card-footer d-flex justify-content-between">--}}
{{--                        <p>{{ $record->genre->name }}</p>--}}
{{--                        <p>--}}
{{--                            € {{number_format($record->price, 2)}}--}}
{{--                            <span class="ml-3 badge badge-success">{{ $record->stock }}</span>--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--    {{ $records->links() }}--}}
{{--    <h1>Hoere</h1>--}}
@endsection
