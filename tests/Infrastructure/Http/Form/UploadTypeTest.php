<?php
declare(strict_types=1);

namespace Radarlog\S3Uploader\Tests\Infrastructure\Http\Form;

use Radarlog\S3Uploader\Infrastructure\Http\Form\UploadType;
use Symfony\Component\Form;

class UploadTypeTest extends Form\Test\TypeTestCase
{
    /** @var Form\FormInterface */
    private $form;

    /** @var Form\FormView[] */
    private $children;

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

    public function testSubmitButton(): void
    {
        $submit = $this->children['submit']->vars;

        self::assertSame('submit', $submit['name']);
    }

    public function testFileInput(): void
    {
        $image = $this->children['image']->vars;

        self::assertSame('image', $image['name']);
        self::assertSame('file', $image['type']);
        self::assertSame('file', $image['type']);
    }

    public function testSubmit(): void
    {
        $this->form->submit(['image' => true, 'submit' => true]);

        $this->assertTrue($this->form->isValid());
        $this->assertTrue($this->form->isSubmitted());
    }
}
