
            <div id="form-container" style="">
                <form id="article" action="/articles/" method="post">
                    <div id="left-side">
                        <fieldset>
                            <legend>Headline</legend>
                            <input maxlength="140" type="text" name="headline" id="headline" autocomplete="off" required />
                            <div class="add-input headline">
                                <span>+</span> Add small headline
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Preamble</legend>
                            <textarea name="preamble" id="preamble" required></textarea>
                        </fieldset>

                        <fieldset>
                            <legend>Body</legend>
                            <textarea name="body" id="body" required></textarea>
                            <script>
								CKEDITOR.replace( 'body', {
									toolbar: [
										['Bold', 'Italic', 'Underline'],
										['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'],
										['RemoveFormat'],
										['Link', 'Unlink', 'Image'],
										['Format','Source'],
									],
									width:"100%",
									height:"400px",
								} );
							</script>
                        </fieldset>

                        <fieldset style="border:3px dashed rgba(0,0,0,0.2);" class="image-cover">
                            <legend>Cover image&nbsp;</legend>
                            <div id="dragzone" style="text-align:center;font-size:15px; padding:20px;width:50%;margin:auto;">
                                <div style="padding:10px 0 15px 0;">Upload image by dragging it onto this field, or use the dialog below.</div>

                                <div style="padding:10px 0 15px 0">
                                    <input type="file" id="image-cover" />
                                    <button class="image-event-button" data-type="cover" data-action="upload">Upload</button>
                                </div>

                                <div style="padding:10px 0 0 0;">
                                    <span style="color:#de1212;cursor:pointer">Choose from gallery</span>
                                    </div>

                            </div>
                        </fieldset>

                        <fieldset style="border-top:1px solid rgba(0,0,0,0.2)">
                            <legend>Slidshow&nbsp;</legend>
                            <div style="text-align:center;font-size:15px;">
                                <div style="">Upload image</div>
                                <div style="">or</div>
                                <div style="">Choose from gallery</div>
                            </div>
                        </fieldset>

                    </div>

                    <div id="right-side">
                        <div id="button" class="section">
                            <div class="button publish">
                                Publish
                            </div>
                            <div class="button preview">
                                Preview
                            </div>
                        </div>

                        <div class="section">
                            <fieldset>
                                <legend class="section">taxonomy</legend>

                                <div class="subsection">
                                    <label class="select">
                                        <select name="category" id="category">
                                            <option>Choose category</option>
                                            <option value="12">Category 1</option>
                                            <option>Category 2</option>
                                            <option>Category 3</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="subsection">
                                    <label class="select">
                                        <select name="theme" id="theme">
                                            <option>Choose theme (optional)</option>
                                            <option value="1">Theme 1</option>
                                            <option>Theme 2</option>
                                            <option>Theme 3</option>
                                        </select>
                                    </label>
                                </div>

                                <div class="subsection">
                                    <label>
                                        <div class="label">Tags</div>
                                        <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun ..." />
                                    </label>
                                </div>

                                <div class="subsection">
                                    <label>
                                        <div class="label">Internal links</div>
                                    </label>
                                        <input type="text" name="links[]" placeholder="Search for article..." />
                                    <div class="add-input">
                                        <span>+</span> Add link
                                    </div>
                                </div>

                            </fieldset>
                        </div>

                        <div class="section">
                            <fieldset>
                                <legend class="section">extra</legend>
                                <div class="subsection">
                                    <label>
                                        <div class="label">Fact box</div>
                                        <textarea name="fact" id="fact"></textarea>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <div class="section">
                            <fieldset>
                                <legend class="section">publishing options</legend>
                                <div class="subsection">
                                    <label>
                                        <div class="label">Publish on</div>
                                        <input type="date"/>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <div class="section">
                            <fieldset>
                                <legend class="section">authoring information</legend>
                                <div class="subsection">
                                    <label>
                                        <input type="text" name="author" placeholder="Add author..." />
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                    </div>
                </form>
            </div>
