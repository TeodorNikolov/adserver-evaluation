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

        $this->assertSame(2, $counter->getCount("kindness"));
        $this->assertSame(2, $counter->getCount("lives"));
        $this->assertSame(1, $counter->getCount("heart"));
    }

    public function testGetAll(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("Love grows where kindness lives.");

        $all = $counter->getAll();

        $this->assertArrayHasKey("love", $all);
        $this->assertSame(1, $all["love"]);
    }

    public function testCaseInsensitiveCounting(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("LOVE Love love");

        $this->assertSame(3, $counter->getCount("love"));
        $this->assertSame(3, $counter->getCount("LOVE"));
    }

    public function testPunctuationIsIgnored(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("kindness, kindness. kindness!");

        $this->assertSame(3, $counter->getCount("kindness"));
    }

    public function testUnknownWordReturnsZero(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("love grows");

        $this->assertSame(0, $counter->getCount("missing"));
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

        $this->assertSame(1, $counter2->getCount("love"));
    }

    public function testMultipleOccurrencesInSingleRequest(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("love love love love");

        $this->assertSame(4, $counter->getCount("love"));
    }

    public function testUnicodeWords(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("България България София");

        $this->assertSame(2, $counter->getCount("българия"));
        $this->assertSame(1, $counter->getCount("софия"));
    }

    public function testNumbersAreCounted(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("PHP8 PHP8 version2");

        $this->assertSame(2, $counter->getCount("php8"));
        $this->assertSame(1, $counter->getCount("version2"));
    }

    public function testEmptyTextProducesNoWords(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("");

        $this->assertSame([], $counter->getAll());
    }

    public function testWhitespaceOnlyInputProducesNoWords(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("   \n\t   ");

        $this->assertSame([], $counter->getAll());
    }

    public function testWordsAreSortedAlphabetically(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("zebra apple banana");

        $this->assertSame(
            ['apple', 'banana', 'zebra'],
            array_keys($counter->getAll())
        );
    }

    public function testCorruptedJsonIsHandledGracefully(): void
    {
        file_put_contents($this->file, '{invalid json');

        $counter = new WordCounter($this->file);

        $this->assertSame([], $counter->getAll());
    }

    public function testWordCountsAccumulateAcrossRequests(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("apple banana");
        $counter->addText("apple");
        $counter->addText("banana banana");

        $this->assertSame(2, $counter->getCount("apple"));
        $this->assertSame(3, $counter->getCount("banana"));
    }

    public function testMixedCaseAndPunctuationTogether(): void
    {
        $counter = new WordCounter($this->file);

        $counter->addText("Hello, HELLO! hello.");

        $this->assertSame(3, $counter->getCount("hello"));
    }
}
