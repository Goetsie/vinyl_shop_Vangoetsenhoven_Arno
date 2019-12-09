<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Json;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $name_email = '%' . $request->input('nameSearch') . '%'; //OR $name_email = '%' . $request->nameSearch . '%';
        $sort = $request->input('sort');

        switch ($sort) {
            case "nameZA":
                $users = User::orderBy('name', 'desc')
                ->where(function ($query) use ($name_email) {
                    $query->where('name', 'like', $name_email);
                })
                ->orWhere(function ($query) use ($name_email) {
                    $query->where('email', 'like', $name_email);
                })
                ->paginate(12);
                break;
            case "emailAZ":
                $users = User::orderBy('email')
                    ->where(function ($query) use ($name_email) {
                        $query->where('name', 'like', $name_email);
                    })
                    ->orWhere(function ($query) use ($name_email) {
                        $query->where('email', 'like', $name_email);
                    })
                    ->paginate(12);
                break;
            case "emailZA":
                $users = User::orderBy('email', 'desc')
                    ->where(function ($query) use ($name_email) {
                        $query->where('name', 'like', $name_email);
                    })
                    ->orWhere(function ($query) use ($name_email) {
                        $query->where('email', 'like', $name_email);
                    })
                    ->paginate(12);
                break;
            case "active":
                $users = User::orderBy('active')
                    ->where(function ($query) use ($name_email) {
                        $query->where('name', 'like', $name_email);
                    })
                    ->orWhere(function ($query) use ($name_email) {
                        $query->where('email', 'like', $name_email);
                    })
                    ->paginate(12);
                break;
            case "admin":
                $users = User::orderBy('admin', 'desc')
                    ->where(function ($query) use ($name_email) {
                        $query->where('name', 'like', $name_email);
                    })
                    ->orWhere(function ($query) use ($name_email) {
                        $query->where('email', 'like', $name_email);
                    })
                    ->paginate(12);
                break;
            default:
                $users = User::orderBy('name')
                ->where(function ($query) use ($name_email) {
                    $query->where('name', 'like', $name_email);
                })
                ->orWhere(function ($query) use ($name_email) {
                    $query->where('email', 'like', $name_email);
                })
                ->paginate(12);
        }

//        if ($request->input('sort') == "nameZA") {
//            $users = User::orderBy('name', 'desc')
//                ->where(function ($query) use ($name_email) {
//                    $query->where('name', 'like', $name_email);
//                })
//                ->orWhere(function ($query) use ($name_email) {
//                    $query->where('email', 'like', $name_email);
//                })
//                ->paginate(12);
//        } else {
//            $users = User::orderBy('name')
//                ->where(function ($query) use ($name_email) {
//                    $query->where('name', 'like', $name_email);
//                })
//                ->orWhere(function ($query) use ($name_email) {
//                    $query->where('email', 'like', $name_email);
//                })
//                ->paginate(12);
//        }

//        $users = User::orderBy('name')
//            ->where(function ($query) use ($name_email) {
//                $query->where('name', 'like', $name_email);
//            })
//            ->orWhere(function ($query) use ($name_email) {
//                $query->where('email', 'like', $name_email);
//            })
//            ->paginate(12);
        $result = compact('users');
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
        $user->delete();
        session()->flash('success', "The user <b>$user->name</b> has been deleted");
        return redirect('admin/users');
    }
}
