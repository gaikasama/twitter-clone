<div class="modal fade" id="loginPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3">
            <div class="modal-header">
                <button type="button" class=" btn-close" data-bs-dismiss="modal " aria-label="Close"></button>
                <h2 class="text-primary w-50 mb-0">
                    <i class="bi bi-twitter color--blue"></i>
                </h2>

            </div>

            <div class="modal-body p-5 d-flex justify-content-center">

                <div class="w-75">
                    <h1 class="mb-4 fw-bold">Sign in to Twitter</h1>
                    <form action="<?php echo URLROOT; ?>/users/login" method="POST" class="form">
                        <div class="form-floating mb-4">
                            <input name="email" type="email" class="form-control"
                                placeholder="email">
                            <label for="email">Email</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input name="password" type="password" class="form-control"
                                placeholder="password">
                            <label for="password">Password</label>
                        </div>

                        <div class="mb-4">
                            <button type="submit" name='submit' value="submit"
                                class="btn btn-secondary rounded-pill btn-sm px-5 w-100 background--black fw-bolder">Login</button>
                        </div>
                        <div class="mb-4">
                            <button type="submit" name='passwordReset'
                                class="btn btn-outline-secondary rounded-pill btn-sm px-5 w-100 color--black fw-bolder">Forgot
                                password?</button>
                        </div>

                    </form>
                    <div class="pt-5">
                        <span class="text-secondary">Don't have an account? <a href="" class="color--blue">Sign
                                up</a></span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>