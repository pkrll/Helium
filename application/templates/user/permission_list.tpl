                <div class="flex-box flex-header">
                    <div class="flex-box-single">
                        Permissions
                    </div>
                </div>

                <div class="content-window">
                    <div class="content-window-float">
                        <form id="rights" action="/user/rights" method="POST">
                            <div class="content-window-float-header">
                                Resource permissions
                            </div>
                            <div class="content-window-float-body">
                                <fieldset class="content-window-fieldset">
                                    <div class="content-window-fieldset-label">
                                        <span>Beware:</span> Changing permissions on a resource could have unintended consequences. Change with care.
                                    </div>
                                    <?php
                                        foreach ($resources AS $resource) {
                                    ?>
                                        <div class="content-window-full-width-row-container">
                                            <div class="content-window-div-row-45">
                                                <?=$resource["resource"]?>
                                                <input type="hidden" name="resource[]" value="<?=$resource['resource']?>" />
                                            </div>

                                            <div class="content-window-div-row-45">
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
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <div>
                                        <input type="submit" class="button default" value="Save" />
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                </div>
