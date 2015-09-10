
                <div id="content">
                    <div class="content-full">
                        <div id="sub-menu">
                            <ul>
                                <li><a href="/admin/users">All users</a></li>
                                <li><a href="/admin/users/add">Add user</a></li>
                                <li class="active">Permissions</li>
                            </ul>
                        </div>

                        <div class="stylized-form">
                            <div class="stylized-form-header">
                                Set permissions
                            </div>
                            <form id="rights" action="/admin/permissions" method="POST">
                            <?php
                                foreach ($resources AS $resource) {
                            ?>
                                <div class="stylized-form-row">
                                    <div class="label">
                                        <?=$resource["resource"]?>
                                    </div>
                                    <div class="input">
                                        <label class="select">
                                            <select name="permission[]">
                                                <option value="0">Set permission level (none)</option>
                                                <?php
                                                    foreach ($roles as $role) {
                                                        $selected   = ($resource["permission"]["permissionLevel"] === $role['id'])
                                                                    ? " selected"
                                                                    : "";
                                                ?>
                                                <option value="<?=$role['id']?>"<?=$selected?>><?=$role['id']?> &mdash; <?=$role['name']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </label>
                                        <input type="hidden" name="resource[]" value="<?=$resource['resource']?>" />
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="stylized-form-row next-to-last-row">
                                <div class="input">
                                    <div class="beware-label">Changing permissions on a resource could have unintended consequences. </div>
                                </div>
                            </div>
                                <div class="stylized-form-row last-row">
                                    <div class="input">
                                        <input type="submit" value="Save" class="button" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
