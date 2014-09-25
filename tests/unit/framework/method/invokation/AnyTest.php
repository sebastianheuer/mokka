<?php
namespace Mokka\Tests;

use Mokka\Method\Invokation\Any;

class AnyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider invokationCountProvider
     * @param int $count
     */
    public function testInvokationCountIsAlwaysValid($count)
    {
        $rule = new Any();
        $this->assertTrue($rule->isValidInvokationCount($count));
    }
    
    public function testErrorMessageIsEmpty()
    {
        $rule = new Any();
        $this->assertEquals('', $rule->getErrorMessage(1));
    }

    /**
     * @return array
     */
    public static function invokationCountProvider()
    {
        return array(
            array(NULL),
            array(1),
            array(-2),
            array(999)
        );
    }
}
