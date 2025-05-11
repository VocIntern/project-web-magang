<?php
    // <!-- app\Http\Controllers\Auth\AuthenticatedSessionController.php -->
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Auth\LoginRequest;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\View\View;

    class AuthenticatedSessionController extends Controller
    {
        /**
         * Display the login view.
         */
        public function create(): View
        {
            return view('auth.login');
        }

        /**
         * Handle an incoming authentication request.
         */
        public function store(LoginRequest $request): RedirectResponse
        {
            $request->validate([
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string'],
            ]);

            if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                // regenerate session agar terhindar session fixation
                $request->session()->regenerate();

                // Opsional: hapus intended URL lama
                Auth::user()->refresh();

                $user = Auth::user();

                // Redirect berdasarkan role—gunakan route() untuk memastikan nama route benar
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isMahasiswa()) {
                    return redirect()->intended(route('mahasiswa.magang.search'));
                } elseif ($user->isPerusahaan()) {
                    return redirect()->route('perusahaan.dashboard');
                }

                // Fallback, jika suatu saat ada role lain
                return redirect('/');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        /**
         * Destroy an authenticated session.
         */
        public function destroy(Request $request): RedirectResponse
        {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
