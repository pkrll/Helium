
                <div id="content">
                    <div class="content-full">
                        <div id="sub-menu">
                            <ul>
                                <li><a href="/admin/users">All users</a></li>
                                <?php if ($edit) { ?>
                                <li><a href="/admin/users/add">Add user</a></li>
                                <li class="active">Edit user</li>
                                <?php } else { ?>
                                <li class="active">Add user</li>
                                <?php } ?>
                                <li><a href="/admin/permissions">Permissions</a></li>
                            </ul>
                        </div>

                        <div class="stylized-form">
                            <div class="stylized-form-header">
                            <?php if ($edit) { ?>
                                Edit user
                            <?php } else { ?>
                                Add a new user
                            <?php } ?>
                            </div>
                            <?php if ($edit) { ?>
                            <form id="user" action="/admin/users/edit/<?=$user['id']?>" method="POST">
                            <input type="hidden" name="id" value="<?=$user['id']?>" />
                            <?php } else { ?>
                            <form id="user" action="/admin/users/add" method="POST">
                            <?php } ?>
                            <div class="stylized-form-row">
                                <div class="label">
                                    username
                                </div>
                                <div class="input tooltip-container">
                                    <input type="text" name="username" required="required" value="<?=$user['username']?>" />
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    firstname
                                </div>
                                <div class="input tooltip-container">
                                    <input type="text" name="firstname" required="required" value="<?=$user['firstname']?>" />
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    lastname
                                </div>
                                <div class="input">
                                    <input type="text" name="lastname" value="<?=$user['lastname']?>" />
                                </div>
                            </div>

                            <div class="stylized-form-row">
                                <div class="label">
                                    password
                                </div>
                                <div class="input tooltip-container">
                                <?php if ($edit) { ?>
                                    <input type="password" name="password" />
                                <?php } else { ?>
                                    <input type="password" name="password" required="required"/>
                                <?php } ?>
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
                                                    $selected = ($user['permission'] == $role['id']) ? " selected" : "";
                                            ?>
                                            <option value="<?=$role['id']?>"<?=$selected?>><?=$role['name']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="stylized-form-row" class="dropster-target-area" id="dragzone">
                                <div class="label">
                                    <div class="profile-image-container">
                                        <?php
                                            if (!empty($user['image_name'])) {
                                        ?>
                                        <img id="profile-image" src="/public/images/uploads/profile/<?=$user['image_name']?>" />
                                        <input type="hidden" name="image_id" value="<?=$user['image_id']?>" />
                                        <?php
                                            } else {
                                        ?>
                                        <img id="profile-image" src="/public/images/system/ninja.png"/>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="input">
                                    <div>Drag and drop profile picture here, or add by using the button below. The image must be below 2 MB.</div>
                                    <div><input type="file" id="image" /></div>
                                </div>
                            </div>
                            <div class="stylized-form-row last-row">
                                <div class="input">
                                    <span class="submit-error"></span>
                                    <input type="submit" value="Save" class="button" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script type="text/javascript">
                    $("#dragzone").dropster({
                        url: "/upload/image/profile/stream",
                        uploadLimit: 1,
                        onReady: function (response) {
                            this.defaultOnReady();
                            var image = jQuery.parseJSON(response);
                            if (image.error) {
                                $.fn.createErrorMessage(image.error.message);
                            } else {
                                var profileImage = $("#profile-image");
                                profileImage.attr({"src": image.path});
                                if ($("input[name='image_id']").length > 0) {
                                    $("input[name='image_id']").attr({
                                        "value": image.id
                                    });
                                } else {
                                    $("<input>").attr({
                                        "type"  : "hidden",
                                        "value" : image.id,
                                        "name"  : "image_id"
                                    }).appendTo(profileImage.parent());
                                }
                            }
                        }
                    });
                </script>
