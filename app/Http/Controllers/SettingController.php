<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public $authUser;

    public function __construct(protected UserService $userService)
    {
        $this->authUser = $this->userService->find(Auth::id());
    }

    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^(\+?[0-9]{1,3})?[0-9]{10}$/|max:25|unique:users,phone,' . $this->authUser->id,
            'email' => 'required|string|lowercase|max:255|email|unique:users,phone,' . $this->authUser->id,
        ]);

        $this->authUser->update($data);

        return redirect()->route('settings.index')->with('success', 'Your Info Updated Successfully.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                Password::defaults(),
                function ($attribute, $value, $fail) use ($request) {
                    if ($value === $request->old_password) {
                        $fail('The new password must be different from the old password.');
                    }
                },
            ],
        ]);

        if (!$this->checkPasswordCorrect($request->old_password, $this->authUser->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.'])->withInput();
        }

        $this->changePassword($request->new_password);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please log in again.');
    }


    public function deleteAcount(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        if (!$this->checkPasswordCorrect($request->password, $this->authUser->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.'])->withInput();
        }

        $this->deleteUser();

        return redirect()->route('login')->with('success', 'Account Deleted Successfully');
    }

    private function checkPasswordCorrect(string $password, string $userPassword): bool
    {
        return Hash::check($password, $userPassword);
    }

    private function changePassword($password): void
    {
        $this->authUser->password = $password;
        $this->authUser->save();
        $this->logoutUser();
    }

    private function logoutUser()
    {
        app()->handle(Request::create(route('logout'), 'POST', [
            '_token' => csrf_token(),
        ]));
    }

    private function deleteUser()
    {
        $this->logoutUser();
        return $this->userService->destroy($this->authUser);
    }
}