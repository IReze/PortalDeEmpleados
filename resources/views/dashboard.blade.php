@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary border-primary-subtle border-info-subtle fs-3 text-white">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status') === 'two-factor-authentication-enabled')
                        <div class="alert alert-success" role="alert">
                            {{ __('Two-factor authentication has been enabled.') }}
                        </div>
                    @endif
                     @if (session('status') === 'two-factor-authentication-disabled')
                        <div class="alert alert-danger" role="alert">
                            {{ __('Two-factor authentication has been disabled.') }}
                        </div>
                    @endif

                    <form action="user/two-factor-authentication" method="POST">
                        @csrf
                        @if (auth()->user()->two_factor_secret)
                        @method('DELETE')
                        <div class="mb-3">
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>

                        <div>
                            <h4>Recovery Codes</h4> <ul>
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $recovery_code)
                                    <li>{{ $recovery_code }}</li>
                                 @endforeach
                            </ul>
                        </div>
                            <button class="btn btn-danger">Disable Two-Factor Authentication</button>
                           
                        @else
                            <button class="btn btn-success">Enable Two-Factor Authentication</button>
                     
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection