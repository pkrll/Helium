                <div class="split-view">
                    <div class="left-view">

                        <div class="quick-menu">
                            <a href="/user/admin"><div class="quick-menu-button">All users</div></a>
                            <?php if ($edit) { ?>
                            <a href="/user/edit/<?=$user['id']?>"><div class="quick-menu-button active">Edit user</div></a>
                            <?php } else { ?>
                            <a href="/user/add"><div class="quick-menu-button active">Add user</div></a>
                            <?php } ?>
                            <a href="/user/permissions"><div class="quick-menu-button">Permissions</div></a>
                        </div>

                        <div class="stylized-form">
                            <div class="stylized-form-header">
                                Add a new user
                            </div>
                            <?php if ($edit) { ?>
                            <form id="user" action="/user/edit/<?=$user['id']?>" method="POST">
                            <input type="hidden" name="id" value="<?=$user['id']?>" />
                            <?php } else { ?>
                            <form id="user" action="/user/add" method="POST">
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

                            <div class="stylized-form-row" id="dragzone">
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
                                        <img id="profile-image" src="/public/images/system/profile_unknown.png"/>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="input">
                                    <div>Drag and drop profile picture here, or add by using the button below. The image must be below 2 MB.</div>
                                    <div><input type="file" name="image" /></div>
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
                </div>
                <script type="text/javascript">
                    $("#dragzone").dropify({
                        url: "/upload/image/profile/stream",
                        consecutiveLimit: 1,
                        onReady: function (response) {
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
