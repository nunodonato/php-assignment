<?php

declare(strict_types = 1);

namespace Tests\unit\Statistics\Calculator;

use DateTime;
use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use Statistics\Builder\ParamsBuilder;
use Statistics\Calculator\AveragePostLength;

/**
 * Class AveragePostLengthTest
 *
 * @package Tests\unit
 */
class AveragePostLengthTest extends TestCase
{
    public function testDoesCalculate()
    {
        $params = ParamsBuilder::reportStatsParams(new DateTime());

        $calculator = (new AveragePostLength())
                    ->setParameters($params[0]);
                    
        $post1 = (new SocialPostTo())
            ->setId("post-1")
            ->setText("message.")
            ->setDate(new DateTime());
        $calculator->accumulateData($post1);

        $post2 = (new SocialPostTo())
            ->setId("post-2")
            ->setText("longer message")
            ->setDate(new DateTime());
        $calculator->accumulateData($post2);

        $average_length = $calculator->calculate();

        $this->assertEquals(11, $average_length->getValue());
    }
}
