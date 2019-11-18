            <!-- end content -->
            </div>

            <!-- /footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="float-left">
                        <ul>
                            <li>
                                <a href="<?= @$user['site_url'] ?>">
                                    <?= @$user['site_name'] ?>
                                </a>
                            </li>
                            <?php
                            if ("a" == "ddd") : ?>

                            <?php endif; ?>
                        </ul>
                    </nav>
                    <div class="copyright float-right">
                        <p class="footer">Page rendered in <strong>{elapsed_time} </strong>&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with
                            <!-- <i class="material-icons">favorite</i> -->
                            by
                            <a href="<?= @$user['site_url'] ?>" target="_blank"><?= @$user['site_name'] ?></a> for YOU
                    </div>
                </div>
            </footer>
            <script>
                $(document).ready(function() {
                    $(".preloader").fadeOut();
                })
            </script>

            <!-- end main-panel -->
            </div>
            <!-- end wrapper -->
            </div>