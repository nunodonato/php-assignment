<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class AveragePostsPerUser extends AbstractCalculator
{
    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private $usersArray = [];

    /**
     * @var int
     */
    private $postCount = 0;

    private $posts;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $posts[] = $postTo;
        $userId = $postTo->getAuthorId();
        if (!in_array($userId, $this->usersArray)) {
            $this->usersArray[] = $userId;
        }

        $this->postCount++;
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $usersCount = count($this->usersArray);
        $value = $usersCount > 0
            ? $this->postCount / $usersCount
            : 0;

        return (new StatisticsTo())->setValue(round($value, 2));
    }
}
