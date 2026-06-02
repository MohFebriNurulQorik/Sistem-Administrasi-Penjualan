<?php

namespace App\Http\Requests\Auth;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'email'     => ['required', 'string', 'email'],
            'password'  => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'tenant_id.exists' => 'Tenant tidak ditemukan.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Superadmin login tanpa tenant
        if (! $this->tenant_id) {
            $user = User::where('email', $this->email)
                        ->where('role', 'superadmin')
                        ->first();

            if (! $user) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => 'Email tidak ditemukan atau pilih perusahaan.',
                ]);
            }

            if (! Auth::attempt(['email' => $this->email, 'password' => $this->password, 'role' => 'superadmin'], $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Login biasa dengan tenant
        $tenant = Tenant::find($this->tenant_id);

        if (! $tenant->isActive()) {
            throw ValidationException::withMessages([
                'tenant_id' => 'Tenant tidak aktif. Hubungi administrator.',
            ]);
        }

        $user = User::where('email', $this->email)
                    ->where('tenant_id', $this->tenant_id)
                    ->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan di perusahaan yang dipilih.',
            ]);
        }

        if (! Auth::attempt([
            'email'     => $this->email,
            'password'  => $this->password,
            'tenant_id' => $this->tenant_id,
        ], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->tenant_id . '|' . $this->ip());
    }
}