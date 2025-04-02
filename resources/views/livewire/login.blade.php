<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form wire:submit.prevent='login'>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="username" class="form-control form-control-lg"
                            placeholder="Enter Username" wire:model='username' />
                        <label class="form-label" for="username">Username</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-3">
                        <input type="password" id="password" class="form-control form-control-lg"
                            placeholder="Enter password" wire:model='password' />
                        <label class="form-label" for="password">Password</label>
                    </div>


                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>
