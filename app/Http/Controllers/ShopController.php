<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Record;
//use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Json;


class ShopController extends Controller
{
    // Master Page: http://vinyl_shop.test/shop or http://localhost:3000/shop
    public function index(Request $request)
    {
        $genre_id = $request->input('genre_id') ?? '%'; //OR $genre_id = $request->genre_id ?? '%';
        $artist_title = '%' . $request->input('artist') . '%'; //OR $artist_title = '%' . $request->artist . '%';

//        $records = Record::get();
        $records = Record::with('genre')
            ->where(function ($query) use ($artist_title, $genre_id) {
                $query->where('artist', 'like', $artist_title)
                    ->where('genre_id', 'like', $genre_id);
            })
            ->orWhere(function ($query) use ($artist_title, $genre_id) {
                $query->where('title', 'like', $artist_title)
                    ->where('genre_id', 'like', $genre_id);
            })
            ->orderBy('artist')
            ->paginate(12)
            ->appends(['artist' => $request->input('artist'), 'genre_id' => $request->input('genre_id')]);

        // Longer version with if not (if there is no cover found or cover is null)
//        foreach ($records as $record) {
//            if (!$record->cover) {
//                $record->cover = 'https://coverartarchive.org/release/' . $record->title_mbid . '/front-250.jpg';
//            }
//        }

        // Shorter version (with null coalescing operator)
        foreach ($records as $record) {
            // Als er een cover bij het record hoort gebruik dan deze cover, anders zoek naar de cover op music brainz
            $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";
        }


        $genres = Genre::orderBy('name')
            ->has('records')        // Only genres that have one or more records
            ->withCount('records')  // Add a new property 'records_count' to the Genre models/objects, to show how manny records the genre has
            ->get()
            ->transform(function ($item, $key) {
                // Set first letter of name to uppercase and add the counter (new name to use in dropdown)
                $item->nameWithCount = ucfirst($item->name) . ' (' . $item->records_count . ')';
                // Name of the genre with a capital
                $item->name = ucfirst($item->name);
                //  Remove all fields that you don't use inside the view
                unset($item->created_at, $item->updated_at, $item->records_count);
                return $item;
            });

        $result = compact('genres', 'records');

//        $result = compact('records');           // compact('records') is the same as ['records' => $records]
        Json::dump($result);            // open http://vinyl_shop.test/shop?json
        return view('shop.index', $result);
    }

    // Detail Page: http://vinyl_shop.test/shop/{id} or http://localhost:3000/shop/{id}
    public function show($id)
    {

        //        return "Details for record $id";
        //        return view('shop.show', ['id' => $id]);  // Send $id to the view

        $record = Record::with('genre')->findOrFail($id); // When no record is find the method findOrFail wil return a 404 | not found page
        // dd($record);

        // WE CANT'T LOOP TROUGH THIS SO WE CAN'T USE THE transform() METHOD!

        // Real path to cover image
        // De cover van dat specifieke record wordt opgehaald van die site
        $record->cover = $record->cover ?? "https://coverartarchive.org/release/$record->title_mbid/front-250.jpg";

        // Combineer artist + title
        $record->title = $record->artist . ' - ' . $record->title;

        // Links to MusicBrainz API (used by jQuery)
        // https://wiki.musicbrainz.org/Development/JSON_Web_Service
        $record->artistUrl = 'https://musicbrainz.org/ws/2/artist/' . $record->artist_mbid . '?inc=url-rels&fmt=json';
        $record->recordUrl = 'https://musicbrainz.org/ws/2/release/' . $record->title_mbid . '?inc=recordings+url-rels&fmt=json';

        // If stock > 0: button is green, otherwise the button is red
        $record->btnClass = $record->stock > 0 ? 'btn-outline-success' : 'btn-outline-danger';

        // You can't overwrite the attribute genre (object) with a string, so we make a new attribute
        $record->genreName = $record->genre->name;

        // Remove attributes you don't need for the view
        unset($record->genre_id, $record->artist, $record->created_at, $record->updated_at, $record->artist_mbid, $record->title_mbid, $record->genre);

        $result = compact('record');
        Json::dump($result);
        return view('shop.show', $result);
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre')->withDefault();   // a record belongs to a genre
    }

    // Alternative master page
    public function alternate(Request $request)
    {
        $genres = Genre::orderBy('name')
            ->has('records')        // only genres that have one or more records
            ->get()
            ->transform(function ($item, $key) {
                // Set first letter of the genre to uppercase
                $item->name = ucfirst($item->name);
                //  Remove all fields that you don't use inside the view
                unset($item->created_at, $item->updated_at, $item->records_count);
                return $item;
            });

        $records = Record::orderBy('artist')
            ->get();

        $result = compact('genres', 'records');

//        $result = compact('records');           // compact('records') is the same as ['records' => $records]
        Json::dump($result);            // open http://vinyl_shop.test/shop?json
        return view('shop.alternate', $result);
    }
}
