
            <div id="form-container" style="">
                <form id="article" action="/admin/" method="post">
                    <div id="left-side">
                            <fieldset>
                                <legend>Headline:</legend>
                                <input maxlength="140" type="text" name="headline" id="headline" autocomplete="off" required />
                                <div class="add-input headline">
                                    <span>+</span> Add small headline
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Preamble:</legend>
                                <textarea name="preamble" id="preamble" required></textarea>
                            </fieldset>

                            <fieldset>
                                <legend>Body:</legend>
                                <textarea name="body" id="body" required></textarea>
                            </fieldset>

                            <div class="section">
                                <fieldset>
                                    <legend class="section">images</legend>
                                    <div class="subsection">
                                        <div>Cover</div>
                                    </div>
                                </fieldet>
                            </div>

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
                                        <div>Tags</div>
                                        <input type="text" name="tags" id="tags" placeholder="HTML5, PHP programming, fun ..." />
                                    </label>
                                </div>

                                <div class="subsection">
                                    <label>
                                        <div>Internal links</div>
                                        <input type="text" name="links[]" placeholder="Search for article..." />
                                    </label>
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
                                        <div>Fact box</div>
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
                                        <div>Publish on</div>
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
