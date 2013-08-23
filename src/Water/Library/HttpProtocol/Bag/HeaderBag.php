<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 22:27
 */
namespace Water\Library\HttpProtocol\Bag;
use ArrayObject;

/**
 * Class HeaderBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HeaderBag extends ParameterBag
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $input = array())
    {
        $this->normalizeHeadersName($input);
        parent::__construct($input);
    }

    public function normalizeHeadersName()
    {
    }
}
