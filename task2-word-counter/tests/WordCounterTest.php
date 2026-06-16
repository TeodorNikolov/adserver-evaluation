<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/WordCounter.php';

class WordCounterTest extends TestCase
{
    private string $file = __DIR__ . '/test.json';

    protected function setUp(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    protected function tearDown(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    public function testWordCounting(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("Love grows where kindness lives.");
        $counter->addText("Kindness lives in every heart.");

        $this->assertEquals(2, $counter->getCount("kindness"));
        $this->assertEquals(2, $counter->getCount("lives"));
        $this->assertEquals(1, $counter->getCount("heart"));
    }

    public function testGetAll(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("Love grows where kindness lives.");

        $all = $counter->getAll();

        $this->assertArrayHasKey("love", $all);
        $this->assertEquals(1, $all["love"]);
    }

    public function testCaseInsensitiveCounting(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("LOVE Love love");

        $this->assertEquals(3, $counter->getCount("love"));
        $this->assertEquals(3, $counter->getCount("LOVE"));
    }

    public function testPunctuationIsIgnored(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("kindness, kindness. kindness!");

        $this->assertEquals(3, $counter->getCount("kindness"));
    }

    public function testUnknownWordReturnsZero(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("love grows");

        $this->assertEquals(0, $counter->getCount("missing"));
    }

    public function testEmptyStorageReturnsEmptyArray(): void
    {
        $counter = new WordCounter($this->file);

        $this->assertSame([], $counter->getAll());
    }

    public function testDataPersistsBetweenInstances(): void
    {
        $counter1 = new WordCounter($this->file);
        $counter1->addText("love");

        $counter2 = new WordCounter($this->file);

        $this->assertEquals(1, $counter2->getCount("love"));
    }
}
