<!DOCTYPE html>
<html lang="<?php echo e($lang); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('public/theme/images/favicon.png')); ?>">
    <meta name="keywords" content="">
    <meta name="robots" content="index,follow"/>
    <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
    <!-- ===== Style CSS ===== -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/theme/css/style.css')); ?>">
    <!-- ===== Responsive CSS ===== -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/theme/css/responsive.css')); ?>">
    <?php echo $site['before_head_tag']; ?>

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "APKStore",
            "url": "<?php echo e(url('/')); ?>",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "<?php echo e(url('/')); ?>/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Corporation",
            "name": "APKStore",
            "url": "<?php echo e(url('/')); ?>",
            "logo": "<?php echo e(url('/')); ?>/public/theme/images/logo.png"
        }
    </script>
</head>
<body>
<?php echo $site['after_head_tag']; ?>

<div class="wrapper">

    <header class="block header fixed">
        <div class="container">
            <div class="block_logo">
                <a href="<?php echo e(route('site.index')); ?>" title="<?php echo e($site['site_title']); ?>">
                    <img alt="<?php echo e(config('app.name', 'Laravel')); ?>" src="<?php echo e(asset('public/theme/images/logo.png')); ?>">
                </a>
            </div><!-- /block-logo -->
            <div class="block_search_top">
                <div class="block_search">
                    <form action="<?php echo e(route('site.search')); ?>" method="GET" class="form_search">
                        <input type="text" name="q" class="search_input"
                               placeholder="Enter App Name, Package Name, Package ID" required="">
                        <button type="submit" class="btn_search"><i class="fa fa-search"></i></button>
                    </form>
                </div><!-- /block_search -->
            </div><!-- /block_search_top-logo -->
            <div class="block_menu_top">
                <div class="nav-toogle">
                    <i class="fa"></i>
                </div>
                <ul class="nav_menu">
                    <li class="nav_menu_item">
                        <a title="hot game" href="<?php echo e(route('site.index')); ?>"><i class="fa fa-site.
                                                                                style="font-size:20px;color:#ec2c3e"></i> <?php echo e(__('web.home')); ?>

                        </a>
                    </li>
                    <li class="nav_menu_item">
                        <a title="hot game" href="<?php echo e(route('site.toppic')); ?>"><i class="fa fa-archive"
                                                                                 style="font-size:20px;color:#ec2c3e"></i> <?php echo e(__('web.Toppic')); ?>

                        </a>
                    </li>
                    <li class="nav_menu_item parent">
                        <a title="select country" href="javascript:void(0);"><i class="fa fa-globe"
                                                                                style="font-size:20px;color:#ec2c3e"></i> <?php echo e($dlang[$site['default_country']]); ?>

                        </a>
                        <ul class="nav_submenu">
                            <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($row->locale_code !=$site['default_country']): ?>
                                    <li>
                                        <a <?php if($country==$row->locale_code) echo 'class="active"'; ?> href="<?php echo e(route('home.lang', [$row->code,$row->locale_code])); ?>"><?php echo e($row->language); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                </ul>

            </div><!-- /block_menu_top-logo -->
        </div>
    </header><!-- /header -->

    <main id="main" class="container">
        <div class="row">
            <?php echo $__env->yieldContent('content'); ?>
            <div class="block_right col-sm-3 col-xs-12">
                <div class="block block_sidebar block_search-tags">
                    <div class="block_pad">
                        <div class="block_content">
                            <div class="block_search">
                                <form action="<?php echo e(route('site.search')); ?>" method="GET" class="form_search">
                                    <input type="text" name="q" class="search_input"
                                           placeholder="Enter App Name, Package Name, Package ID" required="">
                                    <button type="submit" class="btn_search"><i class="fa fa-search"></i></button>
                                </form>

                            </div><!-- /block_search -->
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                        </div>
                    </div><!-- block_search-tags -->
                </div><!-- block_sidebar -->
                <div class="block"><?php echo $ad['above_right_column']; ?></div>
                <div class="block block_sidebar block_hot_day">
                    <div class="blokck_pad_content">
                        <div class="block_title block_tab">
                            TOP »
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#Game" aria-controls="Game" role="tab"
                                                                          data-toggle="tab"><?php echo e(__('web.games')); ?></a>
                                </li>
                                <li role="presentation"><a href="#Apps" aria-controls="Apps" role="tab"
                                                           data-toggle="tab"><?php echo e(__('web.apps')); ?></a></li>
                            </ul>
                        </div>
                        <div class="block_content clearfix">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Game">
                                    <ul class="hot_day_list" id="topgame">
                                    </ul>
                                    <div class="block_more"><a
                                                href="<?php echo e(route('site.top', ['games'])); ?>"><?php echo e(__('web.more')); ?> »</a>
                                    </div>
                                </div><!-- Game -->
                                <div role="tabpanel" class="tab-pane" id="Apps">
                                    <ul class="hot_day_list" id="topapp">
                                    </ul>
                                    <div class="block_more"><a
                                                href="<?php echo e(route('site.top', ['apps'])); ?>"><?php echo e(__('web.more')); ?> »</a>
                                    </div>
                                </div><!-- Apps -->

                            </div>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block block_sidebar block_popular_categories">
                    <div class="blokck_pad_content">
                        <div class="block_title">
                            <div class="title"><?php echo e(__('web.gamescate')); ?></div>
                            <?php echo e(csrf_field()); ?>

                        </div>
                        <div class="block_content clearfix">
                            <ul class="popular_categories_list location" id="categoriesgame">

                            </ul>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block block_sidebar block_popular_categories">
                    <div class="blokck_pad_content">
                        <div class="block_title">
                            <div class="title"><?php echo e(__('web.appscate')); ?></div>
                        </div>
                        <div class="block_content clearfix">
                            <ul class="popular_categories_list location" id="categoriesapp">
                            </ul>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block"><?php echo $ad['below_right_column']; ?></div>
            </div><!-- /block_right -->
        </div>
    </main><!-- /#main -->

    <footer class="footer">
        <div class="footer_main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title"><?php echo e(__('web.solutions')); ?></p>
                            <?php if(count($pages)>0): ?>
                                <ul>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(route('site.page', [$r->slug])); ?>"
                                               title="<?php echo e($r->title); ?>"><?php echo e($r->title); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div><!-- /list_menu_footer -->

                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title"><?php echo e(__('web.follow')); ?></p>
                            <ul class="follow">
                                <li>
                                    <a href="<?php echo e($site['facebook']); ?>" title="Facebook">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($site['twitter']); ?>" title="Twitter">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($site['google']); ?>" title="Google">
                                        <i class="fa fa-google-plus"></i> Google+
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($site['instagram']); ?>" title="Instagram">
                                        <i class="fa fa-instagram"></i> Instagram
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">TOP <?php echo e(__('web.apps')); ?></p>
                            <ul id="footerapp">
                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">TOP <?php echo e(__('web.games')); ?></p>
                            <ul id="footergame">

                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                </div>
            </div>
        </div><!-- /footer_main -->
        <div class="footer_bot">
            <div class="container">
                <div class="row">
                    <div class="copyright">
                        Copyright © 2021-2025. All rights reserved.
                        
                        
                        
                    </div>
                </div>
            </div>
        </div><!-- /footer_main -->
    </footer><!-- /footer -->

    <a id="return-to-top" class="td-scroll-up" href="javascript:void(0)">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>
    <!-- Return To Top -->

