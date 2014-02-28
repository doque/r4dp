<?
class RequestValidator {
	private $errors;
	public function __construct() {
		$this->errors = array();
	}
	
	// extended = true means all errors are reported if there are more, each error field is an array then
	public function getErrors($extended = false) {
		if ($extended) {
			$errors = $this->errors;
		} else {
			$errors = array();
			foreach ( $this->errors as $field => $messages ) {
				$errors[$field] = array_shift($messages);
			}
		}
		return $errors;
	}
	public function isValid() {
		return count($this->errors) === 0;
	}
	public function numeric($field, $value, $message = '') {
		return is_numeric($value);
	}
	
	public function notEmpty($field, $value, $message = '') {
		if (trim($value) === '')
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function inArray($field, $needle, $haystack, $message = '') {
		if (! in_array($needle, $haystack))
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function inArrayKeys($field, $needle, $haystack, $message = '') {
		if (! array_key_exists($needle, $haystack))
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function minLength($field, $value, $min, $message = '') {
		if (strlen($value) < $min)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function maxLength($field, $value, $max, $message = '') {
		if (strlen($value) > $max)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function rangeLength($field, $value, $min, $max, $message = '') {
		$len = strlen($value);
		if ($len < $min || $len > $max)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function length($field, $value, $length, $message = '') {
		if (strlen($value) != $length)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function min($field, $value, $min, $message = '') {
		if (intval($value) < $min)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function max($field, $value, $max, $message = '') {
		if (intval($value) > $max)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function range($field, $value, $min, $max, $message = '') {
		$value = intval($value);
		if ($value < $min || $value > $max)
			$this->triggerError($field, $message);
		return ! $this->hasError($field);
	}
	public function equal($field, $value, $compare, $message = '', $strict = false) {
		if ($strict) {
			if ($value !== $compare)
				$this->triggerError($field, $message);
		} else {
			if ($value != $compare)
				$this->triggerError($field, $message);
		}
		return ! $this->hasError($field);
	}
	public static function validateEmail($email, $pattern = '/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/') {
		if (preg_match($pattern, trim($email)) === 0) {
			return false;
		}
		return true;
	}
	public function triggerError($field, $message) {
		$message = empty($message) ? true : $message;
		if (! isset($this->errors[$field])) { // create new error array
			$this->errors[$field] = array(
					$message
			);
		} else { // already exists, adding additional error
			array_push($this->errors[$field], $message);
		}
	}
	
	// internal functions following
	public function hasError($field) {
		if (! isset($this->errors[$field]))
			return false;
		return true;
	}
}

?>