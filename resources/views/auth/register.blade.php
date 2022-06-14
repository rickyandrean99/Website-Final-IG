@extends('layouts.app')

@section('content')
<main>

    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image"
                data-background-lg="{{ asset('') }}assets/img/authentication.svg">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h4 class="mb-0">Create Account</h4>
                        </div>
                        <form method="POST" action="{{ route('register') }}" class="mt-4">
                            @csrf
                            <!-- Username -->
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                            </path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="username" class="form-control" name="username" placeholder="Username" autofocus required>
                                </div>
                            </div>
                            
                            <!-- Password -->
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input type="password" placeholder="Password" name="password" class="form-control" id="password" required>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="form-group mb-4">
                                <label for="role">Role</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="peserta">Peserta</option>
                                        <option value="upgrade">Upgrade</option>
                                        <option value="pasar">Pasar</option>
                                        <option value="acara">Acara</option>
                                        <option value="administrator">Super Admin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Team -->
                            <div class="form-group mb-4">
                                <label for="team">Team</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">
                                        <svg class="icon icon-xs text-gray-600" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <select name="team" id="team" class="form-select">
                                        <option value="0" selected>-</option>
                                        @for($i=1; $i<=10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800 mt-4">Sign up</button>
                            </div>
                        </form>

                        @foreach($errors->all() as $error)
                            <div class="text-danger fw-bold mt-3">{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
