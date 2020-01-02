<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $sortArray = [
            [
//                'name' => 'Name (A \'&#8594;\' Z)',
//                'name' => 'Name (A ' . chr ( 26 ) : string . ' Z)',
//                'name' => 'Name (A \&#8594; Z)',
                'name' => 'Name (A -> Z)',
                'sortBy' => 'name',
                'sortDirection' => 'asc',
            ],
            [
                'name' => 'Name (Z -> A)',
//                'name' => 'Name (Z &#8594; A)',
                'sortBy' => 'name',
                'sortDirection' => 'desc',
            ],
            [
//                'name' => 'Email (A &#8594; Z)',
                'name' => 'Email (A -> Z)',
                'sortBy' => 'email',
                'sortDirection' => 'asc',
            ],
            [
                'name' => 'Email (Z -> A)',
//                'name' => 'Email (Z &#8594; A)',
                'sortBy' => 'email',
                'sortDirection' => 'desc',
            ],
            [
                'name' => 'Not active',
                'sortBy' => 'active',
                'sortDirection' => 'asc',
            ],
            [
                'name' => 'Admin',
                'sortBy' => 'admin',
                'sortDirection' => 'desc',
            ],
        ];

        $name_email = '%' . $request->input('nameSearch') . '%';
        $sort = intval($request->input('sort'));

        $users = User::orderBy($sortArray[$sort]['sortBy'], $sortArray[$sort]['sortDirection'])
            // Via de tweede order by wordt bij sorteren op admin of active ook gesorteert op naam
             ->orderBy('name', 'asc')
            ->where('name', 'like', $name_email)
            ->orwhere('email', 'like', $name_email)
            ->paginate(12)
            ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);

        $result = compact('users', 'sortArray');
        \Facades\App\Helpers\Json::dump($result);
        return view('admin.users.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return redirect(admin/users2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // We don't have an option to create a new user.
        // A new user must register himself
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        return redirect(admin/users2);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {
        return redirect(admin/users2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, User $user)
    {

        // Als de user het toch heeft kunnen fixen om zijn eigen profiel aan te passen, zorgen we ervoor dat dit niet mogelijk is
        if (Auth::user()->id == $user->id) {

            // Een error noty tonen aan de gebruiker
            return response()->json([
                'type' => 'error',
                'text' => "Dear <b>$user->name</b>, <br> <br>It's not possible to change your own profile<br> <br>If you have any questions or dissatisfactions, feel free to contact us."
            ]);
        } else {

            // Serverside validatie
            $this->validate($request, [
                'name' => 'required|min:2|unique:users,name,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id
            ]);

            // Oude naam opslaan om daarna de juiste rij uit de tabel aan te kunnen passen
            $oldName = $user->name;
            $oldEmail = $user->email;
            $user->name = $request->name;
            $user->email = $request->email;

            // Als de checkbox van active niet aangevinkt is wordt de user op niet actief gezet
            if ($request->active == false) {
                $user->active = 0;
            } else {
                // Als de checkbox van active wel aangevinkt is wordt de user op actief gezet
                $user->active = 1;
            }

            // Als de checkbox van admin niet aangevinkt is, zal de user geen admin worden
            if ($request->admin == false) {
                $user->admin = 0;
            } else {
                // Als de checkbox van admin aangevinkt is, wordt de user een admin
                $user->admin = 1;
            }

            // Save de user in de database
            $user->save();

            // Return text for the noty and information needed to update the table row
            return response()->json([
                'type' => 'success',
                'text' => "The user <b>$user->name</b> has been updated",
                'id' => $user->id,
                "name" => $user->name,
                "oldName" => $oldName,
                'email' => $user->email,
                "oldEmail" => $oldEmail,
                'active' => $user->active,
                'admin' => $user->admin
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user)
    {

        // Als de user het toch heeft kunnen fixen om zijn eigen profiel te verwijderen zorgen we ervoor dat dit niet mogelijk is
        if (Auth::user()->id == $user->id) {

            // Een error noty tonen aan de gebruiker
            return response()->json([
                'type' => 'error',
                'text' => "Dear <b>$user->name</b>, <br> <br>In order not to exclude yourselve from <small>(the admin section of)</small> the application, you cannot delete your own profile. <br>If you have any questions or dissatisfactions, feel free to contact us."
            ]);
        } else {

            // Delete the user from the database
            $user->delete();

            // Een succes noty tonen aan de gebruiker
            return response()->json([
                'type' => 'success',
                'text' => "The user <b>$user->name</b> has been deleted"
            ]);
        }
    }

}
