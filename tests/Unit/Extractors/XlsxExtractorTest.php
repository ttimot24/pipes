<?php

declare(strict_types=1);

namespace jwhulette\pipes\Tests\Unit\Transformers;

use Tests\TestCase;
use jwhulette\pipes\Frame;
use jwhulette\pipes\Extractors\XlsxExtractor;

class XlsxExtractorTest extends TestCase
{
    public function testFrameHasHeader()
    {
        $excel = new XlsxExtractor($this->xlsxExtract);
        $frameData = $excel->extract();
        $frame = $frameData->current();
        $expected = [
            'FIRSTNAME',
            'LASTNAME',
            'DOB',
            'COST',
            'test2',
        ];

        $this->assertEquals($expected, $frame->header->values()->toArray());
    }

    public function testHasNoHeader()
    {
        $excel = new XlsxExtractor($this->xlsxExtractNoHeader);
        $frameData = $excel->setNoHeader()->extract();
        $frame = $frameData->current();
        $expected = [
            'BOB',
            'SMITH',
            '02/11/69',
            22,
            'test',
        ];

        $this->assertEquals($expected, $frame->data->toArray());
    }
}
