<?php
/**
 * User: Ivan C. Sanches 
 * Date: 05/11/13
 * Time: 14:29
 */
namespace Water\Library\Http;

use Water\Library\Http\Exception\InvalidArgumentException;

/**
 * Class FileDownloadResponse
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class FileDownloadResponse extends Response
{
    /**
     * @var string
     */
    private $filename = '';

    /**
     * Constructor.
     *
     * @param string $filename
     * @param int    $statusCode
     * @param array  $headers
     *
     * @throws InvalidArgumentException
     */
    public function __construct($filename, $statusCode = 200, array $headers = array())
    {
        if (!is_file($filename)) {
            throw new InvalidArgumentException(sprintf(
                ''
            ));
        }
        $this->filename   = $filename;
        $this->statusCode = $statusCode;
        $this->headers    = $headers;
    }

    /**
     * @param string $filename
     * @return FileDownloadResponse
     *
     * @throws InvalidArgumentException
     */
    public function setFilename($filename)
    {
        if (!is_file($filename)) {
            throw new InvalidArgumentException(sprintf(
                ''
            ));
        }
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function sendHeader()
    {
        if (!$this->headers->has('Content-Type')) {
            $this->headers->set('Content-Type', mime_content_type($this->filename));
        }
        return parent::sendHeader();
    }

    public function sendContent()
    {
        $this->content = file_get_contents($this->filename);
        return parent::sendContent();
    }
}