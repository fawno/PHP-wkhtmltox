<?php
	namespace Fawno\PHPwkhtmltox;

	use FFI;

	class wkhtmltox {
		protected $wkhtmltox = null;
		const HEADER = '
			struct wkhtmltoimage_global_settings;
			typedef struct wkhtmltoimage_global_settings wkhtmltoimage_global_settings;

			struct wkhtmltoimage_converter;
			typedef struct wkhtmltoimage_converter wkhtmltoimage_converter;

			typedef void (*wkhtmltoimage_str_callback)(wkhtmltoimage_converter * converter, const char * str);
			typedef void (*wkhtmltoimage_int_callback)(wkhtmltoimage_converter * converter, const int val);
			typedef void (*wkhtmltoimage_void_callback)(wkhtmltoimage_converter * converter);

			int wkhtmltoimage_init(int use_graphics);
			int wkhtmltoimage_deinit();
			int wkhtmltoimage_extended_qt();
			const char *wkhtmltoimage_version();

			wkhtmltoimage_global_settings * wkhtmltoimage_create_global_settings();

			int wkhtmltoimage_set_global_setting(wkhtmltoimage_global_settings * settings, const char * name, const char * value);
			int wkhtmltoimage_get_global_setting(wkhtmltoimage_global_settings * settings, const char * name, char * value, int vs);

			wkhtmltoimage_converter * wkhtmltoimage_create_converter(wkhtmltoimage_global_settings * settings, const char * data);
			void wkhtmltoimage_destroy_converter(wkhtmltoimage_converter * converter);

			void wkhtmltoimage_set_warning_callback(wkhtmltoimage_converter * converter, wkhtmltoimage_str_callback cb);
			void wkhtmltoimage_set_error_callback(wkhtmltoimage_converter * converter, wkhtmltoimage_str_callback cb);
			void wkhtmltoimage_set_phase_changed_callback(wkhtmltoimage_converter * converter, wkhtmltoimage_void_callback cb);
			void wkhtmltoimage_set_progress_changed_callback(wkhtmltoimage_converter * converter, wkhtmltoimage_int_callback cb);
			void wkhtmltoimage_set_finished_callback(wkhtmltoimage_converter * converter, wkhtmltoimage_int_callback cb);
			int wkhtmltoimage_convert(wkhtmltoimage_converter * converter);
			/* void wkhtmltoimage_begin_conversion(wkhtmltoimage_converter * converter); */
			/* void wkhtmltoimage_cancel(wkhtmltoimage_converter * converter); */

			int wkhtmltoimage_current_phase(wkhtmltoimage_converter * converter);
			int wkhtmltoimage_phase_count(wkhtmltoimage_converter * converter);
			const char * wkhtmltoimage_phase_description(wkhtmltoimage_converter * converter, int phase);
			const char * wkhtmltoimage_progress_string(wkhtmltoimage_converter * converter);
			int wkhtmltoimage_http_error_code(wkhtmltoimage_converter * converter);
			long wkhtmltoimage_get_output(wkhtmltoimage_converter * converter, const unsigned char **);

			struct wkhtmltopdf_global_settings;
			typedef struct wkhtmltopdf_global_settings wkhtmltopdf_global_settings;

			struct wkhtmltopdf_object_settings;
			typedef struct wkhtmltopdf_object_settings wkhtmltopdf_object_settings;

			struct wkhtmltopdf_converter;
			typedef struct wkhtmltopdf_converter wkhtmltopdf_converter;

			typedef void (*wkhtmltopdf_str_callback)(wkhtmltopdf_converter * converter, const char * str);
			typedef void (*wkhtmltopdf_int_callback)(wkhtmltopdf_converter * converter, const int val);
			typedef void (*wkhtmltopdf_void_callback)(wkhtmltopdf_converter * converter);

			int wkhtmltopdf_init(int use_graphics);
			int wkhtmltopdf_deinit();
			int wkhtmltopdf_extended_qt();
			const char * wkhtmltopdf_version();

			wkhtmltopdf_global_settings * wkhtmltopdf_create_global_settings();
			void wkhtmltopdf_destroy_global_settings(wkhtmltopdf_global_settings *);

			wkhtmltopdf_object_settings * wkhtmltopdf_create_object_settings();
			void wkhtmltopdf_destroy_object_settings(wkhtmltopdf_object_settings *);

			int wkhtmltopdf_set_global_setting(wkhtmltopdf_global_settings * settings, const char * name, const char * value);
			int wkhtmltopdf_get_global_setting(wkhtmltopdf_global_settings * settings, const char * name, char * value, int vs);
			int wkhtmltopdf_set_object_setting(wkhtmltopdf_object_settings * settings, const char * name, const char * value);
			int wkhtmltopdf_get_object_setting(wkhtmltopdf_object_settings * settings, const char * name, char * value, int vs);


			wkhtmltopdf_converter * wkhtmltopdf_create_converter(wkhtmltopdf_global_settings * settings);
			void wkhtmltopdf_destroy_converter(wkhtmltopdf_converter * converter);

			void wkhtmltopdf_set_warning_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_str_callback cb);
			void wkhtmltopdf_set_error_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_str_callback cb);
			void wkhtmltopdf_set_phase_changed_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_void_callback cb);
			void wkhtmltopdf_set_progress_changed_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_int_callback cb);
			void wkhtmltopdf_set_finished_callback(wkhtmltopdf_converter * converter, wkhtmltopdf_int_callback cb);
			/* void wkhtmltopdf_begin_conversion(wkhtmltopdf_converter * converter); */
			/* void wkhtmltopdf_cancel(wkhtmltopdf_converter * converter); */
			int wkhtmltopdf_convert(wkhtmltopdf_converter * converter);
			void wkhtmltopdf_add_object(
				wkhtmltopdf_converter * converter, wkhtmltopdf_object_settings * setting, const char * data);

			int wkhtmltopdf_current_phase(wkhtmltopdf_converter * converter);
			int wkhtmltopdf_phase_count(wkhtmltopdf_converter * converter);
			const char * wkhtmltopdf_phase_description(wkhtmltopdf_converter * converter, int phase);
			const char * wkhtmltopdf_progress_string(wkhtmltopdf_converter * converter);
			int wkhtmltopdf_http_error_code(wkhtmltopdf_converter * converter);
			long wkhtmltopdf_get_output(wkhtmltopdf_converter * converter, const unsigned char **);
		';

		public function __construct (string $lib_path) {
			$this->wkhtmltox = FFI::cdef(self::HEADER, $lib_path);
		}

		function __destruct () {
			$this->wkhtmltox->wkhtmltoimage_deinit();
		}
	}
