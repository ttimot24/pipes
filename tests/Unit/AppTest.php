<?php

declare(strict_types=1);

namespace jwhulette\pipes\Tests\Unit;

use Tests\TestCase;
use jwhulette\pipes\EtlPipe;
use org\bovigo\vfs\vfsStream;
use jwhulette\pipes\Loaders\CsvLoader;
use jwhulette\pipes\Extractors\CsvExtractor;
use jwhulette\pipes\Transformers\CaseTransformer;

class AppTest extends TestCase
{
    protected string $testfile;

    public function setUp(): void
    {
        $directory = [
            'csv_extractor.csv',
        ];

        $this->vfs = vfsStream::setup(sys_get_temp_dir(), null, $directory);

        $this->testfile = $this->vfs->url().'/csv_extractor.csv';
    }

    /**
     * Test the EtlPipe object gets created.
     *
     * @return void
     */
    public function testAppBoots()
    {
        $EtlPipe = new EtlPipe;
        $this->assertInstanceOf(EtlPipe::class, $EtlPipe);
    }

    /**
     * Test extractors adding to app.
     *
     * @return void
     */
    public function testExtractorAdd()
    {
        $EtlPipe = new EtlPipe;
        $EtlPipe->extract(new CsvExtractor($this->testfile));
        $this->assertInstanceOf(EtlPipe::class, $EtlPipe);
    }

    /**
     * Test extractors adding to app.
     *
     * @return void
     */
    public function testTransformsAdd()
    {
        $EtlPipe = new EtlPipe;
        $EtlPipe->extract(new CsvExtractor($this->testfile));
        $EtlPipe->transformers([
            (new CaseTransformer())->transformColumn('test', 'lower'),
        ]);
        $this->assertInstanceOf(EtlPipe::class, $EtlPipe);
    }

    public function testLoader()
    {
        $EtlPipe = new EtlPipe;
        $EtlPipe->extract(new CsvExtractor($this->testfile));
        $EtlPipe->transformers([
            (new CaseTransformer())->transformColumn('test', 'lower'),
        ]);
        $EtlPipe->load(new CsvLoader('test'));
        $this->assertInstanceOf(EtlPipe::class, $EtlPipe);
    }
}
