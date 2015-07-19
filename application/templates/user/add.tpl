                <div class="flex-box flex-header">
                    <div class="flex-box-single">
                        Add user
                    </div>
                </div>

                <div class="content-window">
                    <div class="content-window-float">
                        <form id="user" action="/user/add" method="POST">
                            <div class="content-window-float-header">
                                Create profile
                            </div>
                            <div class="content-window-float-body">
                                <fieldset class="content-window-fieldset">
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Firstname</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="firstname" required="required"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Lastname</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="lastname" />
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Username</div>
                                            <div class="tooltip-container">
                                                <input type="text" name="username" required="required"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Password</div>
                                            <div class="tooltip-container">
                                                <input type="password" name="password" required="required"/>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="content-window-div-row">
                                        <label>
                                            <div>Permissions</div>
                                            <div>
                                                <label class="select tooltip-container">
                                                    <select name="permission" required="required">
                                                        <option value="">Set permissions level</option>
                                                        <?php
                                                            foreach ($roles as $role) {
                                                        ?>
                                                        <option value="<?=$role['id']?>"><?=$role['name']?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="submit" class="button default" value="Add user" />
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
