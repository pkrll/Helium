<?php
/**
 * The base Controller, that all other controllers
 * inherit, creates instances of both the View and
 * the Model classes, acting as a link between the
 * data layer and presentation.
 *
 * @author Ardalan Samimi
 */
class Controller {

	/**
	 * @access private
	 * @var string
	 **/
	private $name;

	/**
	 * @access private
	 * @var View
	 **/
	private $view;

	/**
	 * @access private
	 * @var Model
	 **/
	private $model;

	/**
	 * The constructor will loads the Model and
	 * the View, and also call eventual methods
	 * that were requested.
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return    void
	 */
	public function __construct($method, $arguments = NULL) {
		// Get the name of the controller (ie Main),
		// and load the Model and the View classes.
		$this->name = str_replace('Controller', '', get_class($this));
		$this->loadModel();
		$this->loadView();
		// If arguments are passed
		if (!is_null($arguments))
			$this->arguments = $arguments;
		// If the requested method does not
		// exists, call the default method
		// defined in const DEFAULT_METHOD.
		if (!method_exists($this, $method))
			$method = DEFAULT_METHOD;
		$this->$method();
	}

	/**
	 * Load the model that belongs to the
	 * requested controller.
	 */
	final private function loadModel() {
		// The Model must be named the same
		// as the controller but with Model
		// suffixed instead of Controller.
		$class = $this->name.'Model';
		$path = MODELS.'/'.$class.'.php';
		// If the Model does not exists,
		// load the base Model instead.
		if (!file_exists($path)) {
			$this->model = new Model();
		} else {
			if (!class_exists($class))
				include $path;
			$this->model = new $class();
		}
	}

	/**
	 * Load the View that belongs to the
	 * requested controller.
	 */
	final private function loadView() {
		// The View must be named the same
		// as the controller but with View
		// suffixed instead of Controller.
		$class = $this->name.'View';
		$path = VIEWS.'/'.$class.'.php';
		// If the View does not exists,
		// load the base View instead.
		if (!file_exists($path)) {
			$this->view = new View();
		} else {
			if (!class_exists($class))
				include $path;
			$this->view = new $class();
		}
	}

	/**
	 * Return the name of current Controller.
	 *
	 * @return string
	 */
	protected function name() {
		return $this->name;
	}

	/**
	 * Return the View of current Controller.
	 *
	 * @return View
	 */
	protected function view() {
		return $this->view;
	}

	/**
	 * Return the Model of current Controller.
	 *
	 * @return Model
	 */
	protected function model() {
		return $this->model;
	}
}
