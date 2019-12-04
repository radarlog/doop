<?php

declare(strict_types=1);

namespace Radarlog\Doop\Tests\Infrastructure\Http\Form;

use Radarlog\Doop\Infrastructure\Http\Form\UploadType;
use Symfony\Component\Form;

class UploadTypeTest extends Form\Test\TypeTestCase
{
    private Form\FormInterface $form;

    /** @var Form\FormView[] */
    private array $children;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = $this->factory->create(UploadType::class);

        $this->children = $this->form->createView()->children;
    }

    public function testElements(): void
    {
        self::assertCount(2, $this->children);
        self::assertArrayHasKey('image', $this->children);
        self::assertArrayHasKey('submit', $this->children);
    }

    /**
     * @psalm-suppress MissingPropertyType
     */
    public function testSubmitButton(): void
    {
        $submit = $this->children['submit']->vars;

        self::assertSame('submit', $submit['name']);
    }

    /**
     * @psalm-suppress MissingPropertyType
     */
    public function testFileInput(): void
    {
        $image = $this->children['image']->vars;

        self::assertSame('image', $image['name']);
        self::assertSame('file', $image['type']);
    }

    public function testSubmit(): void
    {
        $this->form->submit(['image' => true, 'submit' => true]);

        self::assertTrue($this->form->isValid());
        self::assertTrue($this->form->isSubmitted());
    }
}
