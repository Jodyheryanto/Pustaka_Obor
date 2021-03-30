@extends('layouts.base_website')

@section('title', 'Edit Akun User')
@section('user', true)

@section('content')
<!-- Input Validation start -->
<section class="input-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Akun User</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.user.edit') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="form-group">
                            <label>Name</label>
                            <div class="controls">
                                <input type="text" name="name" class="form-control" data-validation-required-message="This field is required" placeholder="Name" value="{{ $user->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="controls">
                                <input type="email" name="email" class="form-control" data-validation-required-message="Must be a valid email" placeholder="Email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <div class="controls">
                                <select name="role" id="" class="form-control">
                                    <option value="1" @if($user->role == 1) echo selected @endif>Admin</option>
                                    <option value="2" @if($user->role == 2) echo selected @endif>Marketing</option>
                                    <option value="3" @if($user->role == 3) echo selected @endif>Staf Gudang</option>
                                    <option value="4" @if($user->role == 4) echo selected @endif>Royalti</option>
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