@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border border-primary-subtle">
                <div class="card-header border-primary-subtle border-info-subtle fs-3">{{ __('Two-Factor Secret Code') }}</div>

                <div class="card-body">
                    <p class= "fs-bold text-center">
                    {{ __('Please enter the two-factor authentication code provided by your authenticator application.') }} </p>
                    <form method="POST" action="{{ route('two-factor.login.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('Two-Factor Code') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="one-time-code">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 fs-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-info">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card bg-dark text-white border border-primary-subtle">
                <div class="card-header border-primary-subtle border-info-subtle fs-3">{{ __('Two-Factor Recovery Code') }}</div>

                <div class="card-body">
                    <p class= "fs-bold text-center">
                    {{ __('Please enter your recovery code') }} </p>
                    <form method="POST" action="{{ route('two-factor.login.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="code" class="col-md-4 col-form-label text-md-end">{{ __('Two-Factor Code') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="one-time-code">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 fs-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-info">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                      
    </div>
</div>
@endsection