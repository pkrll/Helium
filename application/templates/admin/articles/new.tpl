
            <div style="width:100%;display:table;">
                <!-- <div style="width:100px;border:1px solid #000;border-bottom:none;border-radius:8px 8px 0 0; padding:4px;text-align:center;background:#fff;">
                    New article
                </div> -->
                <form id="article" action="/admin/" method="post">
                    <div style="padding:8px 15px 8px 15px;display:table-cell;width:68%;">
                            <fieldset>
                                <legend>Headline:</legend>
                                <input maxlength="140" type="text" name="headline" id="headline" autocomplete="off" required />
                            </fieldset>

                            <fieldset>
                                <legend>Preamble:</legend>
                                <textarea name="preamble" id="preamble" required></textarea>
                            </fieldset>

                            <fieldset>
                                <legend>Body:</legend>
                                <textarea name="body" id="body" required></textarea>
                            </fieldset>

                            <input type="submit" />

                    </div>

                    <div style="display:table-cell;border-left:1px solid rgba(0,0,0,.2);width:26%;">
                        <div style="background:#eee;padding:18px 15px;">
                            <a href="" class="button publish" style="">
                                    Publish
                            </a>

                            <div class="button preview" style="">
                                    Preview
                            </div>
                        </div>
                        <div style="margin-top:24px;background:#ddd;padding:18px 15px;">
                            <fieldset style="">
                                <legend>V&auml;lj kategori</legend>
                                <select style="width:100%;padding:10px;">
                                    <option>A</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
