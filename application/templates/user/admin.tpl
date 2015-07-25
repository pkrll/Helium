                <div class="split-view">
                    <div class="left-view">

                        <div class="quick-menu">
                            <a href="/user/admin"><div class="quick-menu-button active">All users</div></a>
                            <a href="/user/add"><div class="quick-menu-button">Add user</div></a>
                            <a href="/user/rights"><div class="quick-menu-button">Permissions</div></a>
                            <div class="searchbox">
                                   <form action="/user/search/" method="GET">
                                       <input type="search" name="search" placeholder="Search for user..." />
                                   </form>
                            </div>
                        </div>

                        <div class="div-table">
                            <div class="div-table-row div-table-header">
                                <div class="header-size-2">Username</div>
                                <div class="header-size-2">Name</div>
                                <div class="header-size-1">Permissions</div>
                            </div>
                            <?php
                                foreach ($users as $key => $user) {
                            ?>
                            <div class="div-table-row div-table-content">
                                <div class="header-size-2"><a href="/user/edit/<?=$user['id']?>"><?=$user['username'];?></a></div>
                                <div class="header-size-2"><?=$user['name'];?></div>
                                <div class="header-size-1"><?=$user['permissionLevel'];?></div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>

                    </div>
                </div>
