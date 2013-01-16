<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @version 0.1.0
 *
 * Library for lossless JPEG transformations, using jpegtran from Unix-like systems.
 *
 *
 * The config file has the following structure:
 *
 * $config['library_path'] = '';   // Empty if the library is in the PATH
 * $config['perfect']      = TRUE; // Indicates if the -perfect param must be appended
 * $config['maxmemory']    = '1m'; // The maxmemory value. Not appended if empty
 *
 *
 * Usage:
 *
 * $this->load->library('jpegtranlib');
 *
 * $options = array (
 *         'optimize'    => TRUE,
 *         'progressive' => TRUE,
 *         'rotate'      => '90',
 *         'copy'        => 'comments'
 *     );
 *
 * $this->jpegtranlib->modify('orig.jpg', $options);           // To modify the file itself.
 * $this->jpegtranlib->copy('orig.jpg', 'dest.jpg', $options); // To generate a modified new file.
 *
 *
 * Allowed options (read man pages for jpegtran to learn about each of them):
 *   - optimize
 *   - progressive
 *   - restart
 *   - arithmetic
 *   - flip
 *   - rotate
 *   - transpose
 *   - transverse
 *   - trim
 *   - crop
 *   - grayscale
 *   - copy
 *
 */
class JpegtranLib
{
	private $_config = array();

	private $_allowed_commands = array('optimize', 'progressive', 'restart',
			'arithmetic', 'flip', 'rotate', 'transpose', 'transverse', 'trim',
			'perfect', 'crop', 'grayscale', 'copy');

	function __construct($config = array())
	{
		$this->_config = $config;

		log_message('debug', 'JpegtranLib Class Initalized');
	}

	function modify($orig_file, $options)
	{
		return $this->copy($orig_file, $orig_file, $options);
	}

	function copy($orig_file, $dest_file, $options)
	{
		log_message('info', 'application.libraries.JpegtranLib.copy: $options='.print_r($options, TRUE));


		$path = empty($this->_config['library_path']) ? '' : rtrim($this->_config['library_path'], '/').'/';

		$cmd = $path.'jpegtran';


		// Append the global configuration

		if ($this->_config['perfect'] === TRUE)
		{
			$cmd .= ' -perfect';
		}

		if ( ! empty($this->_config['maxmemory']))
		{
			$cmd .= ' -maxmemory '.$this->_config['maxmemory'];
		}


		// Append the options

		$options = array_intersect_key($options, array_fill_keys($this->_allowed_commands, TRUE));

		foreach ($options as $command => $value)
		{
			if ($value === TRUE)
			{
				$cmd .= ' -'.$command;
			}
			elseif ($value !== FALSE)
			{
				$cmd .= ' -'.$command.' '.$value;
			}
		}


		// Append the filenames

		$cmd .= ' -outfile "'.$dest_file.'" "'.$orig_file.'"';


		// Execute the command

		$output = array();

		log_message('info', 'application.libraries.JpegtranLib.copy: cmd='.$cmd);

		exec($cmd.' 2>&1', $output, $result);


		log_message('debug', 'application.libraries.JpegtranLib.copy: exec (result: '.$result.'):'.PHP_EOL.'> '.$cmd.PHP_EOL.implode(PHP_EOL, $output));


		return $result == 0;
	}
}

/* End of file jpegtranlib.php */
/* Location: ./application/libraries/jpegtranlib.php */