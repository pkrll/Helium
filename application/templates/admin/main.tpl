
            <!-- Here begins the admin panel. Not actually a splash, but I'll rename it later. -->

            <div id="splash">
                <h1 class="splash-header"><?=ADMIN_WELCOME?>, Ardalan!</h1>
                <h2 class="splash-header"><?=ADMIN_WELCOME_SUB?></h2>
                <nav>
                    <ul id="list-menu">
                        <li>
                            <a href="/articles/create">
                                <img alt="Compose" src="/public/images/system/admin/menu/compose.png" />
                                <div class="label"><?=ADMIN_MENU_ARTICLE_ADD;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/articles/list">
                                <img alt="List" src="/public/images/system/admin/menu/article.png" />
                                <div class="label"><?=ADMIN_MENU_ARTICLE_ALL;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/front">
                                <img alt="Front" src="/public/images/system/admin/menu/front.png" />
                                <div class="label"><?=ADMIN_MENU_FRONT_EDIT;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/gallery/">
                                <img alt="Gallery" src="/public/images/system/admin/menu/image.png" />
                                <div class="label"><?=ADMIN_MENU_GALLERY;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users/">
                                <img alt="Users" src="/public/images/system/admin/menu/user.png" />
                                <div class="label"><?=ADMIN_MENU_USERS;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/settings/">
                                <img alt="Settings" src="/public/images/system/admin/menu/settings.png" />
                                <div class="label"><?=ADMIN_MENU_SETTINGS;?></div>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/user/logout">
                                <img alt="Logout" src="/public/images/system/admin/menu/logout.png" />
                                <div class="label"><?=ADMIN_MENU_LOGOUT;?></div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- admin panel end -->
