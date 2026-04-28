<?php $__env->startSection('title', 'Toppics '); ?>
<?php $__env->startSection('content'); ?>
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block"><?php echo $ad['below_header']; ?></div>
        <div class="block block_products block_commom">
            <div class="block_title">
                <div class="block_breadcrumb">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo e(route('home.index',app()->getLocale())); ?>"><?php echo e(__('web.home')); ?></a></li>
                        <li class="active"><?php echo e(__('web.Toppic')); ?></li>
                    </ul>
                </div>
            </div>
            <div class="block-topics block block-content">
                <?php if(count($toppic)>0): ?>
                    <ul class="topics_list clearfix pt-lg-2">
                        <?php $__currentLoopData = $toppic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="col-sm-4 col-xs-12">
                                <div class="topics_item">
                                    <a href="<?php echo e(route('home.toppicDetail',[app()->getLocale(),$top['slug']])); ?>" title="">
                                        <div class="topics_img">
                                            <img src="<?php echo e(asset('public/images/toppics/')); ?>/<?php echo e($top['images']); ?>" alt="">
                                        </div>
                                        <div class="description">
                                            <div class="topics_name"><?php echo e($top['title']); ?></div>
                                            <div class="topics_description"><?php echo e(Str::limit($top['details'], 100)); ?></div>
                                        </div>
                                    </a>
                                </div>
                            </li><!-- /li -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="pagination-inbox text-center">
                        <?php echo $toppic->links(); ?>

                    </div>
                <?php else: ?>
                    <div class="product_items clearfix"><h6 class="alert alert-danger">No App Display.</h6>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="block"><?php echo $ad['above_footer']; ?></div>
    </div><!-- /block_left -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/hadiabouammar/Documents/GitHub/store/resources/views/home/toppic.blade.php ENDPATH**/ ?>