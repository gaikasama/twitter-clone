<?php require APPROOT . '/views/inc/head.php'?>

<div class="row g-0 height--xxl">

    <?php require APPROOT . '/views/inc/navigation.php'?>


    <!-- Feed -->
    <div class="col-6 border--left-right" style="position: relative;">
        <div class="d-inline-flex w-100 justify-content-start align-items-center px-2 ">
            <div class="">
                <a href="<?php echo URLROOT; ?>/tweets/home">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="" width="20" height="20">
                    <g>
                        <path
                            d="M20 11H7.414l4.293-4.293c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0l-6 6c-.39.39-.39 1.023 0 1.414l6 6c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L7.414 13H20c.553 0 1-.447 1-1s-.447-1-1-1z">
                        </path>
                    </g>
                </svg>
                </a>
                
            </div>

            <?php require APPROOT . '/views/inc/top.php'?>

        </div>


        <?php require APPROOT . '/views/inc/tweet.php'?>

    </div>

    <?php require APPROOT . '/views/popup/tweet.php'?>


    <!-- Search -->
    <div class="col-3">

    </div>
</div>