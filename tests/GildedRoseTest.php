<?php

declare(strict_types=1);

namespace tests;

use GildedRose\Category\BaseCategory;
use PHPUnit\Framework\TestCase;
use GildedRose\GildedRose;
use GildedRose\Item;

class GildedRoseTest extends TestCase
{
    /**
     * GildedRose app
     * @var GildedRose
     */
    private GildedRose $app;

    /**
     * @return GildedRose
     */
    public function getApp(): GildedRose
    {
        return $this->app;
    }

    /**
     * @param Item[] $item
     * @return self
     */
    public function setApp(array $items): self
    {
        $this->app = new GildedRose($items);
        return $this;
    }

    /**
     * Тест на правильное уменьшение дней
     * @return void
     */
    public function testSellInDecrease(): void
    {
        $sellIn = 3;
        $quality = 39;
        $itemTestCases = [
            [
                'item' => new Item(BaseCategory::SULFURAS_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 0,
                'days' => 1
            ],
            [
                'item' => new Item('+5 Dexterity Vest', $sellIn, $quality),
                'expected_decrease' => 1,
                'days' => 1
            ],
            [
                'item' => new Item(BaseCategory::BACKSTAGE_PASSES_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 1,
                'days' => 1
            ],
            [
                'item' => new Item(BaseCategory::AGED_BRIE_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 1,
                'days' => 1
            ],
            [
                'item' => new Item(BaseCategory::CONJURED_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 1,
                'days' => 1
            ],
        ];

        foreach ($itemTestCases as $testCase) {
            $this->setApp([$testCase['item']]);
            $this->isParamameterDecrementedBy('SellIn', $testCase['expected_decrease'], $testCase['days']);
        }
    }

    /**
     * Тест на правильное 'протухание' conjured продукта, когда срок хранения не закончился
     * @return void
     */
    public function testConjuredCategoryDecrementsBy2(): void
    {
        $sellIn = 3;
        $quality = 39;
        $itemTestCases = [
            [
                'item' => new Item(BaseCategory::CONJURED_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 2,
                'days' => 1
            ]
        ];

        foreach ($itemTestCases as $testCase) {
            $this->setApp([$testCase['item']]);
            $this->isParamameterDecrementedBy('Quality', $testCase['expected_decrease'], $testCase['days']);
        }
    }

    /**
     * Тест на правильное 'протухание' conjured продукта, когда срок хранения уже закончился
     * @return void
     */
    public function testConjuredCategoryDecrementsBy4(): void
    {
        $sellIn = -3;
        $quality = 39;
        $itemTestCases = [
            [
                'item' => new Item(BaseCategory::CONJURED_CATEGORY, $sellIn, $quality),
                'expected_decrease' => 4,
                'days' => 1
            ]
        ];

        foreach ($itemTestCases as $testCase) {
            $this->setApp([$testCase['item']]);
            $this->isParamameterDecrementedBy('Quality', $testCase['expected_decrease'], $testCase['days']);
        }
    }

    private function isParamameterDecrementedBy(string $parameter, int $decrBy = 1, int $days = 1): void
    {
        $getter = 'get' . $parameter;
        $initParamValues = $this->getItemParameterValues($parameter);

        for ($i = 0; $i < $days; $i++) {
            $this->app->updateQuality();
        }

        foreach ($this->app->getItems() as $key => $item) {
            $expectedVal = $initParamValues[$key];
            for ($i = 0; $i < $days; $i++) {
                $expectedVal -= $decrBy;
            }


            $this->assertEquals($expectedVal, $item->$getter());
        }
    }

    private function getItemParameterValues(string $parameter): array
    {
        $getter = 'get' . $parameter;
        $values = [];

        foreach ($this->app->getItems() as $key => $item) {
            $values[$key] = $item->$getter();
        }

        return $values;
    }
}
