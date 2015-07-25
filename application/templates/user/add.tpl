                <div class="split-view">
                    <div class="left-view">

                        <div class="quick-menu">
                            <a href="/user/admin"><div class="quick-menu-button">All users</div></a>
                            <a href="/user/add"><div class="quick-menu-button active">Add user</div></a>
                            <a href="/user/rights"><div class="quick-menu-button">Permissions</div></a>
                        </div>

                        <div class="stylized-form">
                            <div class="stylized-form-header">
                                Add a new user
                            </div>
                            <form id="user" action="/user/add" method="POST">
                            <div class="stylized-form-row">
                                <div class="label">
                                    username
                                </div>
                                <div class="input tooltip-container">
                                    <input type="text" name="firstname" required="required"/>
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    firstname
                                </div>
                                <div class="input tooltip-container">
                                    <input type="text" name="firstname" required="required"/>
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    lastname
                                </div>
                                <div class="input">
                                    <input type="text" name="lastname" />
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    password
                                </div>
                                <div class="input tooltip-container">
                                    <input type="password" name="password" required="required"/>
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    permissions
                                </div>
                                <div class="input tooltip-container select">
                                    <label class="select">
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
                            </div>

                            <div class="stylized-form-row" id="dragzone">
                                <div style="width:30%;">

                                    <div style="border-radius: 4px;width:150px; height:150px;border:1px solid #ccc;background:rgba(245,248,249,1);display:-webkit-flex;-webkit-align-items:center;-webkit-justify-content:center;">
                                        <img src="https://cdn1.iconfinder.com/data/icons/user-pictures/100/unknown-128.png"/>
                                    </div>
                                </div>
                                <div style="width:59%; height:150px;display:-webkit-flex;-webkit-justify-content:space-around;-webkit-flex-direction:column;">
                                    <div style="font-size:14px;">
                                        Drag and drop profile picture here, or add by using the button below. The image must be below 2 MB.
                                    </div>
                                    <div style="">
                                        <input type="file" />
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $("#dragzone").dropify();
                            </script>
                            <div class="stylized-form-row last-row">
                                <div class="input">
                                    <input type="submit" value="Add user" class="button" />
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- <div class="flex-box flex-header">
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
                </div> -->
