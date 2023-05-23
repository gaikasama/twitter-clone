<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  border--none">
                <div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <span class="fw-bold">Edit profile</span>

                </div>
                <button type="button" class="background--black color--white border--none px-3 py-1 rounded-pill"
                    onclick="saveProfileEdit(event, 'editProfileForm')">Save</button>
            </div>


            <div class="modal-body">
                <form action="" method="POST" id="editProfileForm">
                    <div class="w-100">
                        <!-- top section with pictures -->
                        <div class="position-relative">
                            <div class="display-flex w-100 position-relative">

                                <!-- background picture -->
                                <div class="">
                                    <input type="hidden" name="image" id='profileBackgroundEdit'
                                        value="<?php if(count($data['background']) > 0) echo $data['background']['id']?>">
                                    <label for="profileBackgroundUploadImage"
                                        class="position-relative w-100 pointer--cursor">
                                        <input type="file" id="profileBackgroundUploadImage" class="w-25" name="file"
                                            style="opacity: 0; z-index:-1; position:absolute"
                                            onchange="profileImageUpload('profileBackground','background')">
                                        <div class="<?php echo count($data['background']) > 0 ? 'background--white' : 'background--super-light-gray'?>" style="height: 200px;"
                                            id="profileBackgroundEmpty">
                                            <?php if(count($data['avatar']) > 0):?>
                                            <img src="<?php echo URLROOT; ?>/public/assets/profile/background/<?php echo $data['background']["picture_name"]?>"
                                                alt="" class="img">
                                            <?php endif;?>
                                        </div>
                                        <div id="profileBackgroundUploadedImagesBox">

                                        </div>
                                    </label>
                                </div>

                                <!-- Profile avatar -->
                                <div class="position-absolute z--index" style="left: 10px; bottom: -40px; ">

                                    <input type="hidden" name="image" id='profileAvatarEdit'
                                        value='<?php if(count($data['avatar']) > 0) echo $data['avatar']['id']?>'>
                                    <label for="profileAvatarUploadImage"
                                        class="position-relative w-100 pointer--cursor">
                                        <input type="file" id="profileAvatarUploadImage" class="w-25" name="file"
                                            style="opacity: 0; z-index:-1; position:absolute"
                                            onchange="profileImageUpload('profileAvatar', 'avatar')">
                                        <div class="width--tweet-img ">
                                            <?php if(count($data['avatar']) > 0):?>
                                                <div class="new--dot img--wrap" id="profileAvatarEmpty">
                                                    <img src="<?php echo URLROOT; ?>/public/assets/profile/avatar/<?php echo $data['avatar']["picture_name"]?>"
                                                        alt="" class="img">
                                                </div>
                                            <?php else:?>
                                                <div class="new--dot" style="display:block" id="profileAvatarEmpty">
                                                </div>
                                            <?php endif;?>
                                            <div id="profileAvatarUploadedImagesBox">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="editProfileName" placeholder="Name"
                                        value="<?php echo $data['user_info']['nickname']?>">
                                    <label for="editProfileName">Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="editProfileDescription"
                                        placeholder="Bio" value="<?php echo $data['user_info']['description']?>">
                                    <label for="editProfileDescription">Bio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>