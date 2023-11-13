<?php

namespace Tests\Feature;

use App\Repositories\BanknoteRepository;
use App\Repositories\CoinRepository;
use App\Services\Banknote\ParseBanknotesBankGovUaService;
use App\Services\Coin\ParseCoinsBankGovUaService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ParsingTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var BanknoteRepository|MockObject
     */
    private $banknoteRepositoryMock;

    /**
     * @var CoinRepository|MockObject
     */
    private $coinRepositoryMock;
    private static $threadId;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->banknoteRepositoryMock = $this->createMock(BanknoteRepository::class);
        $this->coinRepositoryMock = $this->createMock(CoinRepository::class);

        self::$threadId = getmypid();
    }

    public function testParseBanknotesData(): void
    {
        echo "Executing testParseBanknotesData in thread/process " . self::$threadId . PHP_EOL;

        $this->banknoteRepositoryMock->expects($this->atLeastOnce())
            ->method('getByName');
        $this->banknoteRepositoryMock->expects($this->atLeastOnce())
            ->method('create');

        $parseService = new ParseBanknotesBankGovUaService($this->banknoteRepositoryMock);
        $parseService->parseBanknotesData();

        $this->assertTrue(true);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \Exception
     */
    public function testParseCoinsData(): void
    {
        echo "Executing testParseCoinsData in thread/process " . self::$threadId . PHP_EOL;

        $this->coinRepositoryMock->expects($this->atLeastOnce())
            ->method('getByName');
        $this->coinRepositoryMock->expects($this->atLeastOnce())
            ->method('create');

        $parseService = new ParseCoinsBankGovUaService($this->coinRepositoryMock);
        $parseService->parseCoinsData();

        $this->assertTrue(true);
    }
}
