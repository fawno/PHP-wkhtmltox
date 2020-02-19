<?php
	namespace Fawno\PHPwkhtmltox;

	use FFI;
	use Fawno\PHPwkhtmltox\wkhtmltox;

	class wkhtmltoimage extends wkhtmltox {
		protected $global_settings = null;

		protected function progress_changed ($wkhtmltoimage_converter, int $progress) {
			//echo sprintf("%3d%%\x08\x08\x08\x08", $progress);
		}

		protected function phase_changed ($wkhtmltoimage_converter) {
			//$phase = $this->wkhtmltox->wkhtmltoimage_current_phase($wkhtmltoimage_converter);
			//echo sprintf("\n%s\t", $this->wkhtmltox->wkhtmltoimage_phase_description($wkhtmltoimage_converter, $phase));
		}

		protected function error ($wkhtmltoimage_converter, string $msg) {
			//echo sprintf("Error: %s\n", $msg);
		}

		protected function warning ($wkhtmltoimage_converter, string $msg) {
			//echo sprintf("Warning: %s\n", $msg);
		}

		public function __construct (string $lib_path) {
			parent::__construct($lib_path);

			$this->wkhtmltox->wkhtmltoimage_init(false);

			if ($this->wkhtmltox) {
				$this->global_settings = $this->wkhtmltox->wkhtmltoimage_create_global_settings();
			}
		}

		public function set_global_setting (string $setting_name, string $setting_value) : int {
			return $this->wkhtmltox->wkhtmltoimage_set_global_setting($this->global_settings, $setting_name, $setting_value);
		}

		public function get_global_setting (string $setting_name) {
			$len = null;
			do {
				$len += 1024;
				$setting_value = str_repeat(' ', $len);
				$this->wkhtmltox->wkhtmltoimage_get_global_setting($this->global_settings, $setting_name, $setting_value, $len);
				$setting_value = current(unpack('A*', $setting_value));
			} while ($len == strlen($setting_value) + 1);

			return $setting_value;
		}

		public function convert () {
			$converter = $this->wkhtmltox->wkhtmltoimage_create_converter($this->global_settings, null);

			$this->wkhtmltox->wkhtmltoimage_set_progress_changed_callback($converter, [$this, 'progress_changed']);
			$this->wkhtmltox->wkhtmltoimage_set_phase_changed_callback($converter, [$this, 'phase_changed']);
			$this->wkhtmltox->wkhtmltoimage_set_error_callback($converter, [$this, 'error']);
			$this->wkhtmltox->wkhtmltoimage_set_warning_callback($converter, [$this, 'warning']);

			if (!$this->wkhtmltox->wkhtmltoimage_convert($converter)) {
				return false;
			}

			if (!empty($this->get_global_setting('out'))) {
				return true;
			}

			$buffer = FFI::new('const unsigned char *');
			$len = $this->wkhtmltox->wkhtmltoimage_get_output($converter, FFI::addr($buffer));

			return FFI::string(FFI::cast('char *', $buffer), $len);
		}
	}
