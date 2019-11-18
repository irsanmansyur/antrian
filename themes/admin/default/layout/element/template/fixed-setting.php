    </div>
    </div>

    <!-- /fixed setting -->
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <span class="mt-5">
                <span class="fa fa-clock fa-2x pb-2"></span><br>
                <div class="time"></div>
            </span>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Filters</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger active-color">
                        <div class="badge-colors ml-auto mr-auto">
                            <span class="badge filter badge-purple <?= ($this->setting->data_color == 'purple') ? 'active' : '' ?>" data-color="purple"></span>
                            <span class="badge filter badge-azure <?= ($this->setting->data_color == 'azure') ? 'active' : '' ?>" data-color="azure"></span>
                            <span class="badge filter badge-green <?= ($this->setting->data_color == 'green') ? 'active' : '' ?>" data-color="green"></span>
                            <span class="badge filter badge-warning <?= ($this->setting->data_color == 'orange') ? 'active' : '' ?>" data-color="orange"></span>
                            <span class="badge filter badge-danger <?= ($this->setting->data_color == 'danger') ? 'active' : '' ?>" data-color="danger"></span>
                            <span class="badge filter badge-rose <?= ($this->setting->data_color == 'rose') ? 'active' : '' ?>" data-color="rose"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="ml-auto mr-auto">
                            <span class="badge filter badge-black <?= ($this->setting->background_color == 'black') ? 'active' : '' ?>" data-background-color="black"></span>
                            <span class="badge filter badge-white <?= ($this->setting->background_color == 'white') ? 'active' : '' ?>" data-background-color="white"></span>
                            <span class="badge filter badge-red <?= ($this->setting->background_color == 'red') ? 'active' : '' ?>" data-background-color="red"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Mini</p>
                        <label class="ml-auto">
                            <div class="togglebutton switch-sidebar-mini">
                                <label>
                                    <input type="checkbox">
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger">
                        <p>Sidebar Images</p>
                        <label class="switch-mini ml-auto">
                            <div class="togglebutton switch-sidebar-image">
                                <label>
                                    <input type="checkbox" checked="">
                                    <span class="toggle"></span>
                                </label>
                            </div>
                        </label>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Images</li>
                <li class="<?= ($this->setting->background_image == $thema_folder . 'assets/img/sidebar-1.jpg') ? 'active' : '' ?>">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?= $thema_folder; ?>assets/img/sidebar-1.jpg" alt="">
                    </a>
                </li>
                <li class="<?= ($this->setting->background_image == $thema_folder . 'assets/img/sidebar-2.jpg') ? 'active' : '' ?>">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?= $thema_folder; ?>assets/img/sidebar-2.jpg" alt="">
                    </a>
                </li>
                <li class="<?= ($this->setting->background_image == $thema_folder . 'assets/img/sidebar-3.jpg') ? 'active' : '' ?>">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?= $thema_folder; ?>assets/img/sidebar-3.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="<?= $thema_folder; ?>assets/img/sidebar-4.jpg" alt="">
                    </a>
                </li>
                <li class="button-container">
                    <a href="<?= base_url('user/dashboard') ?>" target="_blank" class="btn btn-rose btn-block btn-fill">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end fixed -->


    <script src="<?= $thema_folder; ?>assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>

    <script>
        $().ready(function() {
            $sidebar = $('.sidebar');
            $sidebar_img_container = $sidebar.find('.sidebar-background');
            $full_page = $('.full-page');
            $sidebar_responsive = $('body > .navbar-collapse');
            window_width = $(window).width();

            fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

            if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                    $('.fixed-plugin .dropdown').addClass('open');
                }

            }
        });
        $('.fixed-plugin a').click(function(event) {
            // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
            if ($(this).hasClass('switch-trigger')) {
                if (event.stopPropagation) {
                    event.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
            }
        });
        $('.fixed-plugin .active-color span').click(function() {

            $full_page_background = $('.full-page-background');

            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data-color', new_color);
                var data = {
                    data_color: new_color
                };
                setNow(data);

            }

            if ($full_page.length != 0) {
                $full_page.attr('filter-color', new_color);
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.attr('data-color', new_color);
            }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('background-color');

            if ($sidebar.length != 0) {
                $sidebar.attr('data-background-color', new_color);
                var data = {
                    background_color: new_color
                };
                setNow(data);

            }
        });

        $('.fixed-plugin .img-holder').click(function() {
            $full_page_background = $('.full-page-background');

            $(this).parent('li').siblings().removeClass('active');
            $(this).parent('li').addClass('active');


            var new_image = $(this).find("img").attr('src');

            if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                $sidebar_img_container.fadeOut('fast', function() {
                    $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                    $sidebar_img_container.fadeIn('fast');
                    var data = {
                        background_image: new_image
                    };
                    setNow(data);
                });
            }

            if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                $full_page_background.fadeOut('fast', function() {
                    $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    $full_page_background.fadeIn('fast');
                });
            }

            if ($('.switch-sidebar-image input:checked').length == 0) {
                var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
            }

            if ($sidebar_responsive.length != 0) {
                $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
            }
        });

        function setNow(dataku) {
            $.ajax({
                url: "<?= base_url('admin/user/setting'); ?>",
                type: 'post',
                dataType: 'json',
                data: dataku,
                success: function(e) {
                    console.log(e);
                }
            });
        }
        $('.switch-sidebar-image input').change(function() {
            $full_page_background = $('.full-page-background');

            $input = $(this);

            if ($input.is(':checked')) {
                if ($sidebar_img_container.length != 0) {
                    $sidebar_img_container.fadeIn('fast');
                    $sidebar.attr('data-image', '#');
                }

                if ($full_page_background.length != 0) {
                    $full_page_background.fadeIn('fast');
                    $full_page.attr('data-image', '#');
                }

                background_image = true;
            } else {
                if ($sidebar_img_container.length != 0) {
                    $sidebar.removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                }

                if ($full_page_background.length != 0) {
                    $full_page.removeAttr('data-image', '#');
                    $full_page_background.fadeOut('fast');
                }

                background_image = false;
            }
        });

        $('.switch-sidebar-mini input').change(function() {
            $body = $('body');

            $input = $(this);

            if (md.misc.sidebar_mini_active == true) {
                $('body').removeClass('sidebar-mini');
                md.misc.sidebar_mini_active = false;

                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

            } else {

                $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                setTimeout(function() {
                    $('body').addClass('sidebar-mini');

                    md.misc.sidebar_mini_active = true;
                }, 300);
            }

            // we simulate the window Resize so the charts will get updated in realtime.
            var simulateWindowResize = setInterval(function() {
                window.dispatchEvent(new Event('resize'));
            }, 180);

            // we stop the simulation of Window Resize after the animations are completed
            setTimeout(function() {
                clearInterval(simulateWindowResize);
            }, 1000);

        });

        var deadline = parseInt("<?php echo $this->session->userdata('time') ?>");
        var now = parseInt("<?= time() ?>");

        var x = setInterval(function() {
            var t = deadline - now;
            now++;
            var h = Math.floor(t % 3600 / 3600);
            var m = Math.floor(t % 3600 / 60);
            var s = Math.floor(t % 3600 % 60);
            $('div.time').html(h + ":" + m + ":" + s);
            if (t < 1) {
                document.location.href = "<?= $this->session->userdata('url'); ?>"
            }
        }, 1000);

        function ShowInfo(pesan, jenis = "success") {
            $.notify({
                icon: "add_alert",
                message: pesan

            }, {
                type: jenis,
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        }
    </script>