<?php

namespace CrystalCode\Php\Common\Scaffolding\Instructions;

use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{

    /**
     *
     * @covers CrystalCode\Php\Common\Scaffolding\Instructions\Processor::__construct()
     * @return void
     */
    public function __constructTest(): void
    {
        $processor = new InstructionProcessor();
        $this->assertInstanceOf(InstructionProcessor::class, $processor);
    }

    /**
     *
     * @covers CrystalCode\Php\Common\Scaffolding\Instructions\Processor::processInstruction()
     * @return void
     */
    public function processInstructionTest(): void
    {
        $this->markTestSkipped('Test not implemented.');
    }

    /**
     *
     * @covers CrystalCode\Php\Common\Scaffolding\Instructions\Processor::getHandlerDelegateProviders()
     * @return void
     */
    public function getHandlerDelegateProvidersTest(): void
    {
        $this->markTestSkipped('Test not implemented.');
    }

    /**
     *
     * @covers CrystalCode\Php\Common\Scaffolding\Instructions\Processor::processInstructions()
     * @return void
     */
    public function processInstructionsTest(): void
    {
        $this->markTestSkipped('Test not implemented.');
    }

}
