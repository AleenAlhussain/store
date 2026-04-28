<?php $__env->startSection('title', 'Top free '.$title); ?>
<?php $__env->startSection('content'); ?>
<div class="block_left col-sm-9 col-xs-12">
    <div class="block"><?php echo $ad['below_header']; ?></div>
  <div class="block block_search_results">
    <div class="block block-content clearfix">
      <ul class="product_list clearfix">
        <?php $__currentLoopData = $search; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $top = json_decode(json_encode($top), true);?>
          <li class="col-sm-5ths col-xs-6">
            <div class="product_item">
              <div class="product_img">
                <a title="<?php echo e($top['name']); ?>" href="<?php echo e(route('site.detail', [str_slug($top['name'],'-'),$top['id']])); ?>">
                  <img alt="<?php echo e($top['name']); ?>" src="<?php echo e($top['icon']); ?>">
                </a>
              </div>
              <div class="description">
                <h3>
                  <a title="<?php echo e($top['name']); ?>" href="<?php echo e(route('site.detail', [str_slug($top['name'],'-'),$top['id']])); ?>"><?php echo e($top['name']); ?></a>
                </h3>
                <div class="stars">
                  <span title="<?php echo e($top['name']); ?> average rating <?php echo e($top['score']); ?>" style="width:<?php echo ((int)$top['score']/5)*100; ?>%;"></span>
                </div>
                <div class="down_btn">
                  <a href="<?php echo e(route('site.detail', [str_slug($top['name'],'-'),$top['id']])); ?>" class="btn btn_down" title="Download <?php echo e($top['name']); ?>">
                    <?php echo e(__('web.installapk')); ?>

                </a>
                </div>
              </div>
            </div>
          </li><!-- li -->

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  </div>
    <div class="block"><?php echo $ad['above_footer']; ?></div>
</div><!-- /block_left -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/hadiabouammar/Documents/GitHub/store/resources/views/site/top.blade.php ENDPATH**/ ?>