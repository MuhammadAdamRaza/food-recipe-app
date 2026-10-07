public function logout(): RedirectResponse
    {
        auth()->logout();

        return redirect()->route('login');
    }

    