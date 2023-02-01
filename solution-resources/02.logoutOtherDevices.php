<?php
class LoginController extends Controller {
  public function login(Request $request)
  {
      $request->validate([
          'email' => 'required',
          'password' => 'required',
      ]);
      $credentials = $request->only('email', 'password');
      if (Auth::attempt(['email' => trim($request->email), 'password' => trim($request->password), 'status' => 'active'])) {
          $user = Auth::getProvider()->retrieveByCredentials($credentials);
          // the main logic goes here ...
          Auth::logoutOtherDevices(trim($request->password));
          Auth::login($user);
      }
      return redirect("admin/login")->with('error', 'Invalid Email or Password');
  }

  public function logout() {
      Auth::logout();
      // this is required when we use logoutOtherDevices feature
      session()->flush();
      return redirect('admin/login');
  }
}
