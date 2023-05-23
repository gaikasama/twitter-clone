<?php require APPROOT . '/views/inc/head.php'?>
<section class="">
    <div class="row height--xl">
        <div class="col-sm registration">
            <div class="p-5 d-flex justify-content-center">
                <svg viewBox="0 0 24 24" aria-hidden="true" style="fill:white; max-height: 380px"
                    class="r-k200y r-1cvl2hr r-4qtqp9 r-yyyyoo r-5sfk15 r-dnmrzs r-1t982j2 r-bnwqim r-1plcrui r-lrvibr">
                    <g>
                        <path
                            d="M23.643 4.937c-.835.37-1.732.62-2.675.733.962-.576 1.7-1.49 2.048-2.578-.9.534-1.897.922-2.958 1.13-.85-.904-2.06-1.47-3.4-1.47-2.572 0-4.658 2.086-4.658 4.66 0 .364.042.718.12 1.06-3.873-.195-7.304-2.05-9.602-4.868-.4.69-.63 1.49-.63 2.342 0 1.616.823 3.043 2.072 3.878-.764-.025-1.482-.234-2.11-.583v.06c0 2.257 1.605 4.14 3.737 4.568-.392.106-.803.162-1.227.162-.3 0-.593-.028-.877-.082.593 1.85 2.313 3.198 4.352 3.234-1.595 1.25-3.604 1.995-5.786 1.995-.376 0-.747-.022-1.112-.065 2.062 1.323 4.51 2.093 7.14 2.093 8.57 0 13.255-7.098 13.255-13.254 0-.2-.005-.402-.014-.602.91-.658 1.7-1.477 2.323-2.41z">
                        </path>
                    </g>
                </svg>
            </div>

            
        </div>
        <div class="col-sm p-4">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="42" height="57" fill="currentColor"
                    class="bi bi-twitter fill--blue" viewBox="0 0 16 16">
                    <path
                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                </svg>
                <div class="my-5 text--xxl">
                    <span class="">Happening now</span>
                </div>
                <div class="mb-4 text--xl">
                    <span>
                        Join Twitter today.
                    </span>
                </div>

            </div>

            <!-- Sign up button -->
            <div class="w-50">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary rounded-pill px-3 background--blue border--blue fw-bold mb-2"
                        type="button" data-bs-toggle="modal" data-bs-target="#signupPopup">Sign up with phone or
                        email</button>
                </div>
                <div class="text--xxs">
                    <span class="text--gray">
                        By signing up, you agree to the <a href="" class="text--blue">Terms of Service</a> and <a
                            href="" class="text--blue">Privacy Policy</a>, including <a href=""
                            class="text--blue">Cookie Use</a>.
                    </span>
                </div>
            </div>

            <!-- login button -->
            <div class="w-50">
                <div class="mt-5 mb-3">
                    <span class="fs-6 fw-bold">Already have an account?</span>
                </div>
                <div>
                    <!-- <button>Log in here</button> -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn btn-outline-secondary rounded-pill px-5" data-bs-toggle="modal"
                            data-bs-target="#loginPopup">
                            Sign in
                        </button>
                    </div>
                </div>
            </div>
            

            <?php require APPROOT . '/views/popup/signup.php'?>
            <?php require APPROOT . '/views/popup/login.php'?>

        </div>



    </div>
</section>


<?php require APPROOT . '/views/inc/footer.php'?>