<!-- sigh up popup -->
<div class="modal fade" id="signupPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-3">
            <div id="step1">
                <div class="modal-header">
                    <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="text-primary w-50 mb-0">
                        <i class="bi bi-twitter color--blue"></i>
                    </h2>

                </div>
                <div class="modal-body">

                    <div class="px-5">
                        <h1 class="mb-4 fw-bold">Create your account</h1>
                        <form action="" method="POST" class="form">
                            <div class="form-floating mb-4">
                                <input name="username" id="usernameRegister" type="text" class="form-control required"
                                    placeholder="username" onkeyup="enableSubmit(event)" >
                                <label for="username">Username</label>
                                <div class="form--error" id='usernameError'>
                                </div>
                            </div>

                            <div class="form-floating mb-4" id="emailRegister" style="display: block;">
                                <input name="email" type="email" class="form-control" id="requiredEmail"
                                    placeholder="email" onkeyup="enableSubmit(event)">
                                <label for="email">Email</label>
                                <div class="form--error" id='emailError'>
                                </div>
                                <div class="mt-1 text-end">
                                    <p class="text--blue fs-6 pointer--cursor" onclick="changeRegInput('phone')">Use phone instead</p>
                                </div>
                            </div>

                            <div class="form-floating mb-4" id="phoneRegister" style="display: none;">
                                <input name="phone" type="text" class="form-control" id="requiredPhone"
                                    placeholder="phone number" onkeyup="enableSubmit(event)">
                                <label for="phone">Phone number</label>
                                <div class="mt-1 text-end" >
                                    <p class="text--blue fs-6 pointer--cursor" onclick="changeRegInput('email')">Use email instead</p>
                                </div>
                            </div>

                            

                            <!-- <div class="row g-3">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <span class="fs-6 fw-bold">
                                        Date of birth
                                        </span>
                                    </div>
                                    <div class=" text--s">
                                        <span class="text--gray">
                                        This will not be shown publicly. Confirm your own age, even if this account is for a business, a pet, or something else.
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 form-floating">
                                    <select class="form-select required " id="monthSelect" aria-label="Month" name="month" onchange="enableSubmit()">
                                        <option selected></option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <label for="monthSelect">Month</label>
                                </div>
                                <div class="col-4 form-floating">
                                    <select class="form-select required" aria-label="Default select example" name="day" onchange="enableSubmit()">
                                        <option selected></option>
                                        <?php for($i = 1; $i < 32; $i++): ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="monthSelect">Day</label>
                                </div>
                                <div class="col-4 form-floating">
                                    <select class="form-select required" aria-label="Default select example" name="year" onchange="enableSubmit()">
                                        <option selected></option>
                                        <?php for($i = 1980; $i < 2022; $i++): ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="monthSelect">Year</label>
                                </div>
                            </div> -->
                            <button name="step1" class="btn btn-secondary btn-lg rounded-pill px-5 w-100 background--black border-black fw-bolder"
                                type="button" onclick="register(event, 1)" disabled>Next</button>
                        </form>
                        <div class="p-5">
                            
                        </div>
                    </div>

                </div>
            </div>

            <div id="step2" style="display: none;">
                <div class="modal-header justify-content-start ">
                    <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="mb-0 fs-6 fw-bold">
                        Step 2 
                    </h2>

                </div>
                <div class="modal-body">

                    <div class="px-5">
                        <h1 class="mb-4 fw-bold">Create your account</h1>
                        <form action="" method="POST" class="form">
                            <div class="form-floating mb-4">
                                <input name="username" type="text" class="form-control"
                                    placeholder="username" value="" disabled>
                                <label for="username">Username</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input name="email" type="email" class="form-control"
                                    placeholder="email" value="" disabled>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="nickname" type="text" class="form-control"
                                    placeholder="nickname">
                                <label for="nickname">Nickname</label>
                                <div class="form--error" id='nicknameError'>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <input name="password" type="password" class="form-control"
                                    placeholder="password">
                                <label for="password">Password</label>
                                <div class="form--error" id='passwordError'>
                                </div>
                            </div>
                            <div class="form-floating mb-4">
                                <input name="confirmPassword" type="password" class="form-control"
                                    placeholder="Confirm password">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="form--error" id='confirmPasswordError'>
                                </div>
                            </div>

                            <div class="p-5">
                                <button class="btn btn-secondary btn-lg rounded-pill px-5 w-100 background--black border-black fw-bolder"
                                    type="submit" onclick="register(event, 2)">Next</button>
                            </div>

                        </form>
                        <!-- <div class="p-5">
                            <button class="btn btn-secondary btn-lg rounded-pill px-5 w-100 background--black border-black fw-bolder"
                                type="button" onclick="toggleVisibility(3)">Next</button>
                        </div> -->
                    </div>





                </div>
            </div>
            <!-- <div id="step3" style="display: none;">
                <div class="modal-header justify-content-start">
                    <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="mb-0 fs-6 fw-bold">
                        Step 3 of 3
                    </h2>

                </div>
                <div class="modal-body">

                    <div class="px-5">
                        <h1 class="mb-4 fw-bold">Success!</h1>
                        <p>
                            Start Tweeting!
                        </p>
                        <div class="p-5">
                            <button class="btn btn-secondary btn-lg rounded-pill px-5 w-100 background--blue border--blue fw-bolder"
                                type="button">Login</button>
                        </div>
                    </div>





                </div>
            </div> -->

        </div>
    </div>
</div>