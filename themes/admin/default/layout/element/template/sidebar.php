   <div class="sidebar" data-color="<?= $this->setting->data_color; ?>" data-background-color="<?= $this->setting->background_color; ?>" data-image="<?= $this->setting->background_image; ?>">
       <div class="logo">
           <a href="http://www.creative-tim.com" class="simple-text logo-mini">
               KM
           </a>
           <a href="<?= base_url() ?>" class="simple-text logo-normal">
               KOMINFO
           </a>
       </div>

       <div class="sidebar-wrapper">

           <div class="user">
               <div class="photo">
                   <img src="<?= getProfile($user['image'], 'thumbnail') ?>" />
               </div>

               <div class="user-info">
                   <a data-toggle="collapse" href="#userProfile" class="username">
                       <span>
                           <?= $user['name'] ?>
                           <b class="caret"></b>
                       </span>
                   </a>
                   <div class="collapse" id="userProfile">
                       <ul class="nav">
                           <?php if ($this->session->userdata('role_id') != 1) : ?>
                               <li class="nav-item <?= ($page['method'] == "profile" && $page['class'] == 'user') ? "active" : "" ?>">
                                   <a class="nav-link" href="<?= base_url('admin/user/profile') ?>">
                                       <span class="sidebar-mini"> <i class="material-icons">
                                               edit
                                           </i> </span>
                                       <span class="sidebar-normal"> My Account </span>
                                   </a>
                               </li>
                               <li class="nav-item <?= ($page['method'] == "edit" && strtolower($page['class'] == 'user')) ? "active" : "" ?>">
                                   <a class="nav-link" href="<?= base_url('admin/user/edit/') ?>">
                                       <span class="sidebar-mini"> <i class="material-icons">
                                               edit
                                           </i> </span>
                                       <span class="sidebar-normal"> Edit Account </span>
                                   </a>
                               </li>
                           <?php endif; ?>
                           <li class="nav-item <?= ($page['class'] == "Log" && !$page['method']) ? "active" : "" ?>">
                               <a class="nav-link" href="<?= base_url('admin/log/') ?>">
                                   <span class="sidebar-mini"> <i class="material-icons">
                                           cached
                                       </i> </span>
                                   <span class="sidebar-normal"> Aktivitas </span>
                               </a>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
           <ul class="nav">
               <?php
                if ($this->session->userdata('role_id') == 1) : ?>
                   <li class="nav-item <?= ($page['class'] == 'Admin' && !$page['method']) ? 'active' : ''; ?>">
                       <a class="nav-link" href="<?= base_url('admin/admin') ?>">
                           <i class="material-icons">dashboard</i>
                           <p>Dashboard</p>
                       </a>
                   </li>
               <?php else : ?>
                   <li class="nav-item <?= ($page['class'] == 'User' && !$page['method']) ? 'active' : ''; ?>">
                       <a class="nav-link" href="<?= base_url('admin/user') ?>">
                           <i class="material-icons">dashboard</i>
                           <p> Rincian </p>
                       </a>
                   </li>
               <?php endif; ?>

               <!-- QUERY MENU -->
               <?php foreach ($menu_all as $m) : ?>
                   <?php
                        if ($m['menu'] == "User" && $this->session->userdata('role_id') == 1) {
                            continue;
                        } ?>
                   <li class="nav-item">
                       <a class="nav-link" data-toggle="collapse" href="#<?= $m['menu']; ?>">
                           <?= @$m['icon']; ?>
                           <p> <?= $m['menu']; ?>
                               <b class="caret"></b>
                           </p>
                       </a>
                       <div class="collapse" id="<?= $m['menu']; ?>">
                           <ul class="nav">
                               <?php
                                    foreach ($this->menu_m->get_submenuIdMenu($m['id_menu'])->result_array() as $row) : ?>
                                   <li class="nav-item <?= is_active(strtolower($row['class']), strtolower($row['method'])) ?>">
                                       <a class="nav-link" href="<?= base_url() . $row['url']; ?>">
                                           <span class="sidebar-mini"> <?= $row['icon']; ?> </span>
                                           <span class="sidebar-normal"> <?= $row['title'] ?> </span>
                                       </a>
                                   </li>
                               <?php endforeach ?>
                           </ul>
                       </div>
                   </li>
               <?php endforeach; ?>

           </ul>
       </div>
   </div>
   <script>
       $(document).ready(function() {
           let menu = $('.nav-item.active');
           menu.parents('li.nav-item').addClass('active')
               .children('a.nav-link').attr('aria-expanded', "true");
           menu.parents('div.collapse').addClass('show');
       });
   </script>