<?php
/**
 * The base View generates the presentation.
 * This class renders the HTML output, while
 * also supplying it with the data from the
 * Model, via the Controller.
 *
 * Normally, there is no need for creating
 * custom Views. The base methods will be
 * enough to render the presentations.
 *
 * @author Ardalan Samimi
 */
class View {

	/**
	 * @access protected
	 * @var array
	 **/
	protected $variables = NULL;

	/**
	 * @access protected
	 * @var string
	 **/
	protected $templateDirectory;

	/**
	 * Set the template directory upon
	 * initialization.
	 */
	public function __construct() {
		$this->templateDirectory = TEMPLATES;
	}

	/**
	 * The __set magic method writes
	 * data to inaccessible properties.
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key, $value) {
		$this->variables[$key] = $value;
	}

	/**
	* The __get magic method fetches
	* from inaccessible properties.
	*
	* @param string $key
	* @return mixed
	*/
	public function __get($key) {
		return $this->variables[$key];
	}

	/**
	* Assign data to the templates.
	*
	* @param string $key
	* @param mixed $key
	*/
	public function assign($key, $value) {
		$this->variables[$key] = $value;
	}

	/**
	* Renders the presentation.
	*
	* @param string $template
	*/
	public function render($template) {
		// Get the template path, and
		// assign eventual variables
		// to the template.
		$template = $this->templateDirectory.'/'.$template;
		if($this->variables) {
			extract($this->variables);
			$this->variables = null;
		}
		ob_start();
		include $template;
		echo ob_get_clean();
	}

	public function stream($content) {
		echo $content;
	    ob_flush();
	    flush();
	}

	public function setHeader ($header) {
		foreach ($header as $key => $value)
			header($value);
	}
}
