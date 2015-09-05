
                <div id="content">
                    <div class="content-full">
                        <div id="sub-menu">
                            <ul>
                                <li class="active">All users</li>
                                <li><a href="/admin/users/add">Add user</a></li>
                                <li><a href="/admin/permissions">Permissions</a></li>
                            </ul>
                        </div>
                        <div class="div-table">
                            <div class="div-table-toolbar top">
                                <span class="font-icon"><span class="icon-cancel"></span> Remove</span>
                            </div>
                            <div class="div-table-row div-table-header">
                                <div class="header-size-3">Username</div>
                                <div class="header-size-2">Name</div>
                                <div class="header-size-2">Permissions</div>
                                <div class="header-size-1">Action</div>
                            </div>
                            <?php
                                foreach ($users as $key => $user) {
                            ?>
                            <div class="div-table-row div-table-content" data-id="<?=$user['id']?>">
                                <div class="header-size-3"><a href="/admin/users/edit/<?=$user['id']?>"><?=$user['username']?></a></div>
                                <div class="header-size-2"><?=$user['name']?></div>
                                <div class="header-size-2"><?=$user['permission']?></div>
                                <div class="header-size-1"><input type="checkbox"></div>
                            </div>
                            <?php
                                }
                            ?>
                            <div class="div-table-toolbar bottom">
                                <span class="font-icon"><span class="icon-cancel"></span> Remove</span>
                            </div>
                        </div>
                    </div>
                </div>
