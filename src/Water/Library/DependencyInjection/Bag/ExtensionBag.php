<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 13:44
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class ExtensionBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ExtensionBag extends SimpleBag
{
    public function fromArray(array $input)
    {
        $validExtensions   = array();
        $invalidExtensions = array();
        foreach ($input as $id => $extension) {
            if (is_a($extension, '\Water\Library\DependencyInjection\Extension\ExtensionInterface')) {
                $validExtensions[$id] = $extension;
            } else {
                $invalidExtensions[$id] = $extension;
            }
        }

        if (empty($invalidExtensions)) {
            return parent::fromArray($validExtensions);
        }

        $message = "Invalid extensions:\n";
        foreach ($invalidExtensions as $id => $extension) {
            $message .= sprintf(
                "%s => %s\n",
                $id,
                (is_object($extension)) ? get_class($extension) : sprintf('%s value "%s"', gettype($extension), $extension)
            );
        }
        throw new InvalidArgumentException($message);
    }
}