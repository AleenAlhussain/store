<?php $__env->startSection('title',__('web.sitetitle')); ?>
<?php $__env->startSection('content'); ?>
    <div class="block_left col-sm-9 col-xs-12">
        <?php if(count($sliders)>0): ?>
            <div class="block block_slide">
                <div class="owl-carousel dotsData" data-nav="true" data-margin="0" data-items='1'
                     data-autoplayTimeout="700" data-autoplay="false" data-loop="true" data-dots="true">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item-slide" data-dot="<?php echo e($k+1); ?>">
                            <a href="<?php echo e($slider->link); ?>">
                                <img src="<?php echo e(asset('public/images/sliders')); ?>/<?php echo e($slider->image); ?>" alt="<?php echo e($slider->title); ?>">
                            </a>
                            <div class="figcaption">
                                <a href="<?php echo e($slider->link); ?>" style="color: #FFF;">
                                    <?php echo e($slider->title); ?></a>
                            </div>

                        </div><!-- item-slide -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div><!-- /block_slide -->
        <?php endif; ?>
        <div class="block"><?php echo $ad['below_header']; ?></div>
        <?php if(count($toppic)>0): ?>
            <?php $__currentLoopData = $toppic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="block block_products block_commom">
                    <div class="block_title">
                        <?php echo e($app['title']); ?>

                    </div>
                    <div class="block-content" id="hometopgame">
                        <?php if(isset($app['data']) && count($app['data'])>0): ?>
                            <ul class="product_items clearfix">
                                <?php $__currentLoopData = $app['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="col-sm-4 col-xs-6 product_item">
                                        <div class="product_img">
                                            <a title="<?php echo e($top['title']); ?>"
                                               href="<?php echo e(route('home.detail', [app()->getLocale(),$top['slug'], $top['id']])); ?>">
                                                <img alt="<?php echo e($top['title']); ?>" width="75px" height="75px"
                                                     src="<?php echo e(asset('public/images/')); ?>/<?php echo e($top['cover']); ?>">
                                            </a>
                                        </div>
                                        <div class="description">
                                            <h3>
                                                <a title="<?php echo e($top['title']); ?>"
                                                   href="<?php echo e(route('home.detail', [app()->getLocale(),$top['slug'], $top['id']])); ?>"><?php echo e($top['title']); ?></a>
                                            </h3>
                                            <div class="stars">
                                    <span title="<?php echo e($top['title']); ?> average rating <?php echo e($top['score']); ?>"
                                          style="width:<?php echo e((((int)$top['score'] / 5) * 100)); ?>%;"></span>
                                            </div>
                                            <div class="rating_info"> votes <span class="rating"><span
                                                        class="average"><?php echo e(round($top['score'], 1)); ?></span>/<span
                                                        class="best"> 5</span></span></div>
                                            <div class="down_btn">
                                                <p> Download <?php echo e($top['title']); ?></p>
                                                <a href="<?php echo e(route('home.detail', [app()->getLocale(),$top['slug'], $top['id']])); ?>"
                                                   class="btn btn_down" title="Download <?php echo e($top['title']); ?>"> <?php echo e(__('web.installapk')); ?> </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <div class="product_items clearfix"><h6 class="alert alert-danger">No App Selected.</h6>
                            </div>
                        <?php endif; ?>
                    </div>
                </div><!-- /block_products -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
            <div class="block"><?php echo $ad['above_footer']; ?></div>
    </div><!-- /block_left -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/hadiabouammar/Documents/GitHub/store/resources/views/home/index.blade.php ENDPATH**/ ?>