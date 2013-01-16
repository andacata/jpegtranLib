# jpegtranLib #

This is a little [CodeIgniter](http://codeigniter.com) library for using **`jpegtran`** on Unix-like systems to make **JPEG lossless** transformations.

To learn about **`jpegtran`**, please read man pages on your system.

## Usage ##
	$this->load->library('jpegtranlib');
	
	$options = array (
	        'optimize'    => TRUE,
	        'progressive' => TRUE,
	        'rotate'      => '90',
	        'copy'        => 'comments'
	    );
	
	$this->jpegtranlib->modify('orig.jpg', $options);           // To modify the file itself.
	$this->jpegtranlib->copy('orig.jpg', 'dest.jpg', $options); // To generate a modified new file.

## Config file ##
The config file (`application/config/jpegtranlib.php`) has the following structure:

	$config['library_path'] = '';   // Empty if the library is in the PATH
	$config['perfect']      = TRUE; // Indicates if the -perfect param must be appended
	$config['maxmemory']    = '1m'; // The maxmemory value. Not appended if empty

##  Allowed options ##
Read man pages for **`jpegtran`** to learn about each of them:

- optimize
- progressive
- restart
- arithmetic
- flip
- rotate
- transpose
- transverse
- trim
- perfect
- crop
- grayscale
- copy

## Installation ##
1. Drop the provided files into your CodeIgniter project.
2. Configure the `library_path` parameter, if `jpegtran` is not directly accessible.
3. Configure the `maxmemory` parameter to suit your system needs.