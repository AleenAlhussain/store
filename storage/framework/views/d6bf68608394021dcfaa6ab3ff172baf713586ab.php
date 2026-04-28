<?php $__env->startSection('title', $page->title); ?>
<?php $__env->startSection('description', strip_tags(Illuminate\Support\Str::words($page->details,30)) ?? ''); ?>
<?php $__env->startSection('content'); ?>
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block block_search_results">
            <div class="block block-content product_box" style="padding: 20px;line-height:24px;font-size: 16px">
                <div class="pure-ui">
                    <h1><?php echo e($page->title); ?></h1>
                    <div><?php echo $page->details; ?></div>
                </div>
            </div>
        </div>
    </div><!-- /block_left -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/hadiabouammar/Documents/GitHub/store/resources/views/site/page.blade.php ENDPATH**/ ?>