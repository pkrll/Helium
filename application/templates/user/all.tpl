                <div class="flex-box flex-header">
                    <div class="flex-box-single">
                        Users
                    </div>
                </div>

                <div class="content-window">
                    <div class="content-window-float">
                        <div class="content-window-float-header">
                            Edit users
                        </div>
                        <div class="content-window-float-body">
                        <?php
                            foreach ($users as $user) {
                        ?>
                            <div style="display:-webkit-flex;width:100%;">
                                <div style="width:40%;padding:10px 0 10px 0;"><a href="/user/edit/<?=$user['id']?>"><?=$user['username'];?></a></div>
                                <div style="width:40%;padding:10px 0 10px 0;"><?=$user['name'];?></div>
                                <div style="padding:10px 0 10px 0;"><?=$user['permissionLevel'];?></div>
                            </div>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
