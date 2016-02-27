<?php
namespace Application\Service;
use Application\Exceptions\NotFoundException;
use Application\Service\Config;

/**
 * Class View
 *
 * @package Application\Service
 */
class View {

    /**
     * File source template
     *
     * @var string $file
     */
    protected $file;

    /**
     * FileType
     *
     * @var string $fileType
     */
    protected $fileType;

    /**
     * Output header
     *
     * @var string $header
     */
    protected $header;

    /**
     * Setting values
     *
     * @var array $values
     */
    protected $values = [];

    /**
     * Setup current template from request params
     *
     * @param array  $config
     * @param string $fileType
     */
    public function __construct(array $config, $fileType) {

        $this->fileType = $fileType;
        $this->file = $config['templates'][$this->fileType];
        $this->header = $config['headers'][$this->fileType];
    }

    /**
     * Setup variables
     *
     * @param string $key
     * @param string $value
     * @return View
     */
    public function set($key, $value) {

        $this->values[$key] = $value;
        return $this;
    }

    /**
     * Get template variables (if non exist - silent)
     */
    public function __get($name) {
        if(isset($this->values[$name])) return $this->values[$name];
        return '';
    }

    /**
     * Output content
     *
     * @return mixed|string
     */
    public function output() {

        if(file_exists($this->file) === false) {
            throw new NotFoundException('Template '.$this->file.' does not found');
        }

        header($this->header);
        include $this->file;
    }
}