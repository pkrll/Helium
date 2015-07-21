                <div class="flex-box flex-header">
                    <div class="flex-box-single">
                        Edit user
                    </div>
                </div>

                <div class="content-window">
                    <div class="content-window-float">
                        <form id="user" action="/user/edit/<?=$user['id']?>" method="POST">
                            <input type="hidden" name="id" value="<?=$user['id']?>" />
                            <div class="content-window-float-header">
                                Edit user profile
                            </div>
                            <div class="content-window-float-body">
                                <fieldset class="content-window-fieldset">
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Firstname</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="firstname" value="<?=$user['firstname']?>" required="required"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Lastname</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="lastname" value="<?=$user['lastname']?>"  />
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Username</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="username" value="<?=$user['username']?>" required="required"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Password</div>
                                            <div class="tooltip-container">
                                                <input type="password" name="password" />
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Permissions</div>
                                            <div>
                                                <label class="select tooltip-container">
                                                    <select name="permissionLevel" required="required">
                                                        <option value="">Set permissions level</option>
                                                        <?php
                                                            foreach ($roles as $role) {
                                                                $selected = ($user['permissionLevel'] == $role['id']) ? " selected" : "";
                                                        ?>
                                                        <option value="<?=$role['id']?>"<?=$selected?>><?=$role['name']?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="submit" class="button default" value="Save changes" />
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
