<div class="w-100">
    <form action="<?php echo URLROOT; ?>/tweets/hashtagsearch" method="post" class="p-1">

        <div class="form-control rounded-pill background--super-light-gray border--super-light-gray border--focus-blue">
            <i class="bi bi-search"></i>
            <!-- <input class="input-field" type="text" placeholder="Username" name="usrnm"> -->
            <input type="text" name="hashtag" id="" placeholder="Search Twitter"
                class="border-0 background--super-light-gray ">

        </div>
        <!-- <button type="submit">Search</button> -->
        <input type="submit" hidden />
    </form>
</div>