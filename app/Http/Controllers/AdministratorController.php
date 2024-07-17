<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdministratorRequest;
use App\Http\Requests\UpdateAdministratorRequest;
use App\Models\Administrator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministratorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrator $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrator $administrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdministratorRequest $request, Administrator $administrator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
        //
    }

    public function users(): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {
        if (auth()->user()->administrator()) {
            $users = User::with('latestActivity.activity_type')->get();
            return Inertia::render('Users/Index',[
                'users' => $users,
                'user_count' => $users->count(),
                'months' => array_keys($this->getMonthlyLogins()),
                'month_data' => array_values($this->getMonthlyLogins())
            ]);
        }
        return redirect('/dashboard');
    }

    public function getMonthlyLogins(): array
    {
        $logins = DB::table('user_activities')
            ->select('created_at')
            ->where('user_activity_type_id', 1)
            ->get()
            ->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('F'); // grouping by full month name
            })
            ->map(function($row) {
                return count($row); // counting the number of activities in each month
            });

        $months = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        foreach ($logins as $month => $count) {
            $months[$month] = $count;
        }

        return $months;
    }

    public function isAdmin(): bool
    {
        return auth()->user()->administrator();
    }

    public function user_admin_page($user_id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Inertia\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->user()->administrator()) {
            $user = User::with('user_activity.activity_type')->find($user_id);
            return Inertia::render('Users/Show',[
                'user' => $user,
                'admin' => $user->administrator(),
                'months' => array_keys($user->getActivityCountByMonth()),
                'month_data' => array_values($user->getActivityCountByMonth())
            ]);
        }
        return redirect('/dashboard');
    }

    public function admin_user(\Illuminate\Http\Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if ($user) {
            $user->name = $request->name;
            $user->save();
            return Redirect::back()->withErrors(['email' => 'This email address is already taken'])->withInput();
        }
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return Redirect::back()->with(['status' => 'Profile successfully updated.'])->withInput();
    }

    public function admin_user_password(\Illuminate\Http\Request $request)
    {

        if ($request->password != $request->password_confirmation) {
            return Redirect::back()->withErrors(['password' => 'These passwords do not match'])->withInput();
        }

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::back()->with(['message'=>'Password updated successfully!'])->withInput();

    }

    public function admin_user_delete(\Illuminate\Http\Request $request)
    {
        if ($request->id == auth()->user()->id) {
            return Redirect::back()->withErrors(['password' => 'You cannot deactivate your own account.'])->withInput();
        }

        if ($request->id == auth()->user()->id && Hash::make($request->password) != auth()->user()->password) {
            return Redirect::back()->withErrors(['password' => 'You have entered the wrong password.'])->withInput();
        }

        if (auth()->user()->administrator() == false) {
            return Redirect::back()->withErrors(['error' => 'You are not authorised to complete this action.'])->withInput();
        }

        $user = User::find($request->id);
        $user->is_active = false;
        $user->save();

        return Redirect::back()->with(['message'=>'User account has been deactivated.'])->withInput();

    }

    public function admin_user_reactive(\Illuminate\Http\Request $request)
    {
        if ($request->id == auth()->user()->id && Hash::make($request->password) != auth()->user()->password) {
            return Redirect::back()->withErrors(['password' => 'You have entered the wrong password.'])->withInput();
        }

        if (auth()->user()->administrator() == false) {
            return Redirect::back()->withErrors(['error' => 'You are not authorised to complete this action.'])->withInput();
        }

        $user = User::find($request->id);
        $user->is_active = true;
        $user->save();

        return Redirect::back()->with(['message'=>'User account has been Reactivated.'])->withInput();

    }

}
