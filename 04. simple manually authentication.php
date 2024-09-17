# web.php
Route::middleware('guest')->group(function(){
    Route::get('register', [AuthController::class, 'registerForm'])->name('register.form');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login');
});
// logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

# AuthController
class AuthController extends Controller
{
    /**
     * Register form
    */
    public function registerForm()
    {
        return view('auth.register');
    }

    /**
     * Register
    */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);
        User::create($data);
        return redirect()->route('login');
    }

    /**'
     * Login page
    */
    public function loginForm()
    {
         return view('auth.login');
    }

    /**'
     * Login
    */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('home');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Logout
    */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
