@extends('layouts.base_website')

@section('title', 'Tambah Akun User')
@section('user', true)

@section('content')
<!-- Input Validation start -->
<section class="input-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Akun User</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.user.register') }}">
                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <div class="controls">
                                <input type="text" name="name" class="form-control" data-validation-required-message="This field is required" placeholder="Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="controls">
                                <input type="email" name="email" class="form-control" data-validation-required-message="Must be a valid email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <div class="controls">
                                <input type="password" name="password" class="form-control" minlength="8" data-validation-required-message="This field is required" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <div class="controls">
                                <input type="password" name="password_confirmation" data-validation-match-match="password" class="form-control" data-validation-required-message="Repeat password must match" placeholder="Repeat Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <div class="controls">
                                <select name="role" id="" class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">Marketing</option>
                                    <option value="3">Staf Gudang</option>
                                    <option value="4">Royalti</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Input Validation end -->
@endsection