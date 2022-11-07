<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <!-- Sidebar Header -->
        <?= $this->include('web/layouts/sidebar_header'); ?>

        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3" id="avatar-sidebar">
                    <img src="<?= base_url('media/photos/talao.jpg'); ?>" alt="" srcset="">
                </div>
                <div class="p-2 d-flex justify-content-center">Hello, Visitor!</div>
                <ul class="menu">

                    <li class="sidebar-item <?= ($uri1 == 'index') ? 'active' : '' ?>">
                        <a href="/web" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span>Home</span>
                        </a>
                    </li>

                    <!-- Object -->

                    <li class="sidebar-item <?= ($uri1 == 'tracking') ? 'active' : '' ?>">
                        <a href="<?= base_url('/web/tracking'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-bridge-water"></i><span>Tracking Mangrove</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= ($uri1 == 'talao') ? 'active' : '' ?>">
                        <a href="<?= base_url('/web/talao'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-water"></i><span>Estuaria/Talao</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= ($uri1 == 'event') ? 'active' : '' ?>">
                        <a href="<?= base_url('/web/event'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-bullhorn"></i><span>Event</span>
                        </a>
                    </li>

                    <!-- Package -->
                    <li class="sidebar-item <?= ($uri1 == 'package') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <i class="fa-solid fa-square-poll-horizontal"></i><span>Package</span>
                        </a>

                        <ul class="submenu <?= ($uri1 == 'package') ? 'active' : '' ?>">
                            <!-- List Package -->
                            <li class="submenu-item" id="pa-list">
                                <a href="<?= base_url('/web/package'); ?>"><i class="fa-solid fa-list me-3"></i>List Package</a>
                            </li>
                            <li class="submenu-item has-sub" id="pa-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu" role="button" aria-expanded="false" aria-controls="subsubmenu" class="collapse"><i class="fa-solid fa-magnifying-glass me-3"></i>Search</a>
                                <ul class="subsubmenu collapse" id="subsubmenu">
                                    <!-- Package by Name -->
                                    <li class="submenu-item submenu-marker" id="pa-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNamePA" role="button" aria-expanded="false" aria-controls="searchNamePA"><i class="fa-solid fa-arrow-down-a-z me-3"></i>By Name</a>
                                        <div class="collapse mb-3" id="searchNamePA">
                                            <div class="d-grid gap-2">
                                                <input type="text" name="namePA" id="namePA" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByName('PA')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Package by Type -->
                                    <!-- <li class="submenu-item submenu-marker" id="pa-by-type">
                                        <a data-bs-toggle="collapse" href="#searchTypePA" role="button" aria-expanded="false" aria-controls="searchTypePA"><i class="fa-solid fa-check-to-slot me-3"></i>By Type</a>
                                        <div class="collapse mb-3" id="searchTypePA">
                                            <div class="d-grid">
                                                <script>
                                                    getType();
                                                </script>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="typePASelect">
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByType('PA')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li> -->
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item <?= ($uri1 == 'ulakan') ? 'active' : '' ?>">
                        <a href="<?= base_url('/web/ulakan'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-map"></i><span>Explore Ulakan</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>