</div><!-- /wrapper -->

<!-- ===== JS ===== -->
<script src="<?php echo e(asset('public/theme/js/jquery.min.js')); ?>"></script>
<!-- ===== JS Bootstrap ===== -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- ===== JS Owl ===== -->
<script src="<?php echo e(asset('public/theme/lib/owl/owl.carousel.min.js')); ?>"></script>
<!-- ===== JS Sticky ===== -->
<script src="<?php echo e(asset('public/theme/lib/sticky/jquery.sticky.js')); ?>"></script>
<!-- Js Common -->
<script src="<?php echo e(asset('public/theme/js/common.js')); ?>"></script>
<script type='text/javascript'>
    $(document).ready(function () {
        var _token = $('input[name="_token"]').val();
        load_data('footer', 'game', _token);
        load_data('footer', 'app', _token);
        load_data('top', 'game', _token);
        load_data('top', 'app', _token);
        load_data('categories', 'game', _token);
        load_data('categories', 'app', _token);

        function load_data(key = "", val = '', _token) {
            $('#' + key + val).html('loading...');
            $.ajax({
                url: "<?php echo e(route('data.getData')); ?>",
                method: "POST",
                data: {key: key, val: val, _token: _token},
                success: function (data) {
                    $('#' + key + val).html(data);
                }
            })
        }
    });
</script>
<?php echo $__env->yieldContent('scripts'); ?>
<?php echo $site['before_body_end_tag']; ?>

</body>
</html>
<?php /**PATH /Users/hadiabouammar/Documents/GitHub/store/resources/views/layouts/site.blade.php ENDPATH**/ ?>