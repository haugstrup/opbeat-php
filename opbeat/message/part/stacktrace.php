<?php

class Opbeat_Message_Part_Stacktrace implements Opbeat_Message_Part_Interface {

	private $_exception;

	public static function createByException(Exception $exception) {
		$stacktrace = new Opbeat_Message_Part_Stacktrace();
		$stacktrace->setException($exception);
		return $stacktrace;
	}

	public function __construct() {
	}

	public function setException(Exception $exception) {
		$this->_exception = $exception;
	}

	public function build() {
		return array(
			'frames' => $this->buildFramesByException($this->_exception)
		);
	}

	private function buildFramesByException(Exception $exception) {
		$frames = array();
		foreach ($exception->getTrace() as $frame) {
			$frames[] = array(
				'abs_path' => $frame['file'],
				'filename' => basename($frame['file']),
				'lineno' => $frame['line'],
				'function' => $frame['function']
			);
		}

		return $frames;
	}
}