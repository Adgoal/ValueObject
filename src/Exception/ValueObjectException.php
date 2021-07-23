<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Exception;

use AdgoalCommon\Base\Domain\Exception\ParentExceptionTrait;
use LogicException;
use Throwable;

/**
 * Class ValueObjectException
 * @package AdgoalCommon\ValueObject\Exception
 */
class ValueObjectException extends LogicException
{
    use ParentExceptionTrait;

    /**
     * @var string
     */
    private $childClass;

    public function __construct($message = "", $childClass = null, Throwable $previous = null)
    {
        $this->childClass = $childClass;
        parent::__construct($message, 0, $previous);
    }

    /**
     * @return string
     */
    public function getChildClass(): string
    {
        return $this->childClass;
    }

}
