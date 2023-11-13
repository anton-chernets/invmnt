<?php

namespace Tests\Feature;

use App\Repositories\BanknoteRepository;
use App\Repositories\CoinRepository;
use App\Services\Banknote\ParseBanknotesBankGovUaService;
use App\Services\Coin\ParseCoinsBankGovUaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ParsingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var BanknoteRepository|MockObject
     */
    private $banknoteRepositoryMock;

    /**
     * @var CoinRepository|MockObject
     */
    private $coinRepositoryMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Створюємо макет репозиторіїв для імітації залежностей
        $this->banknoteRepositoryMock = $this->createMock(BanknoteRepository::class);
        $this->coinRepositoryMock = $this->createMock(CoinRepository::class);
    }

    public function testParseBanknotesData()
    {
        // Встановлюємо очікування, що методи репозиторію будуть викликані принаймні один раз.
        $this->banknoteRepositoryMock->expects($this->atLeastOnce())
            ->method('getByName');

        $this->banknoteRepositoryMock->expects($this->atLeastOnce())
            ->method('create');

//        $this->banknoteRepositoryMock->expects($this->atLeastOnce())
//            ->method('update');

        // Створюємо екземпляр сервісу і передаємо йому макет репозиторію.
        $parseService = new ParseBanknotesBankGovUaService($this->banknoteRepositoryMock);

        // Викликаємо метод, який тестуємо.
        $parseService->parseBanknotesData();

        // Перевіряємо, що очікування з макет репозиторію були виконані.
        $this->assertTrue(true);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \Exception
     */
    public function testParseCoinsData()
    {
        // Встановлюємо очікування, що методи репозиторію будуть викликані принаймні один раз.
        $this->coinRepositoryMock->expects($this->atLeastOnce())
            ->method('getByName');

        $this->coinRepositoryMock->expects($this->atLeastOnce())
            ->method('create');

//        $this->coinRepositoryMock->expects($this->atLeastOnce())
//            ->method('update');

        // Створюємо екземпляр сервісу і передаємо йому макет репозиторію.
        $parseService = new ParseCoinsBankGovUaService($this->coinRepositoryMock);

        // Викликаємо метод, який тестуємо.
        $parseService->parseCoinsData();

        // Перевіряємо, що очікування з макет репозиторію були виконані.
        $this->assertTrue(true);
    }
}
