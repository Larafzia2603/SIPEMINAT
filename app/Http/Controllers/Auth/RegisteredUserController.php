<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', Rule::in(['mahasiswa', 'dosen_pa', 'kaprodi', 'dekan'])],
            'nim' => ['nullable', 'string', 'max:30', 'unique:'.User::class.',nim'],
            'nip' => ['nullable', 'string', 'max:30', 'unique:'.User::class.',nip'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = (string) $request->string('role');
        $nim = Str::of($request->string('nim'))
            ->trim()
            ->replace(' ', '')
            ->toString();
        $nip = Str::of($request->string('nip'))
            ->trim()
            ->replace(' ', '')
            ->toString();

        if ($role === 'mahasiswa' && $nim === '') {
            throw ValidationException::withMessages([
                'nim' => 'NIM/Stambuk wajib diisi untuk mahasiswa.',
            ]);
        }

        if ($role !== 'mahasiswa' && $nip === '') {
            throw ValidationException::withMessages([
                'nip' => 'NIP wajib diisi untuk dosen, kaprodi, atau dekan.',
            ]);
        }

        $email = $role === 'mahasiswa'
            ? strtolower($nim).'@mahasiswa.local'
            : strtolower($nip).'@staff.local';

        $user = User::create([
            'name' => $request->name,
            'nim' => $role === 'mahasiswa' ? $nim : null,
            'nip' => $role === 'mahasiswa' ? null : $nip,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role' => UserRole::from($role),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
