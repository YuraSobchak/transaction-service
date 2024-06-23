<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Symfony\Parser;

use App\Infrastructure\FileSystem\Txt\TxtParserProvider;
use App\Infrastructure\Symfony\Parser\ParserLoaderAdapter;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ParserLoaderAdapterTest extends KernelTestCase
{
    private ParserLoaderAdapter $parserLoaderAdapter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parserLoaderAdapter = self::getContainer()->get(ParserLoaderAdapter::class);
    }

    public static function getParserProvider(): iterable
    {
        yield 'txt parser provider' => ['txt', TxtParserProvider::class];
    }

    #[DataProvider('getParserProvider')]
    public function testLoadParser(string $format, string $expectedClass): void
    {
        $parserProvider = $this->parserLoaderAdapter->loadParser($format);

        Assert::assertInstanceOf($expectedClass, $parserProvider);
    }

    public function testLoadParserException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->parserLoaderAdapter->loadParser('notexists');
    }
}
