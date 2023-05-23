<?php require APPROOT . '/views/inc/head.php'?>

<div class="row g-0 height--xxl">

    <?php require APPROOT . '/views/inc/navigation.php'?>
    <div class="col-6 border--left-right" style="position: relative;">
        <div class="d-inline-flex w-100 justify-content-between align-items-center px-2 py-3">
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
            <div class="w-75">
                <?php require APPROOT . '/views/inc/search.php'?>
            </div>
            <div class="">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="" width="20" height="20">
                    <g>
                        <circle cx="5" cy="12" r="2"></circle>
                        <circle cx="12" cy="12" r="2"></circle>
                        <circle cx="19" cy="12" r="2"></circle>
                    </g>
                </svg>
            </div>
        </div>

        <?php if($data['result']):?>
        <?php require APPROOT . '/views/inc/feed.php'?>
        <?php require APPROOT . '/views/popup/tweet.php'?>
        <?php else:?>
        <div class="p-2 m-auto">
            <span>No results found</span>
        </div>
        <?php endif;?>

    </div>
</div>