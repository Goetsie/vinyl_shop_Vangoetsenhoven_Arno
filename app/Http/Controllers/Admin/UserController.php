<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Json;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Is het gebruik van switchcase wel goed?
     * name en sort blijven niet onthouden worden bij gaan naar andere pagina
     * */
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

        $name_email = '%' . $request->input('nameSearch') . '%'; //OR $name_email = '%' . $request->nameSearch . '%';
        $sort = intval($request->input('sort'));

//        $sortArray = array("asc", "desc", "active", "admin");


        $users = User::orderBy($sortArray[$sort]['sortBy'], $sortArray[$sort]['sortDirection'])
//            via de tweede order by wordt bij sorteren op admin of active ook gesorteert op naam
//            ->orderBy('name', 'asc')
            ->where('name', 'like', $name_email)
            ->orwhere('email', 'like', $name_email)
            ->paginate(12)
            ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);

//        // array gebruiken met opties en waarden SWITCH CASE
//        switch ($sort) {
//            case "nameZA":
//                $users = User::orderBy('name', 'desc')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    // wat moet er bij de sort komen???????
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//                break;
//            case "emailAZ":
//                $users = User::orderBy('email')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//                break;
//            case "emailZA":
//                $users = User::orderBy('email', 'desc')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//                break;
//            case "active":
//                $users = User::orderBy('active')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//                break;
//            case "admin":
//                $users = User::orderBy('admin', 'desc')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//                break;
//            default:
//                $users = User::orderBy('name')
//                    ->where(function ($query) use ($name_email) {
//                        $query->where('name', 'like', $name_email);
//                    })
//                    ->orWhere(function ($query) use ($name_email) {
//                        $query->where('email', 'like', $name_email);
//                    })
//                    ->paginate(12)
//                    ->appends(['nameSearch' => $request->input('nameSearch'), 'sort' => $request->input('sort')]);
//        }

        $result = compact('users', 'sortArray');
        \Facades\App\Helpers\Json::dump($result);
        return view('admin.users.index', $result);
//        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // all the info needded is on the index file
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact('user');
        \Facades\App\Helpers\Json::dump($result);
        return view('admin.users.edit', $result);
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
//        $url = serialize($this);

        $this->validate($request, [
            'name' => 'required|min:2|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        // als active niet geselecteert is wordt de user op niet actief gezet
        if ($request->active == false) {
            $user->active = 0;
        } else {
            // als active wel geselecteert is wordt de user actief gezet
            $user->active = 1;
        }
        // als admin niet geselecteert is wordt user geen admin
        if ($request->admin == false) {
            $user->admin = 0;

        } else {
            // als admin wel geselecteert is wordt de user een admin
            $user->admin = 1;
        }
        $user->save();
        session()->flash('success', 'The user <strong>' . $request->name . '</strong> has been updated');
        return redirect('admin/users');
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
            session()->flash('danger', "Dear <b>$user->name</b>, <br> <br>In order not to exclude yourselve from <small>(the admin section of)</small> the application, you cannot delete your own profile. <br>If you have any questions or dissatisfactions, feel free to contact us.");
            return redirect('admin/users');
        } else {
            $user->delete();
            session()->flash('success', "The user <b>$user->name</b> has been deleted");
            return redirect('admin/users');
        }
    }
}
